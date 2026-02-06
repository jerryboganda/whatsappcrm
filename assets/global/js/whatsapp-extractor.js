/**
 * WhatsApp Group Contact Extractor
 * Run this on WhatsApp Web while viewing a group's info panel.
 */
(function() {
    // Create visual feedback overlay
    var overlay = document.createElement('div');
    overlay.id = 'wa-extractor-overlay';
    overlay.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.7);z-index:99999;display:flex;align-items:center;justify-content:center;flex-direction:column;font-family:sans-serif;';
    
    var statusBox = document.createElement('div');
    statusBox.style.cssText = 'background:#25D366;color:white;padding:30px 50px;border-radius:15px;text-align:center;box-shadow:0 10px 40px rgba(0,0,0,0.3);';
    statusBox.innerHTML = '<div style="font-size:48px;margin-bottom:15px;">📱</div><div id="wa-status" style="font-size:20px;font-weight:bold;">Initializing...</div><div id="wa-count" style="font-size:14px;margin-top:10px;opacity:0.8;"></div>';
    
    overlay.appendChild(statusBox);
    document.body.appendChild(overlay);
    
    var statusEl = document.getElementById('wa-status');
    var countEl = document.getElementById('wa-count');
    
    function updateStatus(msg, count) {
        statusEl.innerText = msg;
        if (count !== undefined) countEl.innerText = count + ' contacts found';
    }
    
    function finish(contacts, success) {
        if (success) {
            statusBox.style.background = '#34B7F1';
            statusBox.innerHTML = '<div style="font-size:48px;margin-bottom:15px;">✅</div><div style="font-size:24px;font-weight:bold;">Copied ' + contacts.length + ' Contacts!</div><div style="font-size:14px;margin-top:15px;opacity:0.9;">Now go back to Your CRM and click<br><b>"Paste from Clipboard"</b></div>';
        } else {
            statusBox.style.background = '#E53935';
            statusBox.innerHTML = '<div style="font-size:48px;margin-bottom:15px;">❌</div><div style="font-size:20px;font-weight:bold;">Failed</div><div style="font-size:14px;margin-top:10px;">Please open a Group\'s Info panel first.<br>Click the group name at the top.</div>';
        }
        setTimeout(function() { overlay.remove(); }, 4000);
    }
    
    // Find the participant list container
    var list = document.querySelector('[data-testid="group-info-participants-section"]') 
            || document.querySelector('div[aria-label*="articipant"]')
            || document.querySelector('div[data-testid="cell-frame-container"]')?.closest('div[tabindex="0"]');
    
    // Fallback: Find any scrollable container inside group info
    if (!list) {
        var infoPanels = document.querySelectorAll('div[class*="copyable-area"]');
        infoPanels.forEach(function(p) {
            if (p.innerText.includes('participant') || p.innerText.includes('member')) {
                list = p.querySelector('div[style*="overflow"]') || p;
            }
        });
    }
    
    if (!list) {
        finish([], false);
        return;
    }
    
    updateStatus('Scrolling through members...', 0);
    
    // Auto-scroll to load all participants
    var lastHeight = 0;
    var scrollAttempts = 0;
    var maxAttempts = 50;
    
    var scrollInterval = setInterval(function() {
        list.scrollTop += 500;
        scrollAttempts++;
        
        if (list.scrollTop === lastHeight || scrollAttempts >= maxAttempts) {
            clearInterval(scrollInterval);
            extractContacts();
        }
        lastHeight = list.scrollTop;
    }, 150);
    
    function extractContacts() {
        updateStatus('Extracting contacts...');
        
        var contacts = [];
        var seen = {};
        
        // Method 1: Find phone number patterns in span elements
        var spans = document.querySelectorAll('span[title], span[dir="auto"]');
        spans.forEach(function(el) {
            var text = el.innerText || el.title || '';
            // Match phone numbers (with or without +)
            var phoneMatch = text.match(/^\+?[\d\s\-\(\)]{8,20}$/);
            if (phoneMatch) {
                var clean = text.replace(/[\s\-\(\)]/g, '');
                if (clean.length >= 8 && clean.length <= 16 && !seen[clean]) {
                    seen[clean] = true;
                    contacts.push(clean);
                }
            }
        });
        
        // Method 2: Regex scan on the panel text
        if (contacts.length < 3) {
            var rawText = list.innerText || '';
            var matches = rawText.match(/\+?\d[\d\s\-]{7,18}\d/g) || [];
            matches.forEach(function(m) {
                var clean = m.replace(/[\s\-]/g, '');
                if (clean.length >= 9 && clean.length <= 16 && !seen[clean]) {
                    seen[clean] = true;
                    contacts.push(clean);
                }
            });
        }
        
        if (contacts.length === 0) {
            finish([], false);
            return;
        }
        
        // Copy to clipboard
        var result = contacts.join('|');
        navigator.clipboard.writeText(result).then(function() {
            finish(contacts, true);
        }).catch(function() {
            // Fallback for older browsers
            var ta = document.createElement('textarea');
            ta.value = result;
            document.body.appendChild(ta);
            ta.select();
            document.execCommand('copy');
            ta.remove();
            finish(contacts, true);
        });
    }
})();
