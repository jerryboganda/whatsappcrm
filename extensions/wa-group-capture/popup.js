const UPLOAD_STATE_KEY = "group_extraction_upload_state";

let cachedConfig = null;
let isBusy = false;
let lastDiagnostics = null;
let lastScan = {
    group_name: "",
    group_identifier: "",
    source: "",
    members: [],
    stats: {
        invalid_count: 0,
        duplicate_count: 0,
    },
};

const scanBtn = document.getElementById("scanBtn");
const importBtn = document.getElementById("importBtn");
const copyJsonBtn = document.getElementById("copyJsonBtn");
const copyCsvBtn = document.getElementById("copyCsvBtn");
const statusText = document.getElementById("statusText");
const groupNameEl = document.getElementById("groupName");
const memberCountEl = document.getElementById("memberCount");
const invalidCountEl = document.getElementById("invalidCount");
const duplicateCountEl = document.getElementById("duplicateCount");
const configStateEl = document.getElementById("configState");

scanBtn.addEventListener("click", scanMembers);
importBtn.addEventListener("click", importMembers);
copyJsonBtn.addEventListener("click", copyJson);
copyCsvBtn.addEventListener("click", copyCsv);

init();

async function init() {
    const configResponse = await sendToBackground({ action: "GE_GET_CONFIG" });
    cachedConfig = configResponse?.config || null;
    renderConfigState();
}

async function scanMembers() {
    if (isBusy) {
        return;
    }

    const tab = await getActiveTab();
    if (!tab || !tab.url || !tab.url.startsWith("https://web.whatsapp.com/")) {
        setStatus("Open WhatsApp Web group info panel in the active tab first.");
        return;
    }

    setStatus("Scanning members...");
    const response = await sendToBackground({ action: "GE_SCAN_GROUP_MEMBERS", tabId: tab.id });
    if (!response?.ok) {
        setStatus(response?.error || "Scan failed.");
        return;
    }

    lastScan = {
        group_name: response.group_name || "WhatsApp Group",
        group_identifier: response.group_identifier || "",
        source: response.source || "",
        members: response.members || [],
        stats: {
            invalid_count: Number(response?.stats?.invalid_count || 0),
            duplicate_count: Number(response?.stats?.duplicate_count || 0),
        },
    };
    lastDiagnostics = response?.diagnostics || null;

    renderScanSummary();
    const sourceTag = lastScan.source ? ` (${lastScan.source})` : "";
    const mainCount = Number(lastDiagnostics?.main?.count || 0);
    const domCount = Number(lastDiagnostics?.dom?.count || 0);
    const domHints = Number(lastDiagnostics?.dom?.diagnostics?.container_phone_hints || 0);
    const mainErr = String(lastDiagnostics?.main?.error || "").trim();
    const diagTag = (lastDiagnostics && lastScan.source === "dom_fallback_v2")
        ? ` [main:${mainCount} dom:${domCount}${domHints ? ` hints:${domHints}` : ""}${mainErr ? ` err:${mainErr.slice(0, 40)}` : ""}]`
        : "";
    setStatus(`Scan complete${sourceTag}. ${lastScan.members.length} unique members captured.${diagTag}`);
}

