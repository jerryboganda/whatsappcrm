const { chromium } = require('playwright');

(async () => {
    const browser = await chromium.launch({ headless: false });
    const context = await browser.newContext();
    const page = await context.newPage();

    const baseUrl = 'http://127.0.0.1:8000';
    const results = [];

    const log = (feature, status, details = '') => {
        results.push({ feature, status, details });
        console.log(`[${status}] ${feature}: ${details}`);
    };

    try {
        // --- 1. Login ---
        console.log('\n========== 1. TESTING LOGIN ==========\n');
        await page.goto(`${baseUrl}/login`);
        await page.waitForLoadState('networkidle');
        await page.screenshot({ path: 'screenshots/01_login_page.png' });

        // Try to login - adjust credentials as needed
        await page.fill('input[name="username"]', 'demo');
        await page.fill('input[name="password"]', 'demo1234');
        await page.click('button[type="submit"]');
        await page.waitForLoadState('networkidle');
        await page.screenshot({ path: 'screenshots/02_after_login.png' });

        const currentUrl = page.url();
        if (currentUrl.includes('dashboard') || currentUrl.includes('home')) {
            log('Login', 'PASS', 'Successfully logged in');
        } else {
            log('Login', 'FAIL', `Redirected to: ${currentUrl}`);
        }

        // --- 2. Check Sidebar Navigation ---
        console.log('\n========== 2. TESTING SIDEBAR NAVIGATION ==========\n');

        // Orders Link
        const ordersLink = await page.$('a:has-text("Orders")');
        if (ordersLink) {
            log('Sidebar - Orders Link', 'PASS', 'Link found');
        } else {
            log('Sidebar - Orders Link', 'FAIL', 'Link NOT found');
        }

        // Payment Config Link
        const paymentConfigLink = await page.$('a:has-text("Payment Config")');
        if (paymentConfigLink) {
            log('Sidebar - Payment Config Link', 'PASS', 'Link found');
        } else {
            log('Sidebar - Payment Config Link', 'FAIL', 'Link NOT found');
        }

        // Dialogflow Link
        const dialogflowLink = await page.$('a:has-text("Dialogflow")');
        if (dialogflowLink) {
            log('Sidebar - Dialogflow Link', 'PASS', 'Link found');
        } else {
            log('Sidebar - Dialogflow Link', 'FAIL', 'Link NOT found');
        }

        // Meta Ads Link
        const metaAdsLink = await page.$('a:has-text("Meta Ads")');
        if (metaAdsLink) {
            log('Sidebar - Meta Ads Link', 'PASS', 'Link found');
        } else {
            log('Sidebar - Meta Ads Link', 'FAIL', 'Link NOT found');
        }

        await page.screenshot({ path: 'screenshots/03_sidebar.png' });

        // --- 3. Test Orders Page ---
        console.log('\n========== 3. TESTING ORDERS PAGE ==========\n');
        await page.goto(`${baseUrl}/user/orders`);
        await page.waitForLoadState('networkidle');
        await page.screenshot({ path: 'screenshots/04_orders_page.png' });

        const ordersTable = await page.$('table');
        if (ordersTable) {
            log('Orders Page - Table', 'PASS', 'Orders table found');
        } else {
            log('Orders Page - Table', 'FAIL', 'Orders table NOT found');
        }

        const searchInput = await page.$('input[name="search"]');
        if (searchInput) {
            log('Orders Page - Search', 'PASS', 'Search input found');
        } else {
            log('Orders Page - Search', 'FAIL', 'Search input NOT found');
        }

        const statusFilter = await page.$('select[name="status"]');
        if (statusFilter) {
            log('Orders Page - Status Filter', 'PASS', 'Status filter found');
        } else {
            log('Orders Page - Status Filter', 'FAIL', 'Status filter NOT found');
        }

        // --- 4. Test Payment Config Page ---
        console.log('\n========== 4. TESTING PAYMENT CONFIG PAGE ==========\n');
        await page.goto(`${baseUrl}/user/payment/config`);
        await page.waitForLoadState('networkidle');
        await page.screenshot({ path: 'screenshots/05_payment_config.png' });

        const stripeSection = await page.$('text=Stripe');
        if (stripeSection) {
            log('Payment Config - Stripe Section', 'PASS', 'Section found');
        } else {
            log('Payment Config - Stripe Section', 'FAIL', 'Section NOT found');
        }

        const razorpaySection = await page.$('text=Razorpay');
        if (razorpaySection) {
            log('Payment Config - Razorpay Section', 'PASS', 'Section found');
        } else {
            log('Payment Config - Razorpay Section', 'FAIL', 'Section NOT found');
        }

        // --- 5. Test Inbox Page (Payment Button) ---
        console.log('\n========== 5. TESTING INBOX PAGE ==========\n');
        await page.goto(`${baseUrl}/user/inbox`);
        await page.waitForLoadState('networkidle');
        await page.screenshot({ path: 'screenshots/06_inbox_page.png' });

        const paymentBtn = await page.$('.payment-modal-btn');
        if (paymentBtn) {
            log('Inbox - Request Payment Button', 'PASS', 'Button found');
        } else {
            log('Inbox - Request Payment Button', 'FAIL', 'Button NOT found');
        }

        // --- 6. Test Dialogflow Page ---
        console.log('\n========== 6. TESTING DIALOGFLOW PAGE ==========\n');
        await page.goto(`${baseUrl}/user/dialogflow`);
        await page.waitForLoadState('networkidle');
        await page.screenshot({ path: 'screenshots/07_dialogflow_page.png' });

        const dialogflowForm = await page.$('form');
        if (dialogflowForm) {
            log('Dialogflow Page', 'PASS', 'Form found');
        } else {
            log('Dialogflow Page', 'FAIL', 'Form NOT found');
        }

        // --- 7. Test Meta Ads Page ---
        console.log('\n========== 7. TESTING META ADS PAGE ==========\n');
        await page.goto(`${baseUrl}/user/ads`);
        await page.waitForLoadState('networkidle');
        await page.screenshot({ path: 'screenshots/08_meta_ads_page.png' });

        const adsContent = await page.$('.dashboard-container');
        if (adsContent) {
            log('Meta Ads Page', 'PASS', 'Dashboard content found');
        } else {
            log('Meta Ads Page', 'FAIL', 'Dashboard content NOT found');
        }

        // --- 8. Test WhatsApp Account Settings (Commerce Toggle) ---
        console.log('\n========== 8. TESTING WHATSAPP ACCOUNT SETTINGS ==========\n');
        // First, we need to find a WhatsApp account ID
        await page.goto(`${baseUrl}/user/whatsapp-account`);
        await page.waitForLoadState('networkidle');
        await page.screenshot({ path: 'screenshots/09_whatsapp_accounts.png' });

        const settingLink = await page.$('a:has-text("Setting")');
        if (settingLink) {
            await settingLink.click();
            await page.waitForLoadState('networkidle');
            await page.screenshot({ path: 'screenshots/10_whatsapp_account_settings.png' });

            const cartToggle = await page.$('input[name="is_cart_enabled"]');
            if (cartToggle) {
                log('WhatsApp Settings - Cart Toggle', 'PASS', 'Toggle found');
            } else {
                log('WhatsApp Settings - Cart Toggle', 'FAIL', 'Toggle NOT found');
            }

            const catalogToggle = await page.$('input[name="is_catalog_visible"]');
            if (catalogToggle) {
                log('WhatsApp Settings - Catalog Toggle', 'PASS', 'Toggle found');
            } else {
                log('WhatsApp Settings - Catalog Toggle', 'FAIL', 'Toggle NOT found');
            }
        } else {
            log('WhatsApp Settings', 'SKIP', 'No WhatsApp accounts to test');
        }

        // --- Summary ---
        console.log('\n\n========== TEST SUMMARY ==========\n');
        const passed = results.filter(r => r.status === 'PASS').length;
        const failed = results.filter(r => r.status === 'FAIL').length;
        const skipped = results.filter(r => r.status === 'SKIP').length;

        console.log(`PASSED: ${passed}`);
        console.log(`FAILED: ${failed}`);
        console.log(`SKIPPED: ${skipped}`);
        console.log(`TOTAL: ${results.length}`);

        results.forEach(r => {
            console.log(`  [${r.status}] ${r.feature}: ${r.details}`);
        });

    } catch (error) {
        console.error('Test Error:', error.message);
        await page.screenshot({ path: 'screenshots/error.png' });
    } finally {
        await browser.close();
    }
})();
