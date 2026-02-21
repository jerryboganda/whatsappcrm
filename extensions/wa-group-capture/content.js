(function () {
    const CRM_HOST = "whatsapp.firstaidmadeeasy.com.pk";
    const WA_HOST = "web.whatsapp.com";

    if (window.location.host === CRM_HOST) {
        setupCrmBridge();
    }

    if (window.location.host === WA_HOST) {
        setupWhatsappScanner();
    }

    function setupCrmBridge() {
        window.addEventListener("message", (event) => {
            if (!event.data || event.data.type !== "GE_EXTENSION_CONFIG") {
                return;
            }

            chrome.runtime.sendMessage({
                action: "GE_SAVE_CONFIG",
                payload: event.data.payload || null,
            }, (response) => {
                if (response && response.ok) {
                    window.postMessage({
                        type: "GE_EXTENSION_NOTIFY",
                        level: "success",
                        message: "Extension session synchronized",
                    }, "*");
                } else {
                    window.postMessage({
                        type: "GE_EXTENSION_NOTIFY",
                        level: "error",
                        message: response?.error || "Failed to sync extension session",
                    }, "*");
                }
            });
        });

        chrome.runtime.onMessage.addListener((message, sender, sendResponse) => {
            if (message?.type === "GE_EXTENSION_JOB_CREATED") {
                window.postMessage({
                    type: "GE_EXTENSION_JOB_CREATED",
                    job_id: message.job_id,
                }, "*");
            }
            sendResponse({ ok: true });
            return false;
        });
    }

    function setupWhatsappScanner() {
        chrome.runtime.onMessage.addListener((message, sender, sendResponse) => {
            if (message?.action !== "GE_SCAN_GROUP_MEMBERS") {
                return false;
            }

            scanGroupMembers()
                .then((result) => sendResponse({ ok: true, ...result }))
                .catch((error) => sendResponse({ ok: false, error: error?.message || "scan_failed" }));

            return true;
        });
    }

    async function scanGroupMembers() {
        const memberMap = new Map();
        const duplicateKeys = new Set();
        const stats = {
            invalid_count: 0,
            duplicate_count: 0,
        };
        const container = findScrollableContainer();
        let stableTicks = 0;
        let loops = 0;

        while (loops < 80) {
            collectMembersFromVisibleRows(memberMap, stats, duplicateKeys);
            if (!container) {
                break;
            }

            const previousTop = container.scrollTop;
            const step = Math.max(120, Math.floor(container.clientHeight * 0.85));
            container.scrollTop = previousTop + step;
            await sleep(180);

            if (Math.abs(container.scrollTop - previousTop) < 4) {
                stableTicks += 1;
            } else {
                stableTicks = 0;
            }

            if (stableTicks >= 6) {
                break;
            }
            loops += 1;
        }

        collectMembersFromTitles(memberMap, stats, duplicateKeys);

        const members = Array.from(memberMap.values());
        const groupName = resolveGroupName();
        const groupIdentifier = resolveGroupIdentifier();

        return {
            group_name: groupName,
            group_identifier: groupIdentifier,
            members: members,
            total: members.length,
            stats,
        };
    }

    function collectMembersFromVisibleRows(map, stats, duplicateKeys) {
        const rows = document.querySelectorAll(
            "div[role='listitem'], div[data-testid*='cell-frame-container'], div[data-testid*='cell-frame-title'], div[role='button']"
        );

        rows.forEach((row) => {
            const text = (row.innerText || "").trim();
            if (!text) {
                return;
            }

            const matches = text.match(/(\+?\d[\d\s()\-]{6,}\d)/g) || [];
            if (!matches.length) {
                return;
            }

            const primaryPhone = matches[0];
            const name = deriveName(text, primaryPhone);
            addMember(map, name, primaryPhone, stats, duplicateKeys);
        });
    }

    function collectMembersFromTitles(map, stats, duplicateKeys) {
        const nodes = document.querySelectorAll("[title]");
        nodes.forEach((node) => {
            const title = (node.getAttribute("title") || "").trim();
            if (!title) {
                return;
            }

            const match = title.match(/(\+?\d[\d\s()\-]{6,}\d)/);
            if (!match) {
                return;
            }

            addMember(map, deriveName(title, match[1]), match[1], stats, duplicateKeys);
        });
    }

    function addMember(map, rawName, rawPhone, stats, duplicateKeys) {
        const phoneDigits = (rawPhone || "").replace(/\D+/g, "");
        if (phoneDigits.length < 8 || phoneDigits.length > 15) {
            if (stats) {
                stats.invalid_count += 1;
            }
            return;
        }

        const normalizedPhone = rawPhone.trim();
        const cleanName = (rawName || "").trim().slice(0, 191);
        const key = phoneDigits;

        if (!map.has(key)) {
            map.set(key, {
                name: cleanName,
                phone_raw: normalizedPhone,
            });
        } else if (stats && duplicateKeys && !duplicateKeys.has(key)) {
            duplicateKeys.add(key);
            stats.duplicate_count += 1;
        }
    }

    function deriveName(text, phone) {
        const firstLine = (text.split("\n")[0] || "").trim();
        const withoutPhone = firstLine.replace(phone, "").trim();
        return withoutPhone || firstLine || "";
    }

    function resolveGroupName() {
        const selectors = [
            "#main header span[title]",
            "div[data-testid='conversation-info-header'] span[title]",
            "header span[dir='auto'][title]",
        ];

        for (const selector of selectors) {
            const el = document.querySelector(selector);
            if (el) {
                const title = (el.getAttribute("title") || el.textContent || "").trim();
                if (title) {
                    return title.slice(0, 191);
                }
            }
        }

        return "WhatsApp Group";
    }

    function resolveGroupIdentifier() {
        const hash = (window.location.hash || "").replace(/^#/, "").trim();
        return hash ? hash.slice(0, 191) : "";
    }

    function findScrollableContainer() {
        const candidates = Array.from(document.querySelectorAll("div"))
            .filter((el) => el.scrollHeight > (el.clientHeight + 80) && el.clientHeight > 200);

        if (!candidates.length) {
            return null;
        }

        candidates.sort((a, b) => b.scrollHeight - a.scrollHeight);
        return candidates[0];
    }

    function sleep(ms) {
        return new Promise((resolve) => setTimeout(resolve, ms));
    }
})();