async function importMembers() {
    if (isBusy) {
        return;
    }

    if (!cachedConfig?.api_base || !cachedConfig?.session_token || !cachedConfig?.signing_secret) {
        setStatus("Extension not linked. Click Connect Extension in CRM first.");
        return;
    }

    if (!lastScan.members || !lastScan.members.length) {
        setStatus("No scanned members found. Click Scan Members first.");
        return;
    }

    setBusy(true);

    try {
        const chunkSize = clampInt(cachedConfig.default_chunk_size || 500, 50, 1000);
        const totalMembers = lastScan.members.length;
        const totalChunks = Math.max(1, Math.ceil(totalMembers / chunkSize));
        const groupKey = buildGroupKey(lastScan, cachedConfig, totalMembers, chunkSize);

        let uploadState = await storageGet(UPLOAD_STATE_KEY);
        let jobId = null;
        let nextChunkIndex = 0;
        let resumeFinalizeOnly = false;

        if (
            uploadState &&
            uploadState.group_key === groupKey &&
            uploadState.session_token === cachedConfig.session_token &&
            Number(uploadState.job_id || 0) > 0 &&
            Number(uploadState.total_chunks || 0) === totalChunks
        ) {
            jobId = Number(uploadState.job_id);
            nextChunkIndex = Number(uploadState.next_chunk_index || 0);
            if (nextChunkIndex >= totalChunks) {
                resumeFinalizeOnly = true;
                setStatus(`Resuming finalize for job #${jobId}...`);
            } else {
                setStatus(`Resuming upload for job #${jobId} from chunk ${nextChunkIndex + 1}/${totalChunks}...`);
            }
        } else {
            const createResponse = await signedRequest("jobs", "POST", {
                group_name: lastScan.group_name || "WhatsApp Group",
                group_identifier: lastScan.group_identifier || "",
                country_hint: (cachedConfig.country_hint || "PK").toUpperCase(),
                target_contact_list_id: cachedConfig.target_contact_list_id || null,
                attested: true,
                chunk_size: chunkSize,
            });

            if (!createResponse.ok) {
                setStatus(extractApiError(createResponse, "Failed to create import job."));
                return;
            }

            jobId = Number(createResponse?.data?.data?.job_id || 0);
            if (!jobId) {
                setStatus("Job creation response is missing job id.");
                return;
            }

            uploadState = {
                group_key: groupKey,
                session_token: cachedConfig.session_token,
                job_id: jobId,
                total_members: totalMembers,
                chunk_size: chunkSize,
                total_chunks: totalChunks,
                next_chunk_index: 0,
            };
            await storageSet(UPLOAD_STATE_KEY, uploadState);
            nextChunkIndex = 0;
            setStatus(`Job #${jobId} created. Uploading chunks...`);
        }

        if (!resumeFinalizeOnly) {
            for (let index = nextChunkIndex; index < totalChunks; index += 1) {
                const from = index * chunkSize;
                const to = Math.min(from + chunkSize, totalMembers);
                const chunk = lastScan.members.slice(from, to);

                const chunkResponse = await signedRequest(`jobs/${jobId}/chunks`, "POST", {
                    members: chunk,
                });

                if (!chunkResponse.ok) {
                    await storageSet(UPLOAD_STATE_KEY, {
                        ...uploadState,
                        next_chunk_index: index,
                    });
                    setStatus(
                        `Upload paused at chunk ${index + 1}/${totalChunks}. ` +
                            extractApiError(chunkResponse, "Network or API error.")
                    );
                    return;
                }

                await storageSet(UPLOAD_STATE_KEY, {
                    ...uploadState,
                    next_chunk_index: index + 1,
                });

                setStatus(`Uploaded chunk ${index + 1}/${totalChunks} for job #${jobId}...`);
            }
        }

        const finalizeResponse = await signedRequest(`jobs/${jobId}/finalize`, "POST", {});
        if (!finalizeResponse.ok) {
            setStatus(extractApiError(finalizeResponse, "Upload finished but finalize failed."));
            return;
        }

        await storageRemove(UPLOAD_STATE_KEY);
        await notifyCrmJobCreated(jobId);
        setStatus(`Import queued successfully. Job #${jobId}`);
    } finally {
        setBusy(false);
    }
}

async function copyJson() {
    if (!lastScan.members.length) {
        setStatus("Nothing to copy. Scan members first.");
        return;
    }

    await navigator.clipboard.writeText(JSON.stringify(lastScan, null, 2));
    setStatus("JSON copied to clipboard.");
}

async function copyCsv() {
    if (!lastScan.members.length) {
        setStatus("Nothing to copy. Scan members first.");
        return;
    }

    const header = "name,phone_raw\n";
    const rows = lastScan.members
        .map((member) => `${csvEscape(member.name || "")},${csvEscape(member.phone_raw || "")}`)
        .join("\n");

    await navigator.clipboard.writeText(header + rows);
    setStatus("CSV copied to clipboard.");
}

