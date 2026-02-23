/* ═══════════════════════════════════════════════════════════════
   WA Group Capture — background.js  v1.3.0
   ─────────────────────────────────────────────────────────────
   Key fixes in 1.3.0:
     • DOM extraction no longer excludes #main — the member panel
       may live inside #main (center column).
     • Member panel found by landmark text ("Search members" /
       "N participants") then scoped precisely.
     • Chat SIDEBAR (#side/#pane-side) is excluded (these are
       recent-chats, NOT group members).
     • React Fiber traversal added as extra main-world strategy.
     • Version tag in every scan result for easy identification.
   ═══════════════════════════════════════════════════════════════ */

const EXT_VERSION = "1.3.0";
const STORAGE_KEY = "group_extraction_session";

/* ──────────────────── Message Router ──────────────────── */

chrome.runtime.onMessage.addListener((message, sender, sendResponse) => {
    (async () => {
        try {
            switch (message?.action) {
                case "GE_SAVE_CONFIG":
                    await chrome.storage.local.set({ [STORAGE_KEY]: message.payload || null });
                    sendResponse({ ok: true });
                    break;
                case "GE_GET_CONFIG": {
                    const data = await chrome.storage.local.get(STORAGE_KEY);
                    sendResponse({ ok: true, config: data[STORAGE_KEY] || null });
                    break;
                }
                case "GE_SIGNED_REQUEST":
                    sendResponse(await signedRequest(message.payload || {}));
                    break;
                case "GE_SCAN_GROUP_MEMBERS": {
                    const tabId = Number(message.tabId || 0);
                    if (!tabId) {
                        sendResponse({ ok: false, error: "Missing tabId", _v: EXT_VERSION });
                    } else {
                        sendResponse(await scanGroupMembers(tabId));
                    }
                    break;
                }
                case "GE_GET_VERSION":
                    sendResponse({ ok: true, version: EXT_VERSION });
                    break;
                default:
                    sendResponse({ ok: false, error: "Unknown action" });
            }
        } catch (err) {
            sendResponse({ ok: false, error: err?.message || "Background error", _v: EXT_VERSION });
        }
    })();
    return true;
});

/* ──────────────────── Signed API request ──────────────────── */

