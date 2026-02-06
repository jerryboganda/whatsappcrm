document.getElementById('extractBtn').addEventListener('click', async () => {
    const statusEl = document.getElementById('status');
    const btn = document.getElementById('extractBtn');

    statusEl.innerHTML = '⏳ Starting extraction...';
    btn.disabled = true;

    try {
        const [tab] = await chrome.tabs.query({ active: true, currentWindow: true });

        if (!tab.url.includes('web.whatsapp.com')) {
            statusEl.textContent = '❌ Please open web.whatsapp.com first!';
            btn.disabled = false;
            return;
        }

        const results = await chrome.scripting.executeScript({
            target: { tabId: tab.id },
            func: extractContacts
        });

        const data = results[0].result;

        if (data.success) {
            await navigator.clipboard.writeText(data.contacts);
            statusEl.innerHTML = `✅ <strong>${data.count} contacts</strong> copied!<br><small>Now paste in your CRM.</small>`;
        } else {
            statusEl.innerHTML = `❌ ${data.error}`;
        }
    } catch (err) {
        statusEl.textContent = '❌ Error: ' + err.message;
        console.error(err);
    }

    btn.disabled = false;
});

function extractContacts() {
    return new Promise((resolve) => {
        const wait = (ms) => new Promise(r => setTimeout(r, ms));

        async function run() {
            const contacts = new Set();

            // STEP 1: Find the RIGHT panel (Group Info) - NOT the left chat list
            // The right panel is typically the second/third pane, or a modal
            const rightPanel = document.querySelector('[data-testid="conversation-info-header"]')?.closest('div[class*="panel"]')
                || document.querySelector('header span[title]')?.closest('div')?.parentElement
                || document.querySelector('[data-testid="group-info-drawer"]');

            // STEP 2: Click "View all (X more)" ONLY within the right panel area
            let viewAllClicked = false;
            let participantsModal = null;

            // Find "View all" specifically in the right side of the screen
            const allElements = document.querySelectorAll('span, div');
            for (const el of allElements) {
                const text = (el.innerText || '').trim();
                if (text.match(/^View all \(\d+ more\)$/i)) {
                    // Make sure this is NOT in the left chat panel
                    const rect = el.getBoundingClientRect();
                    if (rect.left > window.innerWidth * 0.3) { // Must be in right 70% of screen
                        el.click();
                        viewAllClicked = true;
                        break;
                    }
                }
            }

            if (viewAllClicked) {
                await wait(2500);
            }

            // STEP 3: Find the participants modal/container
            // After clicking "View all", a modal should appear
            participantsModal = document.querySelector('[data-testid="popup-contents"]')
                || document.querySelector('[role="dialog"]')
                || document.querySelector('div[data-animate-modal-body="true"]');

            // If no modal, try to find the scrollable list in the right panel
            if (!participantsModal) {
                // Find scrollable divs that are on the RIGHT side of the screen (x > 50%)
                const scrollableDivs = document.querySelectorAll('div');
                for (const div of scrollableDivs) {
                    const style = window.getComputedStyle(div);
                    const rect = div.getBoundingClientRect();
                    const hasScroll = style.overflowY === 'auto' || style.overflowY === 'scroll';
                    const isRightSide = rect.left > window.innerWidth * 0.4;
                    const isLarge = div.scrollHeight > 400;

                    if (hasScroll && isRightSide && isLarge) {
                        participantsModal = div;
                        break;
                    }
                }
            }

            if (!participantsModal) {
                resolve({
                    success: false,
                    error: 'Could not find the group participants panel.\n\n1. Open a group chat\n2. Click the group name at top\n3. Click "View all (X more)"\n4. Then extract'
                });
                return;
            }

            // STEP 4: Scroll ONLY the participants container
            let lastTop = -1;
            let attempts = 0;

            // First pass: scroll down
            while (participantsModal.scrollTop !== lastTop && attempts < 500) {
                lastTop = participantsModal.scrollTop;
                participantsModal.scrollTop += 500;
                await wait(30);
                attempts++;

                // Extract ONLY from this container while scrolling
                extractFromContainer(participantsModal, contacts);
            }

            // Second pass: scroll to top and back down
            participantsModal.scrollTop = 0;
            await wait(200);

            lastTop = -1;
            attempts = 0;
            while (participantsModal.scrollTop !== lastTop && attempts < 500) {
                lastTop = participantsModal.scrollTop;
                participantsModal.scrollTop += 300;
                await wait(40);
                attempts++;

                extractFromContainer(participantsModal, contacts);
            }

            // Final extraction pass
            extractFromContainer(participantsModal, contacts);

            const contactArray = Array.from(contacts);

            if (contactArray.length === 0) {
                resolve({ success: false, error: 'No phone numbers found in the participants list.' });
                return;
            }

            resolve({
                success: true,
                contacts: contactArray.join('|'),
                count: contactArray.length
            });
        }

        // Extract ONLY from the specified container, not the whole document
        function extractFromContainer(container, contacts) {
            if (!container) return;

            // Method 1: Find phone patterns in text content
            container.querySelectorAll('span, div').forEach(el => {
                const text = (el.innerText || el.textContent || '').trim();
                if (/^\+\d{1,4}[\s\d\-]{6,16}$/.test(text)) {
                    const clean = text.replace(/[\s\-]/g, '');
                    if (clean.length >= 10 && clean.length <= 16) {
                        contacts.add(clean);
                    }
                }
            });

            // Method 2: Title attributes within container
            container.querySelectorAll('[title]').forEach(el => {
                const title = el.getAttribute('title') || '';
                if (/^\+\d{1,4}[\s\d\-]{6,16}$/.test(title)) {
                    const clean = title.replace(/[\s\-]/g, '');
                    if (clean.length >= 10 && clean.length <= 16) {
                        contacts.add(clean);
                    }
                }
            });

            // Method 3: Aria-labels within container
            container.querySelectorAll('[aria-label]').forEach(el => {
                const label = el.getAttribute('aria-label') || '';
                const matches = label.match(/\+\d{1,4}[\s\d\-]{6,16}/g) || [];
                matches.forEach(m => {
                    const clean = m.replace(/[\s\-]/g, '');
                    if (clean.length >= 10 && clean.length <= 16) {
                        contacts.add(clean);
                    }
                });
            });

            // Method 4: Raw text regex on container only
            const rawText = container.innerText || '';
            const phoneMatches = rawText.match(/\+\d{1,4}[\s\d]{8,15}/g) || [];
            phoneMatches.forEach(m => {
                const clean = m.replace(/\s/g, '');
                if (clean.length >= 10 && clean.length <= 16) {
                    contacts.add(clean);
                }
            });
        }

        run();
    });
}