function renderScanSummary() {
    groupNameEl.textContent = lastScan.group_name || "-";
    memberCountEl.textContent = String(lastScan.members.length);
    invalidCountEl.textContent = String(lastScan.stats.invalid_count || 0);
    duplicateCountEl.textContent = String(lastScan.stats.duplicate_count || 0);
}

function renderConfigState() {
    configStateEl.textContent = cachedConfig ? "Linked" : "Not linked";
}

function setStatus(message) {
    statusText.textContent = message;
}

function setBusy(value) {
    isBusy = !!value;
    scanBtn.disabled = isBusy;
    importBtn.disabled = isBusy;
}

function buildGroupKey(scan, config, totalMembers, chunkSize) {
    return [
        String(scan.group_identifier || ""),
        String(scan.group_name || ""),
        String(totalMembers),
        String(chunkSize),
        String(config.target_contact_list_id || ""),
    ].join("|");
}

function clampInt(value, min, max) {
    const num = Number(value || 0);
    if (Number.isNaN(num)) {
        return min;
    }
    if (num < min) {
        return min;
    }
    if (num > max) {
        return max;
    }
    return Math.floor(num);
}

async function signedRequest(endpoint, method, body) {
    return sendToBackground({
        action: "GE_SIGNED_REQUEST",
        payload: {
            config: cachedConfig,
            endpoint,
            method,
            body,
        },
    });
}

function extractApiError(response, fallback) {
    const message = response?.data?.message;
    if (Array.isArray(message) && message.length) {
        return String(message[0]);
    }
    if (typeof message === "string" && message.trim() !== "") {
        return message;
    }

    const errors = response?.data?.errors;
    if (errors && typeof errors === "object") {
        const firstKey = Object.keys(errors)[0];
        const firstValue = firstKey ? errors[firstKey] : null;
        if (Array.isArray(firstValue) && firstValue.length) {
            return String(firstValue[0]);
        }
    }

    return response?.error || fallback;
}

function csvEscape(value) {
    const str = String(value || "");
    if (/[",\n]/.test(str)) {
        return `"${str.replace(/"/g, '""')}"`;
    }
    return str;
}

function getActiveTab() {
    return new Promise((resolve) => {
        chrome.tabs.query({ active: true, currentWindow: true }, (tabs) => {
            resolve((tabs || [])[0] || null);
        });
    });
}

function sendToTab(tabId, message) {
    return new Promise((resolve) => {
        chrome.tabs.sendMessage(tabId, message, (response) => {
            if (chrome.runtime.lastError) {
                resolve({ ok: false, error: chrome.runtime.lastError.message });
                return;
            }
            resolve(response || { ok: false, error: "No response" });
        });
    });
}

function sendToBackground(message) {
    return new Promise((resolve) => {
        chrome.runtime.sendMessage(message, (response) => {
            if (chrome.runtime.lastError) {
                resolve({ ok: false, error: chrome.runtime.lastError.message });
                return;
            }
            resolve(response || { ok: false, error: "No response" });
        });
    });
}

function storageGet(key) {
    return new Promise((resolve) => {
        chrome.storage.local.get(key, (data) => resolve(data ? data[key] : null));
    });
}

function storageSet(key, value) {
    return new Promise((resolve) => {
        chrome.storage.local.set({ [key]: value }, () => resolve(true));
    });
}

function storageRemove(key) {
    return new Promise((resolve) => {
        chrome.storage.local.remove(key, () => resolve(true));
    });
}

async function notifyCrmJobCreated(jobId) {
    return new Promise((resolve) => {
        chrome.tabs.query({ url: "https://whatsapp.firstaidmadeeasy.com.pk/*" }, (tabs) => {
            const requests = (tabs || []).map((tab) =>
                sendToTab(tab.id, {
                    type: "GE_EXTENSION_JOB_CREATED",
                    job_id: jobId,
                })
            );
            Promise.allSettled(requests).then(() => resolve());
        });
    });
}
