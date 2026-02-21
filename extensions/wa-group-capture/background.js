const STORAGE_KEY = "group_extraction_session";

chrome.runtime.onMessage.addListener((message, sender, sendResponse) => {
    (async () => {
        if (message?.action === "GE_SAVE_CONFIG") {
            await chrome.storage.local.set({ [STORAGE_KEY]: message.payload || null });
            sendResponse({ ok: true });
            return;
        }

        if (message?.action === "GE_GET_CONFIG") {
            const data = await chrome.storage.local.get(STORAGE_KEY);
            sendResponse({ ok: true, config: data[STORAGE_KEY] || null });
            return;
        }

        if (message?.action === "GE_SIGNED_REQUEST") {
            const result = await signedRequest(message.payload || {});
            sendResponse(result);
            return;
        }

        if (message?.action === "GE_SCAN_GROUP_MEMBERS") {
            const tabId = Number(message.tabId || 0);
            if (!tabId) {
                sendResponse({ ok: false, error: "Missing tabId" });
                return;
            }

            const result = await scanGroupMembers(tabId);
            sendResponse(result);
            return;
        }

        sendResponse({ ok: false, error: "Unknown action" });
    })().catch((error) => {
        sendResponse({ ok: false, error: error?.message || "Unhandled background error" });
    });

    return true;
});

