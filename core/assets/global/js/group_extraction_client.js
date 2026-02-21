(function (window, $) {
    "use strict";

    if (!window || !$) {
        return;
    }

    const state = {
        routes: {},
        selectors: {},
        currentJobId: null,
        pollTimer: null,
    };

    function init(config) {
        state.routes = config.routes || {};
        state.selectors = config.selectors || {};
        bindUI();
        bindWindowMessages();
    }

    function bindUI() {
        $(state.selectors.connectBtn).on('click', onConnectClick);
        $(state.selectors.historyBtn).on('click', loadHistory);
        $(state.selectors.retryBtn).on('click', retryFailed);
        $(state.selectors.failedCsvBtn).on('click', downloadFailedCsv);
    }

    function bindWindowMessages() {
        window.addEventListener('message', function (event) {
            const data = event.data || {};

            if (data.type === 'GE_EXTENSION_JOB_CREATED' && data.job_id) {
                state.currentJobId = data.job_id;
                setStatusText('Extension created job #' + data.job_id + '. Tracking progress...');
                startPolling(data.job_id);
            }

            if (data.type === 'GE_EXTENSION_NOTIFY' && data.level && data.message && typeof notify === 'function') {
                notify(data.level, data.message);
            }
        });
    }

    function onConnectClick() {
        const attested = !!$(state.selectors.attestation).is(':checked');
        if (!attested) {
            notify('error', 'Please accept the compliance attestation first.');
            return;
        }

        postJson(state.routes.session, {
            attested: 1,
            allowed_origin: window.location.origin,
        }).done(function (res) {
            const data = resolveSessionPayload(res);
            if (!data) {
                notify('error', extractResponseMessage(res, 'Invalid session response from server.'));
                return;
            }

            const payload = {
                session_token: data.session_token,
                signing_secret: data.signing_secret,
                expires_at: data.expires_at,
                api_base: data.api_base,
                default_chunk_size: data.default_chunk_size || 500,
                max_members_per_job: data.max_members_per_job || 10000,
                target_contact_list_id: $(state.selectors.contactList).val() || null,
                country_hint: ($(state.selectors.countryHint).val() || 'PK').toUpperCase(),
                attested: true,
            };

            window.postMessage({
                type: 'GE_EXTENSION_CONFIG',
                payload: payload,
            }, '*');

            setStatusText('Extension session ready. Open WhatsApp Web and start extraction from the extension popup.');
            notify('success', 'Extension session created and broadcast to extension bridge.');
        }).fail(function (xhr) {
            notify('error', extractError(xhr, 'Failed to create extension session'));
        });
    }

    function loadHistory() {
        getJson(state.routes.history + '?paginate=5').done(function (res) {
            const history = (((res || {}).data || {}).history || {}).data || [];
            const $panel = $(state.selectors.historyPanel);

            if (!history.length) {
                $panel.html('<div class="text-muted fs-13">No extraction history yet.</div>');
                return;
            }

            const rows = history.map(function (job) {
                return `
                    <div class="d-flex justify-content-between align-items-center border rounded p-2 mb-2">
                        <div>
                            <div><strong>#${job.id}</strong> ${escapeHtml(job.group_name || 'Unnamed Group')}</div>
                            <small class="text-muted">Status: ${job.status} | Total: ${job.total_rows} | Processed: ${job.processed_rows}</small>
                        </div>
                        <button class="btn btn--sm btn--dark ge-track-history" data-job-id="${job.id}">Track</button>
                    </div>
                `;
            }).join('');

            $panel.html(rows);
            $('.ge-track-history').off('click').on('click', function () {
                const jobId = $(this).data('job-id');
                state.currentJobId = jobId;
                startPolling(jobId);
            });
        }).fail(function (xhr) {
            notify('error', extractError(xhr, 'Failed to load history'));
        });
    }

    function retryFailed() {
        if (!state.currentJobId) {
            notify('warning', 'No active job selected for retry.');
            return;
        }

        const url = withJobId(state.routes.retry, state.currentJobId);
        postJson(url, {
            country_hint: ($(state.selectors.countryHint).val() || 'PK').toUpperCase(),
        }).done(function (res) {
            notify('success', messageFromResponse(res, 'Retry queued.'));
            startPolling(state.currentJobId);
        }).fail(function (xhr) {
            notify('error', extractError(xhr, 'Failed to retry failed rows'));
        });
    }

    function downloadFailedCsv() {
        if (!state.currentJobId) {
            notify('warning', 'No active job selected.');
            return;
        }

        const baseUrl = withJobId(state.routes.result, state.currentJobId);
        window.open(baseUrl + '?download=failed_csv', '_blank');
    }

    function startPolling(jobId) {
        if (!jobId) {
            return;
        }

        state.currentJobId = jobId;
        stopPolling();
        pollJobStatus();
        state.pollTimer = setInterval(pollJobStatus, 2000);
    }

    function stopPolling() {
        if (state.pollTimer) {
            clearInterval(state.pollTimer);
            state.pollTimer = null;
        }
    }

    function pollJobStatus() {
        if (!state.currentJobId) {
            return;
        }

        const url = withJobId(state.routes.status, state.currentJobId);
        getJson(url).done(function (res) {
            const job = (((res || {}).data || {}).job) || null;
            if (!job) {
                return;
            }

            renderJob(job);
            const terminal = [2, 8, 9].includes(Number(job.status));
            if (terminal) {
                stopPolling();
                if (job.contact_list_id) {
                    window.localStorage.setItem('groupExtractionLastListId', String(job.contact_list_id));
                    window.localStorage.setItem('groupExtractionLastJobId', String(job.id));
                }
            }
        }).fail(function (xhr) {
            stopPolling();
            notify('error', extractError(xhr, 'Failed to poll extraction status'));
        });
    }

    function renderJob(job) {
        $(state.selectors.jobPanel).removeClass('d-none');
        $(state.selectors.jobId).text(job.id || '-');
        $(state.selectors.jobStatus).text(statusLabel(job.status));
        $(state.selectors.total).text(job.total_rows || 0);
        $(state.selectors.processed).text(job.processed_rows || 0);
        $(state.selectors.imported).text(job.imported_count || 0);
        $(state.selectors.updated).text(job.updated_count || 0);
        $(state.selectors.skipped).text(job.skipped_count || 0);
        $(state.selectors.failed).text(job.failed_count || 0);
        $(state.selectors.progressBar).css('width', (job.progress_percent || 0) + '%');
        setStatusText('Tracking job #' + job.id + ' (' + (job.progress_percent || 0) + '%)');
    }

    function setStatusText(text) {
        $(state.selectors.statusText).text(text);
    }

    function withJobId(pattern, jobId) {
        return String(pattern || '').replace('__JOB_ID__', String(jobId));
    }

    function resolveSessionPayload(res) {
        const candidates = [];
        if (res && typeof res === 'object') {
            candidates.push(res.data || null);
            candidates.push(((res.data || {}).data) || null);
            candidates.push(res);
        }

        for (let i = 0; i < candidates.length; i += 1) {
            const item = candidates[i];
            if (!item || typeof item !== 'object') {
                continue;
            }
            if (item.session_token && item.signing_secret) {
                return item;
            }
        }

        return null;
    }

    function statusLabel(status) {
        const map = {
            0: 'Queued',
            1: 'Processing',
            2: 'Completed',
            8: 'Partial',
            9: 'Failed',
            10: 'Ingesting',
        };
        const code = Number(status);
        return map[code] || String(status || '-');
    }

    function getJson(url) {
        return $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': csrfToken(),
                'X-XSRF-TOKEN': xsrfToken(),
                'X-Requested-With': 'XMLHttpRequest',
            }
        });
    }

    function postJson(url, data) {
        return $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: Object.assign({
                _token: csrfToken(),
            }, data || {}),
            headers: {
                'X-CSRF-TOKEN': csrfToken(),
                'X-XSRF-TOKEN': xsrfToken(),
                'X-Requested-With': 'XMLHttpRequest',
            }
        });
    }

    function csrfToken() {
        const metaToken = $('meta[name="csrf-token"]').attr('content');
        if (metaToken) {
            return metaToken;
        }

        const inputToken = $('input[name="_token"]').first().val();
        if (inputToken) {
            return inputToken;
        }

        const cookieToken = xsrfToken();
        if (cookieToken) {
            return cookieToken;
        }

        return '';
    }

    function xsrfToken() {
        const match = document.cookie.match(/(?:^|;\s*)XSRF-TOKEN=([^;]+)/);
        if (!match || !match[1]) {
            return '';
        }

        try {
            return decodeURIComponent(match[1]);
        } catch (error) {
            return match[1];
        }
    }

    function messageFromResponse(res, fallback) {
        const msg = (((res || {}).message || [])[0]) || '';
        return msg || fallback;
    }

    function extractResponseMessage(res, fallback) {
        const message = (res || {}).message;
        if (Array.isArray(message) && message.length) {
            return String(message[0]);
        }

        if (typeof message === 'string' && message.trim() !== '') {
            return message;
        }

        const errors = (res || {}).errors;
        if (errors && typeof errors === 'object') {
            const keys = Object.keys(errors);
            if (keys.length > 0) {
                const first = errors[keys[0]];
                if (Array.isArray(first) && first.length) {
                    return String(first[0]);
                }
            }
        }

        return fallback;
    }

    function extractError(xhr, fallback) {
        const payload = ((xhr || {}).responseJSON || {});
        const message = payload.message;
        if (Array.isArray(message) && message.length) {
            return String(message[0]);
        }
        if (typeof message === 'string' && message.trim() !== '') {
            return message;
        }

        if (payload.errors && typeof payload.errors === 'object') {
            const keys = Object.keys(payload.errors);
            if (keys.length > 0) {
                const first = payload.errors[keys[0]];
                if (Array.isArray(first) && first.length) {
                    return String(first[0]);
                }
            }
        }

        return fallback;
    }

    function escapeHtml(value) {
        return String(value || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    window.GroupExtractionClient = {
        init: init,
        startPolling: startPolling,
    };
})(window, window.jQuery);