async function signedRequest(payload) {
    const { config, endpoint, method = "POST", body = {} } = payload;
    if (!config?.api_base || !config?.session_token || !config?.signing_secret) {
        return { ok: false, error: "Missing extension session configuration" };
    }
    const url = normalizeUrl(config.api_base, endpoint || "");
    const rm = String(method || "POST").toUpperCase();
    const bodyText = rm === "GET" ? "" : JSON.stringify(body || {});
    const payloadHash = await sha256Hex(bodyText);
    const timestamp = String(Math.floor(Date.now() / 1000));
    const nonce = randomToken(24);
    const path = new URL(url).pathname.replace(/^\//, "");
    const canonical = `${rm}\n${path}\n${timestamp}\n${nonce}\n${payloadHash}`;
    const signature = await hmacSha256Hex(canonical, config.signing_secret);
    const response = await fetch(url, {
        method: rm,
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${config.session_token}`,
            "X-GE-Session": config.session_token,
            "X-GE-Timestamp": timestamp,
            "X-GE-Nonce": nonce,
            "X-GE-Signature": signature,
        },
        body: rm === "GET" ? undefined : bodyText,
    });
    const rawText = await response.text();
    let parsed = null;
    try { parsed = JSON.parse(rawText); } catch { /* noop */ }
    return { ok: response.ok, status: response.status, data: parsed, raw: rawText };
}

/* ══════════════════════════════════════════════════════════════
   SCAN ORCHESTRATOR
   ══════════════════════════════════════════════════════════════ */

async function scanGroupMembers(tabId) {
    let mainResult = null;
    let mainError = "";

    /* ---------- Strategy 1: Main-world ---------- */
    for (let attempt = 0; attempt < 3; attempt++) {
        if (attempt > 0) await delay(1200 + attempt * 600);
        try {
            const r = await execScript(tabId, "MAIN", mainWorldExtract);
            if (r?.ok && r.members?.length > 0) {
                if (!mainResult || r.members.length > mainResult.members.length) {
                    mainResult = r;
                }
                if (r.members.length >= 10) break;
            }
            if (r?.error) mainError = r.error;
        } catch (e) {
            mainError = e?.message || "main_world_exec_failed";
        }
    }

    if (mainResult?.ok && mainResult.members.length >= 5) {
        mainResult._v = EXT_VERSION;
        mainResult._diag = { main: mainResult.members.length, dom: 0, mainErr: "" };
        return mainResult;
    }

    /* ---------- Strategy 2: DOM fallback ---------- */
    let domResult = null;
    try {
        domResult = await execScript(tabId, "MAIN", domFallbackExtract);
    } catch (e) {
        /* ignore */
    }

    const pick = (() => {
        if (mainResult?.ok && domResult?.ok)
            return mainResult.members.length >= domResult.members.length ? mainResult : domResult;
        return mainResult?.ok ? mainResult : domResult?.ok ? domResult : null;
    })();

    if (pick) {
        pick._v = EXT_VERSION;
        pick._diag = {
            main: mainResult?.members?.length || 0,
            dom: domResult?.members?.length || 0,
            mainErr: mainError,
        };
        return pick;
    }

    return {
        ok: false,
        _v: EXT_VERSION,
        error: "Extraction failed. Please open the full member list (click group header → View all members) then scan again.",
        _diag: { main: 0, dom: 0, mainErr: mainError },
    };
}

/* ──────── Helpers ──────── */

function delay(ms) { return new Promise(r => setTimeout(r, ms)); }

async function execScript(tabId, world, func) {
    try {
        const [frame] = await chrome.scripting.executeScript({
            target: { tabId },
            world,
            func,
        });
        return frame?.result || null;
    } catch (e) {
        return { ok: false, error: e?.message || "exec_failed" };
    }
}

/* ══════════════════════════════════════════════════════════════
   STRATEGY 1 — MAIN-WORLD EXTRACTION
   Runs in the page JS context.  Tries (in order):
     A. Webpack require → Store → participants
     B. React Fiber traversal → component props with participants
     C. Global-object scan (window.*) for WA Store
   ══════════════════════════════════════════════════════════════ */

function mainWorldExtract() {
    const VERSION = "1.3.0";
    const stats = { invalid_count: 0, duplicate_count: 0 };
    const errors = [];

    /* ---- helpers ---- */
    function asArr(src) {
        if (!src) return [];
        if (Array.isArray(src)) return src;
        for (const p of ["_models", "models"]) { if (Array.isArray(src[p])) return src[p]; }
        for (const fn of ["toArray", "getModelsArray"]) {
            if (typeof src[fn] === "function") { try { const a = src[fn](); if (Array.isArray(a)) return a; } catch {} }
        }
        if (typeof src?.values === "function") { try { return Array.from(src.values()); } catch {} }
        if (typeof src?.[Symbol.iterator] === "function") { try { return Array.from(src); } catch {} }
        return [];
    }
    function sid(obj) {
        if (!obj) return "";
        if (typeof obj === "string") return obj;
        for (const v of [obj._serialized, obj.serialized, obj.id?._serialized,
            obj.id?.serialized, obj.wid?._serialized, obj.wid?.serialized,
            obj.jid?._serialized, obj.jid?.serialized]) {
            if (typeof v === "string" && v) return v;
        }
        const u = obj.user || obj.id?.user || obj.wid?.user;
        const s = obj.server || obj.id?.server || obj.wid?.server || "c.us";
        return u ? `${u}@${s}` : "";
    }
    function pPhone(p) {
        for (const x of [p?.id, p?.wid, p?.contact?.id, p?.contact?.wid,
            p?.participant, p?.participantWid, p?.__x_id, p?.__x_wid, p?.jid, p]) {
            const s = sid(x); if (!s) continue;
            const d = s.split("@")[0].replace(/\D/g, "");
            if (d.length >= 8 && d.length <= 15) return d;
        }
        return "";
    }
    function pName(p, phone) {
        for (const v of [p?.shortName, p?.name, p?.pushname, p?.notifyName,
            p?.displayName, p?.formattedName, p?.contact?.name, p?.contact?.pushname,
            p?.contact?.notifyName, p?.contact?.displayName, p?.contact?.formattedName]) {
            const s = String(v || "").trim();
            if (s) return s.slice(0, 191);
        }
        return phone ? `+${phone}` : "";
    }
    function gName(chat) {
        for (const v of [chat?.formattedTitle, chat?.name, chat?.groupMetadata?.subject,
            chat?.__x_formattedTitle, chat?.__x_name, chat?.displayName]) {
            const s = String(v || "").trim();
            if (s && s.split(",").length <= 4 && !(/\+\d{6,}/.test(s) && s.split(",").length > 2)) return s.slice(0, 191);
        }
        return "WhatsApp Group";
    }
    function getParticipants(chat) {
        let all = [];
        for (const src of [
            chat?.groupMetadata?.participants, chat?.groupMetadata?._participants,
            chat?.participants, chat?.__x_groupMetadata?.participants,
            chat?.__x_participants, chat?._groupMetadata?.participants,
            chat?.participantCollection,
        ]) {
            const a = asArr(src);
            if (a.length > 0) all = all.concat(a);
        }
        // Try minified property names on groupMetadata
        if (all.length === 0 && chat?.groupMetadata) {
            for (const k of Object.keys(chat.groupMetadata)) {
                try {
                    const v = chat.groupMetadata[k]; if (!v) continue;
                    const a = asArr(v); if (a.length < 2) continue;
                    if (a.slice(0, 5).some(x => sid(x?.id || x?.wid || x).includes("@c.us"))) { all = a; break; }
                } catch {}
            }
        }
        const seen = new Set();
        return all.filter(p => { const id = sid(p?.id || p?.wid || p); if (!id || seen.has(id)) return false; seen.add(id); return true; });
    }

    /* ---- Hash → target group id ---- */
    const rawHash = decodeURIComponent(String(window.location.hash || "")).replace(/^#\/?/, "").split("?")[0].trim();
    const targetId = (() => {
        if (!rawHash) return "";
        if (rawHash.includes("@g.us")) return rawHash;
        const d = rawHash.replace(/[^0-9\-]/g, "");
        return d ? d + "@g.us" : rawHash;
    })();

    /* ---- A. Webpack require ---- */
    function resolveReq() {
        let req = null;
        for (const k of Object.keys(window)) {
            if (!k.startsWith("webpackChunk") && k !== "webpackJsonp") continue;
            try { const a = window[k]; if (Array.isArray(a)) a.push([[`_ge_${Date.now()}`], {}, r => { req = r; }]); } catch {}
            if (req) return req;
        }
        if (typeof window.__webpack_require__ === "function" && window.__webpack_require__.c) return window.__webpack_require__;
        // brute-force: any array with push
        try {
            for (const k of Object.getOwnPropertyNames(window)) {
                try { const a = window[k]; if (Array.isArray(a) && a.push) { a.push([[`_ge2_${Date.now()}`], {}, r => { req = r; }]); if (req) return req; } } catch {}
            }
        } catch {}
        return null;
    }

    function findGroupInCache(cache) {
        let best = null, bestN = 0;
        for (const key in cache) {
            const exp = cache[key]?.exports; if (!exp) continue;
            for (const v of [exp, exp?.default].filter(Boolean)) {
                for (const b of [v, v?.Chat, v?.ChatCollection, v?.GroupMetadata,
                    v?.GroupChat, v?.default?.Chat, v?.default?.GroupMetadata]) {
                    if (!b) continue;
                    if (typeof b.get === "function" && targetId) {
                        try { const c = b.get(targetId); if (c) { const p = getParticipants(c); if (p.length > 0) return c; } } catch {}
                    }
                    for (const item of asArr(b)) {
                        const id = sid(item?.id || item); if (!id.includes("@g.us")) continue;
                        const p = getParticipants(item); if (p.length === 0) continue;
                        if (targetId && id === targetId) return item;
                        if (p.length > bestN) { bestN = p.length; best = item; }
                    }
                }
                // Look for getActive/active patterns
                for (const fn of ["getActive", "getActiveChat", "getSelected"]) {
                    if (typeof v[fn] !== "function") continue;
                    try { const c = v[fn](); if (c && sid(c?.id).includes("@g.us") && getParticipants(c).length > 0) return c; } catch {}
                }
                for (const prop of ["active", "activeChat", "selectedChat"]) {
                    try { const c = v[prop]; if (c && sid(c?.id).includes("@g.us") && getParticipants(c).length > 0) return c; } catch {}
                }
            }
        }
        return best;
    }

    let chat = null;
    try {
        const req = resolveReq();
        if (req?.c) {
            chat = findGroupInCache(req.c);
            if (!chat) errors.push("wp:group_not_in_cache");
        } else {
            errors.push("wp:require_not_found");
        }
    } catch (e) { errors.push("wp:" + (e?.message || "error")); }

    /* ---- B. React Fiber traversal ---- */
    if (!chat) {
        try {
            // Find the React Fiber internals key
            let fiberKey = "";
            const appEl = document.getElementById("app") || document.body;
            for (const k of Object.keys(appEl)) {
                if (k.startsWith("__reactFiber$") || k.startsWith("__reactInternalInstance$")) { fiberKey = k; break; }
            }
            if (!fiberKey) {
                // try #main or first div child
                const probe = document.querySelector("#main") || document.querySelector("#app > div") || document.querySelector("div[tabindex]");
                if (probe) {
                    for (const k of Object.keys(probe)) {
                        if (k.startsWith("__reactFiber$") || k.startsWith("__reactInternalInstance$")) { fiberKey = k; break; }
                    }
                }
            }

            if (fiberKey) {
                const entries = [
                    document.querySelector("#main header"),
                    document.querySelector("#main"),
                    document.querySelector('[data-testid="conversation-panel-wrapper"]'),
                    document.querySelector('[data-testid="conversation-info-header"]'),
                    document.getElementById("app"),
                ].filter(el => el && el[fiberKey]);

                outer:
                for (const el of entries) {
                    let fiber = el[fiberKey];
                    const visited = new Set();
                    while (fiber && visited.size < 300) {
                        if (visited.has(fiber)) break;
                        visited.add(fiber);

                        // Inspect memoizedProps
                        const props = fiber.memoizedProps;
                        if (props && typeof props === "object") {
                            for (const pk of Object.keys(props).slice(0, 40)) {
                                try {
                                    const pv = props[pk];
                                    if (!pv || typeof pv !== "object") continue;
                                    if (pv.groupMetadata || pv.participants || pv._participants) {
                                        const candidate = pv.groupMetadata ? pv : { groupMetadata: pv };
                                        const parts = getParticipants(candidate);
                                        if (parts.length >= 2) {
                                            chat = candidate;
                                            break outer;
                                        }
                                    }
                                } catch {}
                            }
                        }

                        // Inspect memoizedState chain
                        let st = fiber.memoizedState;
                        let stN = 0;
                        while (st && stN < 30) {
                            stN++;
                            for (const sv of [st.memoizedState, st.queue?.lastRenderedState].filter(x => x && typeof x === "object")) {
                                try {
                                    if (sv.groupMetadata || sv.participants || sv._participants) {
                                        const candidate = sv.groupMetadata ? sv : { groupMetadata: sv };
                                        const parts = getParticipants(candidate);
                                        if (parts.length >= 2) { chat = candidate; break outer; }
                                    }
                                } catch {}
                            }
                            st = st.next;
                        }

                        fiber = fiber.return;
                    }
                }
                if (!chat) errors.push("rf:no_group_in_fiber");
            } else {
                errors.push("rf:no_fiber_key");
            }
        } catch (e) { errors.push("rf:" + (e?.message || "error")); }
    }

    /* ---- C. Global Store scan ---- */
    if (!chat) {
        try {
            for (const k of Object.getOwnPropertyNames(window)) {
                try {
                    const v = window[k];
                    if (!v || typeof v !== "object") continue;
                    if (typeof v.Chat?.get === "function" || typeof v.GroupMetadata?.get === "function") {
                        const store = v;
                        // Try getting group from Store
                        for (const coll of [store.Chat, store.GroupMetadata, store.Group]) {
                            if (!coll) continue;
                            if (typeof coll.get === "function" && targetId) {
                                try { const c = coll.get(targetId); if (c && getParticipants(c).length > 0) { chat = c; break; } } catch {}
                            }
                            for (const item of asArr(coll)) {
                                const id = sid(item?.id || item);
                                if (!id.includes("@g.us")) continue;
                                const p = getParticipants(item);
                                if (p.length >= 2) { chat = item; break; }
                            }
                            if (chat) break;
                        }
                        if (chat) break;
                    }
                } catch {}
            }
            if (!chat) errors.push("gs:store_not_found");
        } catch (e) { errors.push("gs:" + (e?.message || "error")); }
    }

    /* ---- Build result ---- */
    if (!chat) {
        return { ok: false, _v: VERSION, error: "main_world_failed", _errors: errors };
    }

    const participants = getParticipants(chat);
    if (participants.length === 0) {
        return { ok: false, _v: VERSION, error: "participants_empty", _errors: errors };
    }

    const dedupe = new Map();
    for (const p of participants) {
        const phone = pPhone(p);
        if (!phone) { stats.invalid_count++; continue; }
        if (dedupe.has(phone)) { stats.duplicate_count++; continue; }
        dedupe.set(phone, { name: pName(p, phone), phone_raw: `+${phone}` });
    }

    return {
        ok: true,
        _v: VERSION,
        source: "runtime",
        group_name: gName(chat),
        group_identifier: targetId || sid(chat?.id),
        members: Array.from(dedupe.values()),
        total: dedupe.size,
        expected_count: 0,
        stats,
        _errors: errors,
    };
}

/* ══════════════════════════════════════════════════════════════
   STRATEGY 2 — PANEL-SCOPED DOM EXTRACTION
   ────────────────────────────────────────────────────────────
   Runs in MAIN world so it has access to the same DOM.
   
   CRITICAL DIFFERENCE from v1.1 / v1.2:
     • Does NOT exclude #main — the member list panel may live
       inside the center column (#main area).
     • Finds the member panel by LANDMARK TEXT ("Search members"
       or "N participants") then scopes to that panel only.
     • Chat sidebar (#side) is explicitly excluded.
   ══════════════════════════════════════════════════════════════ */

function domFallbackExtract() {
    const VERSION = "1.3.0";
    const stats = { invalid_count: 0, duplicate_count: 0, name_only_count: 0 };
    const map = new Map();
    const dupSet = new Set();

    function addMember(rawName, rawPhone) {
        const digits = String(rawPhone || "").replace(/\D/g, "");
        if (digits.length < 8 || digits.length > 15) { stats.invalid_count++; return; }
        if (map.has(digits)) {
            if (!dupSet.has(digits)) { dupSet.add(digits); stats.duplicate_count++; }
            return;
        }
        map.set(digits, {
            name: String(rawName || "").trim().slice(0, 191) || `+${digits}`,
            phone_raw: `+${digits}`,
        });
    }

    /* ─── Step 1: Find the member-list panel ─── */

    // The chat sidebar (left column) — we EXCLUDE this.
    const chatSidebar = document.querySelector("#side") || document.querySelector("#pane-side");

    function isInSidebar(el) {
        return chatSidebar ? chatSidebar.contains(el) : false;
    }

    function findMemberPanel() {
        const candidates = [];

        // --- Strategy A: Find "Search members" or "N participants" header text ---
        const textEls = document.querySelectorAll("span, div, h1, h2, h3, h4, header, p");
        for (const el of textEls) {
            if (isInSidebar(el)) continue;
            const txt = (el.textContent || "").trim();

            // Match "Search members" exact
            // or "N participants" / "N members"
            const isSearchHeader = /^search\s+(members|participants)/i.test(txt);
            const isCountHeader = /^\d+\s+(participant|member)s?$/i.test(txt);

            if (!isSearchHeader && !isCountHeader) continue;

            // Walk up to find a container with role="listitem" elements
            let parent = el.parentElement;
            for (let i = 0; i < 25 && parent && parent !== document.body; i++) {
                const items = parent.querySelectorAll('[role="listitem"]');
                if (items.length >= 3) {
                    candidates.push({ el: parent, count: items.length, priority: isSearchHeader ? 10 : 5 });
                    break;
                }
                parent = parent.parentElement;
            }
        }

        // --- Strategy B: role="list" containers (not in sidebar) ---
        const lists = document.querySelectorAll('[role="list"]');
        for (const list of lists) {
            if (isInSidebar(list)) continue;
            const items = list.querySelectorAll('[role="listitem"]');
            if (items.length >= 3) {
                candidates.push({ el: list, count: items.length, priority: 2 });
            }
        }

        // --- Strategy C: Scrollable containers with data-jid listitems (not in sidebar) ---
        if (candidates.length === 0) {
            const divs = document.querySelectorAll("div");
            for (const d of divs) {
                if (isInSidebar(d)) continue;
                if (d.scrollHeight <= d.clientHeight + 50 || d.clientHeight < 80) continue;
                const items = d.querySelectorAll('[role="listitem"]');
                let memberLike = 0;
                for (const item of items) {
                    const jid = item.getAttribute("data-jid") || "";
                    if (jid.includes("@c.us") || jid.includes("@s.whatsapp.net")) memberLike++;
                }
                if (memberLike >= 3) {
                    candidates.push({ el: d, count: memberLike, priority: 1 });
                }
            }
        }

        // Pick best: highest priority first, then most listitems
        candidates.sort((a, b) => b.priority - a.priority || b.count - a.count);
        return candidates[0]?.el || null;
    }

    const memberPanel = findMemberPanel();
    if (!memberPanel) {
        return {
            ok: false,
            _v: VERSION,
            error: "member_panel_not_found — Open the full member list: click the group header → scroll to Members → 'View all' or 'Search members'.",
        };
    }

    /* ─── Step 2: Parse expected count from panel header ─── */
    let expectedCount = 0;
    const allSpans = memberPanel.querySelectorAll("span, div, p");
    for (const el of allSpans) {
        const m = (el.textContent || "").trim().match(/^(\d+)\s+(participant|member)s?$/i);
        if (m) { expectedCount = parseInt(m[1], 10); break; }
    }

    /* ─── Step 3: Find scrollable container within panel ─── */
    function findScrollable(root) {
        if (!root) return null;
        // Check if root itself scrolls
        if (root.scrollHeight > root.clientHeight + 40 && root.clientHeight > 80) return root;
        // Check children (deepest scrollable wins — likely the actual list scroller)
        const kids = Array.from(root.querySelectorAll("div"))
            .filter(d => d.scrollHeight > d.clientHeight + 40 && d.clientHeight > 80)
            .sort((a, b) => {
                // Prefer the one with more listitems directly
                const aItems = a.querySelectorAll(':scope > [role="listitem"]').length;
                const bItems = b.querySelectorAll(':scope > [role="listitem"]').length;
                return bItems - aItems || b.scrollHeight - a.scrollHeight;
            });
        return kids[0] || null;
    }

    const scrollable = findScrollable(memberPanel);

    /* ─── Step 4: Collect members from panel ─── */
    function collectMembers() {
        // Method 1: role="listitem" elements within the panel
        const items = memberPanel.querySelectorAll('[role="listitem"]');
        for (const item of items) {
            if (isInSidebar(item)) continue;

            let found = false;

            // (a) data-jid on the listitem itself
            const jid = item.getAttribute("data-jid") || "";
            if (jid.includes("@c.us") || jid.includes("@s.whatsapp.net")) {
                const phone = jid.split("@")[0].replace(/\D/g, "");
                if (phone.length >= 8 && phone.length <= 15) {
                    const nameEl = item.querySelector("span[title]");
                    const name = nameEl ? (nameEl.getAttribute("title") || nameEl.textContent || "").trim() : "";
                    addMember(name, phone);
                    found = true;
                }
            }

            // (b) Nested element with data-jid
            if (!found) {
                const jidEl = item.querySelector("[data-jid]");
                if (jidEl) {
                    const j2 = jidEl.getAttribute("data-jid") || "";
                    if (j2.includes("@c.us") || j2.includes("@s.whatsapp.net")) {
                        const phone = j2.split("@")[0].replace(/\D/g, "");
                        if (phone.length >= 8 && phone.length <= 15) {
                            const nameEl = item.querySelector("span[title]");
                            const name = nameEl ? (nameEl.getAttribute("title") || nameEl.textContent || "").trim() : "";
                            addMember(name, phone);
                            found = true;
                        }
                    }
                }
            }

            // (c) span[title] with phone number pattern
            if (!found) {
                const titleEl = item.querySelector("span[title]");
                if (titleEl) {
                    const title = (titleEl.getAttribute("title") || "").trim();
                    const phoneMatch = title.match(/(\+?\d[\d\s()\-]{5,}\d)/);
                    if (phoneMatch) {
                        const cleanName = title.replace(phoneMatch[1], "").replace(/[,;:\-\s]+$/, "").trim();
                        addMember(cleanName, phoneMatch[1]);
                        found = true;
                    } else if (title && title.toLowerCase() !== "you") {
                        // Saved contact — name visible but phone NOT in DOM
                        stats.name_only_count++;
                    }
                }
            }
        }

        // Method 2: data-jid elements within panel that aren't listitems
        const jidEls = memberPanel.querySelectorAll("[data-jid]");
        for (const el of jidEls) {
            if (isInSidebar(el)) continue;
            const jid = el.getAttribute("data-jid") || "";
            if (!jid.includes("@c.us") && !jid.includes("@s.whatsapp.net")) continue;
            const phone = jid.split("@")[0].replace(/\D/g, "");
            if (phone.length < 8 || phone.length > 15 || map.has(phone)) continue;
            const nameEl = el.querySelector("span[title]") || el.querySelector("span[dir='auto']");
            const name = nameEl ? (nameEl.getAttribute("title") || nameEl.textContent || "").trim() : "";
            addMember(name, phone);
        }
    }

    /* ─── Step 5: Scroll through the member list ─── */
    async function scrollAndCollect() {
        let stableCount = 0;
        for (let i = 0; i < 300; i++) {
            collectMembers();
            if (!scrollable) break;

            const before = scrollable.scrollTop;
            scrollable.scrollTop = before + Math.max(100, Math.floor(scrollable.clientHeight * 0.75));
            await new Promise(r => setTimeout(r, 280));

            if (Math.abs(scrollable.scrollTop - before) < 4) {
                if (++stableCount >= 5) break;
            } else {
                stableCount = 0;
            }
        }

        // Final pass: scroll to top and collect any initially visible items
        if (scrollable) {
            scrollable.scrollTop = 0;
            await new Promise(r => setTimeout(r, 400));
            collectMembers();
        }
    }

    // This function is async, so we return a Promise
    return (async () => {
        await scrollAndCollect();

        /* ─── Step 6: Group name ─── */
        function resolveGroupName() {
            // 1) Main header (most reliable for group name)
            const mainHeader = document.querySelector("#main header span[title]");
            if (mainHeader) {
                const t = (mainHeader.getAttribute("title") || "").trim();
                if (t && t.split(",").length <= 4 && t.length < 120) return t.slice(0, 191);
            }
            // 2) Conversation info header
            const infoHeader = document.querySelector('[data-testid="conversation-info-header"] span[title]');
            if (infoHeader) {
                const t = (infoHeader.getAttribute("title") || "").trim();
                if (t && t.split(",").length <= 4 && t.length < 120) return t.slice(0, 191);
            }
            // 3) Any header span outside the member panel
            const headers = document.querySelectorAll("header span[title]");
            for (const h of headers) {
                if (memberPanel.contains(h)) continue;
                const t = (h.getAttribute("title") || "").trim();
                if (t && t.split(",").length <= 4 && t.length < 120 && t.length > 2) return t.slice(0, 191);
            }
            return "WhatsApp Group";
        }

        const members = Array.from(map.values());
        return {
            ok: true,
            _v: VERSION,
            source: "dom",
            group_name: resolveGroupName(),
            group_identifier: decodeURIComponent(String(window.location.hash || "")).replace(/^#\/?/, "").split("?")[0],
            members,
            total: members.length,
            expected_count: expectedCount,
            stats,
        };
    })();
}

/* ────────────────────────────────────────────
   Crypto / URL Utilities
   ──────────────────────────────────────────── */

function normalizeUrl(base, endpoint) {
    return String(base || "").replace(/\/+$/, "") + (endpoint ? "/" + String(endpoint).replace(/^\/+/, "") : "");
}
function randomToken(n) {
    const c = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return Array.from(crypto.getRandomValues(new Uint8Array(n)), b => c[b % c.length]).join("");
}
async function sha256Hex(v) {
    return bytesToHex(new Uint8Array(await crypto.subtle.digest("SHA-256", new TextEncoder().encode(v))));
}
async function hmacSha256Hex(v, s) {
    const k = await crypto.subtle.importKey("raw", new TextEncoder().encode(s), { name: "HMAC", hash: "SHA-256" }, false, ["sign"]);
    return bytesToHex(new Uint8Array(await crypto.subtle.sign("HMAC", k, new TextEncoder().encode(v))));
}
function bytesToHex(b) { return Array.from(b, x => x.toString(16).padStart(2, "0")).join(""); }