async function signedRequest(payload) {
    const {
        config,
        endpoint,
        method = "POST",
        body = {},
    } = payload;

    if (!config?.api_base || !config?.session_token || !config?.signing_secret) {
        return { ok: false, error: "Missing extension session configuration" };
    }

    const url = normalizeUrl(config.api_base, endpoint || "");
    const requestMethod = String(method || "POST").toUpperCase();
    const bodyText = requestMethod === "GET" ? "" : JSON.stringify(body || {});
    const payloadHash = await sha256Hex(bodyText);
    const timestamp = String(Math.floor(Date.now() / 1000));
    const nonce = randomToken(24);
    const path = new URL(url).pathname.replace(/^\//, "");
    const canonical = `${requestMethod}\n${path}\n${timestamp}\n${nonce}\n${payloadHash}`;
    const signature = await hmacSha256Hex(canonical, config.signing_secret);

    const response = await fetch(url, {
        method: requestMethod,
        headers: {
            "Content-Type": "application/json",
            "Authorization": `Bearer ${config.session_token}`,
            "X-GE-Session": config.session_token,
            "X-GE-Timestamp": timestamp,
            "X-GE-Nonce": nonce,
            "X-GE-Signature": signature,
        },
        body: requestMethod === "GET" ? undefined : bodyText,
    });

    const rawText = await response.text();
    let parsed = null;
    try {
        parsed = JSON.parse(rawText);
    } catch {
        parsed = null;
    }

    return {
        ok: response.ok,
        status: response.status,
        data: parsed,
        raw: rawText,
    };
}

async function scanGroupMembers(tabId) {
    // Run both scanners and pick the richer successful result.
    const mainResult = await executeScriptSafe(tabId, "MAIN", extractGroupMembersMainWorld);
    let domResult = await executeScriptSafe(tabId, "MAIN", extractGroupMembersDomFallback);
    if (!domResult?.ok || !Array.isArray(domResult?.members) || !domResult.members.length) {
        domResult = await executeScriptSafe(tabId, "ISOLATED", extractGroupMembersDomFallback);
    }

    const mainCount = Array.isArray(mainResult?.members) ? mainResult.members.length : 0;
    const domCount = Array.isArray(domResult?.members) ? domResult.members.length : 0;
    const mainOk = !!mainResult?.ok;
    const domOk = !!domResult?.ok;
    const diagnostics = {
        main: {
            ok: mainOk,
            source: mainResult?.source || "",
            count: mainCount,
            error: mainResult?.error || "",
        },
        dom: {
            ok: domOk,
            source: domResult?.source || "",
            count: domCount,
            error: domResult?.error || "",
        },
    };

    if (mainOk && domOk) {
        const chosen = domCount > mainCount ? domResult : mainResult;
        return { ...chosen, diagnostics };
    }

    if (mainOk) {
        return { ...mainResult, diagnostics };
    }

    if (domOk) {
        return { ...domResult, diagnostics };
    }

    return {
        ok: false,
        error: mainResult?.error || domResult?.error || "Failed to scan group members",
        diagnostics,
    };
}

async function executeScriptSafe(tabId, world, func) {
    try {
        const executed = await chrome.scripting.executeScript({
            target: { tabId },
            world,
            func,
        });

        return executed?.[0]?.result || null;
    } catch (error) {
        return { ok: false, error: error?.message || "script_execution_failed" };
    }
}

function extractGroupMembersMainWorld() {
    const stats = {
        invalid_count: 0,
        duplicate_count: 0,
    };

    function normalizeWhitespace(value) {
        return String(value || "").replace(/\s+/g, " ").trim();
    }

    function normalizeName(value) {
        return normalizeWhitespace(value).toLowerCase();
    }

    function cleanHash() {
        const hash = decodeURIComponent(String(window.location.hash || ""));
        return hash.replace(/^#\/?/, "").split("?")[0].trim();
    }

    function cleanPath() {
        const path = decodeURIComponent(String(window.location.pathname || ""));
        return path.replace(/^\/+/, "").split("?")[0].trim();
    }

    function normalizeGroupId(value) {
        const val = String(value || "").trim();
        if (!val) return "";
        if (val.includes("@g.us")) return val;
        const digits = val.replace(/\D+/g, "");
        return digits ? `${digits}@g.us` : val;
    }

    function resolveRequire() {
        const names = new Set();
        const addName = (name) => {
            const key = String(name || "").trim();
            if (!key) return;
            if (key.toLowerCase().includes("webpackchunk")) names.add(key);
        };

        Object.keys(window).forEach(addName);
        Object.getOwnPropertyNames(window).forEach(addName);
        Object.keys(self || {}).forEach(addName);
        Object.getOwnPropertyNames(self || {}).forEach(addName);

        addName("webpackChunkwhatsapp_web_client");
        addName("webpackChunkbuild");

        const chunkNames = Array.from(names);
        let req = window.__webpack_require__ || window.webpackRequire || null;
        if (req?.c) return req;

        for (const key of chunkNames) {
            const chunk = window[key] || self[key];
            if (!Array.isArray(chunk) || typeof chunk.push !== "function") continue;
            try {
                chunk.push([[`ge_probe_${Date.now()}_${Math.random().toString(36).slice(2)}`], {}, (r) => { req = r; }]);
            } catch (e) {}
            if (req?.c) return req;
        }
        return req;
    }

    function asArray(source) {
        if (!source) return [];
        if (Array.isArray(source)) return source;
        if (Array.isArray(source._models)) return source._models;
        if (Array.isArray(source.models)) return source.models;
        if (typeof source.toArray === "function") {
            try {
                const arr = source.toArray();
                if (Array.isArray(arr)) return arr;
            } catch (e) {}
        }
        if (typeof source.values === "function") {
            try {
                return Array.from(source.values());
            } catch (e) {}
        }
        return [];
    }

    function getSerializedId(obj) {
        if (!obj) return "";
        if (typeof obj === "string") return obj;

        const direct = [
            obj._serialized,
            obj.serialized,
            obj.id?._serialized,
            obj.id?.serialized,
            obj.wid?._serialized,
            obj.wid?.serialized,
            obj.__x_id?._serialized,
            obj.__x_wid?._serialized,
        ];

        for (const candidate of direct) {
            if (typeof candidate === "string" && candidate) return candidate;
        }

        const user = obj.user || obj.id?.user || obj.wid?.user || obj.__x_id?.user;
        const server = obj.server || obj.id?.server || obj.wid?.server || obj.__x_id?.server || "g.us";
        return user ? `${user}@${server}` : "";
    }

    function chatParticipantsDirect(chat) {
        const sources = [
            chat?.groupMetadata?.participants,
            chat?.groupMetadata?._participants,
            chat?.groupMetadata?.participantCollection,
            chat?.groupMetadata?.members,
            chat?.participants,
            chat?.__x_groupMetadata?.participants,
            chat?.__x_groupMetadata?.participantCollection,
            chat?.__x_groupMetadata?.members,
            chat?.__x_participants,
        ];
        let all = [];
        for (const source of sources) {
            const arr = asArray(source);
            if (arr.length) all = all.concat(arr);
        }
        return all;
    }

    function hasGroupParticipants(chat) {
        return chatParticipantsDirect(chat).length > 0;
    }

    function participantCount(chat) {
        return chatParticipantsDirect(chat).length;
    }

    function chatParticipantsForExtraction(chat) {
        const direct = chatParticipantsDirect(chat);
        if (direct.length) return direct;

        // Last-resort: derive participant-like ids from loaded chat object internals.
        const fragments = collectStringFragments(chat, 5, 2200).join(" ");
        const idTokens = collectIdTokens(fragments)
            .filter((token) => !String(token).includes("@g.us"));
        if (!idTokens.length) return [];

        return idTokens.map((token) => ({
            id: token,
            contact: { id: token },
        }));
    }

    function chatName(chat) {
        const pools = [
            chat?.groupMetadata?.subject,
            chat?.formattedTitle,
            chat?.name,
            chat?.__x_formattedTitle,
            chat?.__x_name,
            chat?.contact?.name,
        ];
        for (const pool of pools) {
            const value = normalizeWhitespace(pool);
            if (value) return value.slice(0, 191);
        }
        return "";
    }

    function metadataParticipantsDirect(metadata) {
        const sources = [
            metadata?.participants,
            metadata?._participants,
            metadata?.participantCollection,
            metadata?.members,
            metadata?.groupMetadata?.participants,
            metadata?.__x_participants,
            metadata?.__x_groupMetadata?.participants,
        ];
        let all = [];
        for (const source of sources) {
            const arr = asArray(source);
            if (arr.length) all = all.concat(arr);
        }
        return all;
    }

    function metadataParticipantsForExtraction(metadata) {
        const direct = metadataParticipantsDirect(metadata);
        if (direct.length) return direct;

        const fragments = collectStringFragments(metadata, 5, 2400).join(" ");
        const idTokens = collectIdTokens(fragments).filter((token) => !String(token).includes("@g.us"));
        if (!idTokens.length) return [];
        return idTokens.map((token) => ({ id: token, contact: { id: token } }));
    }

    function metadataName(metadata) {
        const pools = [
            metadata?.subject,
            metadata?.name,
            metadata?.formattedTitle,
            metadata?.groupMetadata?.subject,
            metadata?.__x_subject,
            metadata?.__x_name,
        ];
        for (const pool of pools) {
            const value = normalizeWhitespace(pool);
            if (value) return value.slice(0, 191);
        }
        return "";
    }

    function looksLikeSubtitle(value) {
        const text = normalizeWhitespace(value);
        if (!text) return false;
        return (text.match(/,/g) || []).length >= 3 || (text.match(/\+\d/g) || []).length >= 2;
    }

    function getUiGroupTitle() {
        const selectors = [
            "#main header [data-testid='conversation-info-header-chat-title']",
            "#main header span[title]",
            "header span[dir='auto'][title]",
            "header [title]",
        ];
        const candidates = [];
        for (const selector of selectors) {
            const nodes = document.querySelectorAll(selector);
            nodes.forEach((node) => {
                const value = normalizeWhitespace(node.getAttribute?.("title") || node.textContent || "");
                if (value) candidates.push(value.slice(0, 191));
            });
        }
        const unique = Array.from(new Set(candidates));
        const nonSubtitle = unique.filter((item) => !looksLikeSubtitle(item));
        if (nonSubtitle.length) {
            nonSubtitle.sort((a, b) => a.length - b.length);
            return nonSubtitle[0];
        }
        if (unique.length) {
            unique.sort((a, b) => a.length - b.length);
            return unique[0];
        }
        return "";
    }

    function collectGroupIdHints() {
        const regex = /(\d{8,25}@g\.us)/g;
        const hints = new Map();

        function addHint(raw, weight) {
            const id = normalizeGroupId(raw);
            if (!id || !id.includes("@g.us")) return;
            const prev = hints.get(id) || 0;
            hints.set(id, prev + weight);
        }

        const strongRoots = [
            ...document.querySelectorAll("[aria-selected='true']"),
            ...document.querySelectorAll("#main header"),
            ...document.querySelectorAll("[data-testid='conversation-info-header']"),
        ];

        strongRoots.forEach((root) => {
            const html = String(root?.outerHTML || "");
            let match;
            while ((match = regex.exec(html)) !== null) {
                addHint(match[1], 8);
            }
            regex.lastIndex = 0;
        });

        const allNodes = document.querySelectorAll("[data-id], [data-jid], [id], a[href]");
        for (let i = 0; i < allNodes.length && i < 2400; i += 1) {
            const node = allNodes[i];
            const attrs = node.getAttributeNames ? node.getAttributeNames() : [];
            let localWeight = 1;
            if (node.closest("[aria-selected='true']")) localWeight += 2;
            if (node.closest("#main")) localWeight += 1;
            for (const attr of attrs) {
                const value = String(node.getAttribute(attr) || "");
                let match;
                while ((match = regex.exec(value)) !== null) {
                    addHint(match[1], localWeight);
                }
                regex.lastIndex = 0;
            }
        }

        return Array.from(hints.entries())
            .sort((a, b) => b[1] - a[1])
            .map((entry) => entry[0]);
    }

    function getVisibleMemberNames() {
        const rows = document.querySelectorAll(
            "div[role='listitem'], div[data-testid*='cell-frame-container'], div[data-testid*='cell-frame-title']"
        );
        const names = new Set();
        rows.forEach((row) => {
            const titleNode = row.querySelector("span[title], div[title]");
            const title = normalizeWhitespace(titleNode?.getAttribute?.("title") || "");
            if (title && !looksLikeSubtitle(title)) {
                names.add(normalizeName(title));
                return;
            }

            const firstLine = normalizeWhitespace(String(row.innerText || "").split("\n")[0] || "");
            if (firstLine && !looksLikeSubtitle(firstLine) && firstLine.toLowerCase() !== "you") {
                names.add(normalizeName(firstLine));
            }
        });
        return names;
    }

    function idsMatch(serialized, wanted) {
        if (!serialized || !wanted) return false;
        return serialized === wanted || serialized.includes(wanted) || wanted.includes(serialized);
    }

    function candidateChatsFromStore(storeCandidate) {
        if (!storeCandidate || typeof storeCandidate !== "object") return [];
        const buckets = [
            storeCandidate,
            storeCandidate.Chat,
            storeCandidate.default,
            storeCandidate.default?.Chat,
            storeCandidate.ChatCollection,
            storeCandidate.default?.ChatCollection,
        ];
        const chats = [];
        for (const bucket of buckets) {
            if (!bucket) continue;
            const arrays = [...asArray(bucket), ...asArray(bucket._models), ...asArray(bucket.models)];
            arrays.forEach((item) => {
                if (item && typeof item === "object") chats.push(item);
            });
            if (typeof bucket.get === "function") chats.push(bucket);
        }
        return chats;
    }

    function resolvePrimaryStore(req) {
        let best = null;
        let bestScore = -1;

        const directCandidates = [
            window.Store,
            window.WWebJS?.Store,
            window.Debug?.Store,
            window?.webpackChunkwhatsapp_web_client?.Store,
        ].filter(Boolean);
        directCandidates.forEach((variant) => {
            if (!variant || typeof variant !== "object") return;
            let score = 0;
            if (variant.Chat) score += 8;
            if (variant.Contact || variant.Contacts || variant.ContactStore) score += 6;
            if (variant.GroupMetadata || variant.GroupMetadataStore) score += 4;
            if (score > bestScore) {
                bestScore = score;
                best = variant;
            }
        });

        if (!req?.c) return best;

        for (const key in req.c) {
            const exp = req.c[key]?.exports;
            if (!exp) continue;
            const variants = [exp, exp.default].filter(Boolean);
            for (const variant of variants) {
                if (!variant || typeof variant !== "object") continue;
                let score = 0;
                if (variant.Chat) score += 8;
                if (variant.Contact || variant.Contacts || variant.ContactStore) score += 6;
                if (variant.GroupMetadata || variant.GroupMetadataStore) score += 3;
                if (variant.WidFactory || variant.UserPrefs || variant.Conn) score += 2;
                if (score > bestScore) {
                    bestScore = score;
                    best = variant;
                }
            }
        }
        return best;
    }

    function findChatInCollection(collection, targetIds) {
        if (!collection) return null;
        const wanted = Array.from(targetIds || []).filter(Boolean);
        if (!wanted.length) return null;

        const asModels = asArray(collection);
        for (const chat of asModels) {
            const serialized = getSerializedId(chat?.id || chat);
            if (!serialized || !serialized.includes("@g.us")) continue;
            if (wanted.some((id) => idsMatch(serialized, id))) return chat;
        }

        if (typeof collection.get === "function") {
            for (const id of wanted) {
                try {
                    const found = collection.get(id);
                    if (found) return found;
                } catch (e) {}
            }
        }

        return null;
    }

    function candidateMetadataFromStore(storeCandidate) {
        if (!storeCandidate || typeof storeCandidate !== "object") return [];
        const buckets = [
            storeCandidate.GroupMetadata,
            storeCandidate.GroupMetadataStore,
            storeCandidate.default?.GroupMetadata,
            storeCandidate.default?.GroupMetadataStore,
            storeCandidate.Store?.GroupMetadata,
            storeCandidate.Store?.GroupMetadataStore,
            storeCandidate.default?.Store?.GroupMetadata,
            storeCandidate.default?.Store?.GroupMetadataStore,
        ].filter(Boolean);

        const all = [];
        buckets.forEach((bucket) => {
            const arrays = [...asArray(bucket), ...asArray(bucket._models), ...asArray(bucket.models)];
            arrays.forEach((item) => {
                if (item && typeof item === "object") all.push(item);
            });
            if (typeof bucket.get === "function") all.push(bucket);
        });
        return all;
    }

    function findMetadataInCollection(collection, targetIds) {
        if (!collection) return null;
        const wanted = Array.from(targetIds || []).filter(Boolean);
        if (!wanted.length) return null;

        const asModels = asArray(collection);
        for (const metadata of asModels) {
            const serialized = getSerializedId(metadata?.id || metadata?.wid || metadata);
            if (!serialized || !serialized.includes("@g.us")) continue;
            if (wanted.some((id) => idsMatch(serialized, id))) return metadata;
        }

        if (typeof collection.get === "function") {
            for (const id of wanted) {
                try {
                    const found = collection.get(id);
                    if (found) return found;
                } catch (e) {}
            }
        }
        return null;
    }

    function isActiveChat(candidate) {
        return !!(
            candidate?.active ||
            candidate?.isActive ||
            candidate?.__x_active ||
            candidate?.selected ||
            candidate?.__x_selected
        );
    }

    function chatNameOverlapScore(chat, visibleMemberNames) {
        if (!visibleMemberNames || !visibleMemberNames.size) return 0;
        const participants = chatParticipantsDirect(chat);
        if (!participants.length) return 0;

        let overlap = 0;
        for (let i = 0; i < participants.length && overlap < 10; i += 1) {
            const participant = participants[i];
            const name = normalizeName(
                participant?.shortName ||
                participant?.name ||
                participant?.pushname ||
                participant?.notifyName ||
                participant?.contact?.name ||
                participant?.contact?.pushname ||
                participant?.contact?.notifyName
            );
            if (!name) continue;
            if (visibleMemberNames.has(name)) overlap += 1;
        }
        return overlap * 8;
    }

    function findGroupMetadata(req, context) {
        const targetIds = new Set((context?.targetIds || []).map((id) => normalizeGroupId(id)).filter(Boolean));
        const uiName = normalizeName(context?.uiTitle);

        const primaryStore = resolvePrimaryStore(req);
        const directFromStore = findMetadataInCollection(primaryStore?.GroupMetadata || primaryStore?.GroupMetadataStore, targetIds);
        if (directFromStore) {
            const directParticipants = metadataParticipantsDirect(directFromStore);
            if (directParticipants.length) return directFromStore;
        }

        if (!req?.c) return null;

        let best = null;
        let bestScore = -1;
        for (const key in req.c) {
            const exp = req.c[key]?.exports;
            if (!exp) continue;
            const variants = [exp, exp.default].filter(Boolean);
            for (const variant of variants) {
                const candidates = candidateMetadataFromStore(variant);
                for (const candidate of candidates) {
                    if (!candidate || typeof candidate !== "object") continue;
                    const serialized = getSerializedId(candidate?.id || candidate?.wid || candidate);
                    if (!serialized || !serialized.includes("@g.us")) continue;

                    const pCount = metadataParticipantsDirect(candidate).length;
                    const name = metadataName(candidate);
                    const nameNorm = normalizeName(name);
                    let score = Math.min(pCount, 600) / 5;

                    targetIds.forEach((targetId) => {
                        if (targetId && idsMatch(serialized, targetId)) score += 130;
                    });
                    if (uiName && nameNorm) {
                        if (uiName === nameNorm) score += 90;
                        else if (nameNorm.includes(uiName) || uiName.includes(nameNorm)) score += 45;
                    }
                    if (score > bestScore) {
                        bestScore = score;
                        best = candidate;
                    }
                }
            }
        }
        return best;
    }

    function findGroupChat(req, context) {
        const targetIds = new Set((context?.targetIds || []).map((id) => normalizeGroupId(id)).filter(Boolean));
        const uiName = normalizeName(context?.uiTitle);
        const visibleMemberNames = context?.visibleMemberNames || new Set();

        const primaryStore = resolvePrimaryStore(req);
        const directFromStore = findChatInCollection(primaryStore?.Chat, targetIds);
        if (directFromStore && hasGroupParticipants(directFromStore)) {
            return directFromStore;
        }

        if (!req?.c) return null;

        let best = null;
        let bestScore = -1;

        for (const key in req.c) {
            const exp = req.c[key]?.exports;
            if (!exp) continue;
            const variants = [exp, exp.default].filter(Boolean);

            for (const variant of variants) {
                const candidates = candidateChatsFromStore(variant);
                for (const candidate of candidates) {
                    if (!candidate || !hasGroupParticipants(candidate)) continue;
                    const serialized = getSerializedId(candidate?.id || candidate);
                    if (!serialized.includes("@g.us")) continue;

                    const name = chatName(candidate);
                    const nameNorm = normalizeName(name);
                    const pCount = participantCount(candidate);
                    let score = Math.min(pCount, 600) / 5;

                    if (isActiveChat(candidate)) score += 180;
                    targetIds.forEach((targetId) => {
                        if (targetId && idsMatch(serialized, targetId)) {
                            score += 130;
                        }
                    });
                    if (uiName && nameNorm) {
                        if (uiName === nameNorm) score += 90;
                        else if (nameNorm.includes(uiName) || uiName.includes(nameNorm)) score += 45;
                    }
                    score += chatNameOverlapScore(candidate, visibleMemberNames);
                    if (looksLikeSubtitle(name)) score -= 35;

                    if (score > bestScore) {
                        bestScore = score;
                        best = candidate;
                    }
                }
            }
        }
        return best;
    }

    function collectStringFragments(obj, maxDepth = 4, maxNodes = 600) {
        const out = [];
        const queue = [{ value: obj, depth: 0 }];
        const visited = new Set();
        let count = 0;

        while (queue.length && count < maxNodes) {
            const current = queue.shift();
            if (!current) continue;
            const value = current.value;
            const depth = current.depth;
            count += 1;
            if (value === null || value === undefined) continue;

            if (typeof value === "string") {
                out.push(value);
                continue;
            }
            if (typeof value === "number") {
                out.push(String(value));
                continue;
            }
            if (typeof value !== "object" || depth >= maxDepth) {
                continue;
            }
            if (visited.has(value)) continue;
            visited.add(value);

            const entries = Object.entries(value);
            for (let i = 0; i < entries.length && i < 80; i += 1) {
                queue.push({ value: entries[i][1], depth: depth + 1 });
            }
        }
        return out;
    }

    function bestPhoneFromText(text) {
        const value = String(text || "");
        const candidates = [];
        const jidRegex = /(\d{8,20})(?::\d+)?@(?:c\.us|s\.whatsapp\.net|lid)/g;
        let jidMatch;
        while ((jidMatch = jidRegex.exec(value)) !== null) {
            candidates.push(jidMatch[1].replace(/\D+/g, ""));
        }

        const phoneRegex = /\+?\d[\d\s().-]{6,20}\d/g;
        (value.match(phoneRegex) || []).forEach((item) => {
            candidates.push(item.replace(/\D+/g, ""));
        });

        if (/^\d{8,20}$/.test(value.trim())) {
            candidates.push(value.trim().replace(/\D+/g, ""));
        }

        const normalized = candidates
            .map((c) => c.replace(/\D+/g, ""))
            .filter((c) => c.length >= 8 && c.length <= 20);
        if (!normalized.length) return "";

        normalized.sort((a, b) => {
            const aScore = a.length >= 10 && a.length <= 15 ? 2 : 1;
            const bScore = b.length >= 10 && b.length <= 15 ? 2 : 1;
            return bScore - aScore;
        });

        const preferred = normalized.find((n) => n.length <= 15);
        return preferred || normalized[0] || "";
    }

    function collectIdTokens(text) {
        const tokens = new Set();
        const value = String(text || "");
        const patterns = [
            /([a-z0-9._:-]{4,120}@(?:c\.us|s\.whatsapp\.net|lid|g\.us))/gi,
            /(\d{8,25}@g\.us)/gi,
        ];
        patterns.forEach((pattern) => {
            let match;
            while ((match = pattern.exec(value)) !== null) {
                if (match?.[1]) tokens.add(String(match[1]).toLowerCase());
            }
            pattern.lastIndex = 0;
        });
        return Array.from(tokens);
    }

    function buildContactIndexes(req) {
        const byName = new Map();
        const byId = new Map();

        const seenObjects = new Set();
        let inspected = 0;
        const maxInspect = 18000;

        function addByName(name, phone) {
            const key = normalizeName(name);
            if (!key) return;
            if (!byName.has(key)) byName.set(key, new Set());
            byName.get(key).add(phone);
        }

        function addById(idToken, phone) {
            const key = String(idToken || "").toLowerCase().trim();
            if (!key) return;
            if (!byId.has(key)) byId.set(key, phone);
            const compact = key.replace(/:\d+@/, "@");
            if (compact && !byId.has(compact)) byId.set(compact, phone);
            const userMatch = key.match(/^([^@]+)@/);
            if (userMatch?.[1] && !byId.has(userMatch[1])) byId.set(userMatch[1], phone);
        }

        function inspectItem(item) {
            if (!item || typeof item !== "object") return;
            if (seenObjects.has(item)) return;
            seenObjects.add(item);
            inspected += 1;
            if (inspected > maxInspect) return;

            const name = normalizeWhitespace(
                item.name ||
                item.pushname ||
                item.notifyName ||
                item.formattedName ||
                item.shortName ||
                item.__x_name ||
                item.contact?.name ||
                item.contact?.pushname
            );

            const directPhones = [
                item?.phoneNumber,
                item?.phone,
                item?.pn,
                item?.phoneNumberFormatted,
                item?.contact?.phoneNumber,
                item?.contact?.phone,
                item?.contact?.pn,
            ];
            const textParts = [
                getSerializedId(item),
                getSerializedId(item?.id),
                getSerializedId(item?.wid),
                getSerializedId(item?.contact?.id),
                getSerializedId(item?.contact?.wid),
                ...directPhones,
                ...collectStringFragments(item, 3, 220),
            ];
            const merged = textParts.join(" ");
            const phone = bestPhoneFromText(merged);
            if (!phone || phone.length > 15) return;

            if (name) addByName(name, phone);
            collectIdTokens(merged).forEach((token) => addById(token, phone));

            const serialized = getSerializedId(item?.id || item);
            if (serialized) addById(serialized, phone);
        }

        function inspectStoreCollections(primaryStore) {
            if (!primaryStore) return;
            const directPools = [
                ...asArray(primaryStore?.Contact),
                ...asArray(primaryStore?.Contacts),
                ...asArray(primaryStore?.ContactStore),
                ...asArray(primaryStore?.Store?.Contact),
                ...asArray(primaryStore?.Store?.Contacts),
                ...asArray(primaryStore?.Store?.ContactStore),
                ...asArray(primaryStore?.default?.Contact),
                ...asArray(primaryStore?.default?.Contacts),
                ...asArray(primaryStore?.default?.ContactStore),
                ...asArray(primaryStore?.Chat),
            ];
            directPools.forEach((item) => inspectItem(item));
        }

        inspectStoreCollections(resolvePrimaryStore(req));

        if (!req?.c) return { byName, byId };

        for (const key in req.c) {
            const exp = req.c[key]?.exports;
            if (!exp || inspected > maxInspect) continue;
            const variants = [exp, exp.default, exp?.Store, exp?.default?.Store].filter(Boolean);
            for (const variant of variants) {
                if (!variant || inspected > maxInspect) continue;
                const pools = [
                    ...asArray(variant),
                    ...asArray(variant?.Contact),
                    ...asArray(variant?.Contacts),
                    ...asArray(variant?.ContactStore),
                    ...asArray(variant?.Store?.Contact),
                    ...asArray(variant?.Store?.Contacts),
                    ...asArray(variant?.Store?.ContactStore),
                    ...asArray(variant?.default?.Contact),
                    ...asArray(variant?.default?.Contacts),
                    ...asArray(variant?.default?.ContactStore),
                ];
                pools.forEach((item) => inspectItem(item));
            }
        }
        return { byName, byId };
    }

    function participantName(participant, phoneDigits) {
        const pools = [
            participant?.shortName,
            participant?.name,
            participant?.pushname,
            participant?.notifyName,
            participant?.contact?.name,
            participant?.contact?.pushname,
            participant?.contact?.notifyName,
            participant?.contact?.formattedName,
        ];
        for (const pool of pools) {
            const value = normalizeWhitespace(pool);
            if (value) return value.slice(0, 191);
        }
        return phoneDigits ? `+${phoneDigits}` : "";
    }

    function participantUser(participant, contactIndexes) {
        const byName = contactIndexes?.byName || new Map();
        const byId = contactIndexes?.byId || new Map();
        const directPhones = [
            participant?.phoneNumber,
            participant?.phone,
            participant?.pn,
            participant?.contact?.phoneNumber,
            participant?.contact?.phone,
            participant?.contact?.pn,
        ];
        const pools = [
            getSerializedId(participant?.id),
            getSerializedId(participant?.wid),
            getSerializedId(participant?.contact?.id),
            getSerializedId(participant?.contact?.wid),
            getSerializedId(participant?.contact),
            getSerializedId(participant?.participant),
            getSerializedId(participant?.participantWid),
            getSerializedId(participant?.__x_id),
            getSerializedId(participant?.__x_wid),
            ...directPhones,
            ...collectStringFragments(participant, 4, 380),
        ];
        const idTokens = new Set();

        for (const pool of pools) {
            collectIdTokens(pool).forEach((token) => idTokens.add(token));
            const best = bestPhoneFromText(pool);
            if (best && best.length <= 15) return best;
        }

        for (const token of idTokens) {
            const variants = [
                token,
                String(token || "").replace(/:\d+@/, "@"),
                String(token || "").split("@")[0],
            ].filter(Boolean);
            let mapped = "";
            for (const variant of variants) {
                mapped = byId.get(variant) || "";
                if (mapped) break;
            }
            if (mapped && mapped.length <= 15) return mapped;
            const best = bestPhoneFromText(token);
            if (best && best.length <= 15) return best;
        }

        const nameKey = normalizeName(participantName(participant, ""));
        if (nameKey && byName.has(nameKey)) {
            const set = byName.get(nameKey);
            if (set && set.size === 1) {
                return Array.from(set)[0];
            }
        }
        return "";
    }

    function groupNameFromChat(chat, uiTitle) {
        const pools = [uiTitle, chat?.groupMetadata?.subject, chat?.formattedTitle, chat?.name, chat?.__x_formattedTitle, chat?.__x_name];
        for (const pool of pools) {
            const value = normalizeWhitespace(pool);
            if (value && !looksLikeSubtitle(value)) return value.slice(0, 191);
        }
        for (const pool of pools) {
            const value = normalizeWhitespace(pool);
            if (value) return value.slice(0, 191);
        }
        return "WhatsApp Group";
    }

    function groupNameFromMetadata(metadata, uiTitle) {
        const pools = [uiTitle, metadataName(metadata), metadata?.subject, metadata?.name, metadata?.__x_subject, metadata?.__x_name];
        for (const pool of pools) {
            const value = normalizeWhitespace(pool);
            if (value && !looksLikeSubtitle(value)) return value.slice(0, 191);
        }
        for (const pool of pools) {
            const value = normalizeWhitespace(pool);
            if (value) return value.slice(0, 191);
        }
        return "WhatsApp Group";
    }

    try {
        const req = resolveRequire();
        const uiTitle = getUiGroupTitle();
        const hashId = normalizeGroupId(cleanHash());
        const pathId = normalizeGroupId(cleanPath());
        const domHints = collectGroupIdHints();
        const context = {
            uiTitle,
            targetIds: [hashId, pathId, ...domHints].filter(Boolean),
            visibleMemberNames: getVisibleMemberNames(),
        };
        const chat = findGroupChat(req, context);
        const metadata = findGroupMetadata(req, context);

        if (!chat && !metadata) {
            return { ok: false, error: "Could not resolve active group runtime context" };
        }

        const chatParticipants = chat ? chatParticipantsForExtraction(chat) : [];
        const metadataParticipants = metadata ? metadataParticipantsForExtraction(metadata) : [];
        let participants = chatParticipants;
        let chosenSource = "chat";
        if (metadataParticipants.length > participants.length) {
            participants = metadataParticipants;
            chosenSource = "metadata";
        }

        const contactIndexes = buildContactIndexes(req);
        const dedupe = new Map();

        participants.forEach((participant) => {
            const userDigits = participantUser(participant, contactIndexes);
            if (!userDigits || userDigits.length > 15) {
                stats.invalid_count += 1;
                return;
            }
            if (dedupe.has(userDigits)) {
                stats.duplicate_count += 1;
                return;
            }
            const name = participantName(participant, userDigits);
            dedupe.set(userDigits, { name, phone_raw: `+${userDigits}` });
        });

        const members = Array.from(dedupe.values());
        if (!members.length) {
            return { ok: false, error: "Runtime scan found no resolvable members" };
        }

        return {
            ok: true,
            source: "runtime_v3",
            group_name: chat ? groupNameFromChat(chat, uiTitle) : groupNameFromMetadata(metadata, uiTitle),
            group_identifier: normalizeGroupId(
                getSerializedId(chat?.id || metadata?.id || metadata?.wid || "") || context.targetIds?.[0] || ""
            ),
            members,
            total: members.length,
            stats,
            diagnostics: {
                selected_source: chosenSource,
                participant_candidates: participants.length,
                chat_participants: chatParticipants.length,
                metadata_participants: metadataParticipants.length,
                contact_name_index: contactIndexes.byName?.size || 0,
                contact_id_index: contactIndexes.byId?.size || 0,
            },
        };
    } catch (error) {
        return { ok: false, error: error?.message || "runtime_scan_failed" };
    }
}

async function extractGroupMembersDomFallback() {
    const stats = {
        invalid_count: 0,
        duplicate_count: 0,
    };
    const map = new Map();
    const duplicateKeys = new Set();
    const visitedRowKeys = new Set();
    const orderedNames = [];
    const containerPhoneHints = new Set();

    function normalizeWhitespace(value) {
        return String(value || "").replace(/\s+/g, " ").trim();
    }

    function looksLikeSubtitle(value) {
        const text = normalizeWhitespace(value);
        if (!text) return false;
        return (text.match(/,/g) || []).length >= 3 || (text.match(/\+\d/g) || []).length >= 2;
    }

    function extractPhones(value) {
        const text = String(value || "");
        const found = new Set();

        const jidRegex = /(\d{8,20})(?::\d+)?@(?:c\.us|s\.whatsapp\.net|lid)/g;
        let jidMatch;
        while ((jidMatch = jidRegex.exec(text)) !== null) {
            found.add(jidMatch[1].replace(/\D+/g, ""));
        }

        const groupRegex = /(\d{8,25})@g\.us/g;
        let groupMatch;
        while ((groupMatch = groupRegex.exec(text)) !== null) {
            // group id is not a member phone.
            found.delete(groupMatch[1].replace(/\D+/g, ""));
        }

        const phoneRegex = /\+?\d[\d\s().-]{6,20}\d/g;
        (text.match(phoneRegex) || []).forEach((item) => {
            found.add(item.replace(/\D+/g, ""));
        });

        return Array.from(found).filter((digits) => digits.length >= 8 && digits.length <= 15);
    }

    function addMember(rawName, rawPhone) {
        const phoneDigits = String(rawPhone || "").replace(/\D+/g, "");
        if (phoneDigits.length < 8 || phoneDigits.length > 15) {
            stats.invalid_count += 1;
            return;
        }

        if (map.has(phoneDigits)) {
            if (!duplicateKeys.has(phoneDigits)) {
                duplicateKeys.add(phoneDigits);
                stats.duplicate_count += 1;
            }
            return;
        }

        const cleanName = normalizeWhitespace(rawName);
        map.set(phoneDigits, {
            name: cleanName.slice(0, 191) || `+${phoneDigits}`,
            phone_raw: `+${phoneDigits}`,
        });
    }

    function rememberName(name) {
        const clean = normalizeWhitespace(name);
        if (!clean) return;
        const lower = clean.toLowerCase();
        if (lower === "you") return;
        if (!orderedNames.some((n) => String(n).toLowerCase() === lower)) {
            orderedNames.push(clean.slice(0, 191));
        }
    }

    function collectReactPayload(node, maxNodes = 1800) {
        const out = [];
        const keys = Object.keys(node || {}).filter(
            (key) => key.startsWith("__reactFiber$") || key.startsWith("__reactProps$")
        );
        const queue = [];
        const visited = new Set();
        keys.forEach((key) => {
            if (node[key]) queue.push({ value: node[key], depth: 0 });
        });

        let count = 0;
        while (queue.length && count < maxNodes) {
            const current = queue.shift();
            if (!current) continue;
            const value = current.value;
            const depth = current.depth;
            count += 1;

            if (value === null || value === undefined) continue;
            const type = typeof value;
            if (type === "string" || type === "number") {
                out.push(String(value));
                continue;
            }
            if (type !== "object" || depth >= 6) continue;
            if (visited.has(value)) continue;
            visited.add(value);

            const entries = Object.entries(value);
            for (let i = 0; i < entries.length && i < 180; i += 1) {
                queue.push({ value: entries[i][1], depth: depth + 1 });
            }
        }
        return out;
    }

    function rowName(row) {
        const titleNode = row.querySelector("span[title], div[title]");
        const title = normalizeWhitespace(titleNode?.getAttribute?.("title") || titleNode?.textContent || "");
        if (title && !looksLikeSubtitle(title) && title.toLowerCase() !== "you") {
            return title;
        }

        const text = normalizeWhitespace(String(row.innerText || ""));
        const firstLine = normalizeWhitespace((text.split("\n")[0] || "").trim());
        if (firstLine && firstLine.toLowerCase() !== "you" && !looksLikeSubtitle(firstLine)) {
            return firstLine;
        }
        return "";
    }

    function collectRowPhones(row) {
        const phones = new Set();

        const text = normalizeWhitespace(row.innerText || "");
        extractPhones(text).forEach((phone) => phones.add(phone));
        extractPhones(row.outerHTML || "").forEach((phone) => phones.add(phone));

        const attrs = row.getAttributeNames ? row.getAttributeNames() : [];
        attrs.forEach((attr) => {
            const value = row.getAttribute(attr);
            extractPhones(value).forEach((phone) => phones.add(phone));
        });

        const descendants = row.querySelectorAll("[data-id], [data-jid], [id], [title], a[href]");
        for (let i = 0; i < descendants.length && i < 80; i += 1) {
            const node = descendants[i];
            const names = node.getAttributeNames ? node.getAttributeNames() : [];
            names.forEach((attr) => {
                const value = node.getAttribute(attr);
                extractPhones(value).forEach((phone) => phones.add(phone));
            });
        }

        collectReactPayload(row).forEach((chunk) => {
            extractPhones(chunk).forEach((phone) => phones.add(phone));
        });

        let parent = row.parentElement;
        let hops = 0;
        while (parent && hops < 4) {
            const pAttrs = parent.getAttributeNames ? parent.getAttributeNames() : [];
            pAttrs.forEach((attr) => {
                const value = parent.getAttribute(attr);
                extractPhones(value).forEach((phone) => phones.add(phone));
            });
            extractPhones(parent.outerHTML || "").forEach((phone) => phones.add(phone));
            parent = parent.parentElement;
            hops += 1;
        }

        return Array.from(phones);
    }

    function candidateContainers() {
        const list = [];
        const all = document.querySelectorAll("div");
        for (let i = 0; i < all.length; i += 1) {
            const el = all[i];
            if (el.clientHeight < 180) continue;
            if (el.scrollHeight <= el.clientHeight + 20) continue;

            let score = 0;
            const rowCount = el.querySelectorAll("div[role='listitem'], div[data-testid*='cell-frame']").length;
            score += Math.min(rowCount * 3, 120);

            const text = normalizeWhitespace(el.innerText || "");
            if (/search members/i.test(text)) score += 70;
            if (/search contacts/i.test(text)) score += 35;
            if (/group admin/i.test(text)) score += 20;
            if (el.closest("[role='dialog']")) score += 20;
            if (el.closest("#app")) score += 5;

            if (score > 10) list.push({ el, score });
        }
        list.sort((a, b) => b.score - a.score || b.el.scrollHeight - a.el.scrollHeight);
        return list.map((item) => item.el);
    }

    function collectRows(container) {
        const base = container || document;
        const rows = base.querySelectorAll(
            "div[role='listitem'], div[data-testid*='cell-frame-container'], div[data-testid*='cell-frame-title'], div[role='button']"
        );
        const uniqueRows = [];
        const localSeen = new Set();
        rows.forEach((row) => {
            const root = row.closest("div[role='listitem']") || row.closest("div[data-testid*='cell-frame-container']") || row;
            const key = String(root?.dataset?.id || root?.dataset?.jid || root?.getAttribute?.("data-id") || "") + "|" + String(root?.textContent || "").slice(0, 60);
            if (!localSeen.has(key)) {
                localSeen.add(key);
                uniqueRows.push(root);
            }
        });
        return uniqueRows;
    }

    function processRows(container) {
        const rows = collectRows(container);
        rows.forEach((row) => {
            const rowKey = String(row?.textContent || "").slice(0, 200);
            if (visitedRowKeys.has(rowKey)) return;
            visitedRowKeys.add(rowKey);

            const name = rowName(row);
            rememberName(name);
            const phones = collectRowPhones(row);
            phones.forEach((phone) => addMember(name || `+${phone}`, phone));
        });
    }

    function collectContainerPhones(container) {
        if (!container) return;
        extractPhones(container.innerHTML || "").forEach((phone) => containerPhoneHints.add(phone));
        extractPhones(container.outerHTML || "").forEach((phone) => containerPhoneHints.add(phone));
    }

    function resolveGroupName() {
        const selectors = [
            "#main header [data-testid='conversation-info-header-chat-title']",
            "#main header [data-testid='conversation-info-header-chat-title-text']",
            "#main header h1",
            "#main header span[title]",
            "header span[dir='auto'][title]",
            "aside [aria-selected='true'] span[title]",
            "aside [aria-selected='true'] [title]",
        ];
        const names = [];
        selectors.forEach((selector) => {
            document.querySelectorAll(selector).forEach((node) => {
                const title = normalizeWhitespace(node.getAttribute?.("title") || node.textContent || "");
                if (title) names.push(title.slice(0, 191));
            });
        });
        const preferred = names.filter((name) => {
            const lower = String(name || "").toLowerCase();
            if (looksLikeSubtitle(name)) return false;
            if (lower.includes("search members")) return false;
            if (lower.includes("search contacts")) return false;
            if (lower.includes("open in app")) return false;
            return true;
        });
        if (preferred.length) {
            preferred.sort((a, b) => a.length - b.length);
            return preferred[0];
        }
        if (names.length) {
            names.sort((a, b) => a.length - b.length);
            return names[0];
        }
        return "WhatsApp Group";
    }

    function resolveGroupIdentifier() {
        const hash = decodeURIComponent(String(window.location.hash || "")).replace(/^#\/?/, "").split("?")[0].trim();
        const path = decodeURIComponent(String(window.location.pathname || "")).replace(/^\/+/, "").split("?")[0].trim();
        const joined = `${hash} ${path} ${document.body?.innerHTML?.slice(0, 6000) || ""}`;
        const match = joined.match(/(\d{8,25}@g\.us)/);
        if (match?.[1]) return match[1];
        return hash || path || "";
    }

    const containers = candidateContainers();
    const container = containers[0] || null;

    if (container) {
        container.scrollTop = 0;
        await new Promise((resolve) => setTimeout(resolve, 140));
    }

    let stable = 0;
    let loops = 0;
    while (loops < 140) {
        processRows(container);
        collectContainerPhones(container);
        if (!container) break;

        const before = container.scrollTop;
        const maxTop = Math.max(0, container.scrollHeight - container.clientHeight);
        container.scrollTop = Math.min(maxTop, before + Math.max(140, Math.floor(container.clientHeight * 0.85)));
        await new Promise((resolve) => setTimeout(resolve, 170));

        if (Math.abs(container.scrollTop - before) < 4) {
            stable += 1;
        } else {
            stable = 0;
        }
        if (stable >= 8) break;
        loops += 1;
    }

    if (container) {
        container.scrollTop = 0;
        await new Promise((resolve) => setTimeout(resolve, 120));
        processRows(container);
        collectContainerPhones(container);
    } else {
        processRows(null);
    }

    if (containerPhoneHints.size) {
        const usedNameKeys = new Set(Array.from(map.values()).map((m) => normalizeWhitespace(m?.name || "").toLowerCase()));
        containerPhoneHints.forEach((phone) => {
            if (map.has(phone)) return;
            let fallbackName = "";
            for (let i = 0; i < orderedNames.length; i += 1) {
                const candidate = orderedNames[i];
                const key = normalizeWhitespace(candidate).toLowerCase();
                if (!key || usedNameKeys.has(key)) continue;
                fallbackName = candidate;
                usedNameKeys.add(key);
                break;
            }
            addMember(fallbackName || `+${phone}`, phone);
        });
    }

    const members = Array.from(map.values());
    return {
        ok: true,
        source: "dom_fallback_v2",
        group_name: resolveGroupName(),
        group_identifier: resolveGroupIdentifier(),
        members,
        total: members.length,
        stats,
        diagnostics: {
            row_names: orderedNames.length,
            container_phone_hints: containerPhoneHints.size,
        },
    };
}

function normalizeUrl(base, endpoint) {
    const cleanBase = String(base || "").replace(/\/+$/, "");
    const cleanEndpoint = String(endpoint || "").replace(/^\/+/, "");
    if (!cleanEndpoint) {
        return cleanBase;
    }
    return `${cleanBase}/${cleanEndpoint}`;
}

function randomToken(length) {
    const chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    let out = "";
    const bytes = crypto.getRandomValues(new Uint8Array(length));
    for (let i = 0; i < bytes.length; i += 1) {
        out += chars[bytes[i] % chars.length];
    }
    return out;
}

async function sha256Hex(value) {
    const enc = new TextEncoder().encode(value);
    const digest = await crypto.subtle.digest("SHA-256", enc);
    return bytesToHex(new Uint8Array(digest));
}

async function hmacSha256Hex(value, secret) {
    const enc = new TextEncoder();
    const key = await crypto.subtle.importKey(
        "raw",
        enc.encode(secret),
        { name: "HMAC", hash: "SHA-256" },
        false,
        ["sign"]
    );
    const sig = await crypto.subtle.sign("HMAC", key, enc.encode(value));
    return bytesToHex(new Uint8Array(sig));
}

function bytesToHex(bytes) {
    return Array.from(bytes).map((b) => b.toString(16).padStart(2, "0")).join("");
}
