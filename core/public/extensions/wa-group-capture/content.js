(function () {
    const CRM_HOST = "whatsapp.firstaidmadeeasy.com.pk";

    // Only set up the CRM bridge on the CRM domain.
    // NOTE: The WhatsApp Web scanner has been REMOVED from content.js
    // to avoid a race condition with background.js which handles scanning
    // via chrome.scripting.executeScript (main world + DOM fallback).
    if (window.location.host === CRM_HOST) {
        setupCrmBridge();
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
})();
