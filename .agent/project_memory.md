# Project Memory - WhatsApp CRM

## VPS Connection

- IP: 185.252.233.186
- User: root
- SSH key: C:/Users/Admin/.ssh/id_rsa_new (passwordless)
- OS: Ubuntu 24.04.3 LTS (Kernel 6.8.0-90-generic)
- Docker Engine: 29.1.5

## Services / Containers

- Nginx Proxy Manager: /opt/docker/nginx-proxy-manager (ports 80/443/81)
- Portainer: 8000/9443
- Ovo WPP app: /var/www/ovo-wpp (containers: ovo-wpp-web, ovo-wpp-app, ovo-wpp-db)

## Campaign Cron Adjustments

- Cron schedule set to 120 seconds (Every 2 Minutes) in `cron_schedules` (id=1).
- `cron_jobs` record for alias `campaign_message` uses `cron_schedule_id=1`.
- Campaign processing updated to run without fixed 40 limit (chunkById 200).

## Root Cause for Campaign Failures

- WhatsApp Graph API error: (#133010) Account not registered.
- All sends rejected from `CronController::campaignMessage()` due to WhatsApp account not registered.
- Resolution requires re-register/reconnect WhatsApp Business account / phone number ID in Meta.

## Retarget Route + Fixes

- Missing route fixed earlier: `user.campaign.retarget`.
- Retarget internal error (missing column `status` in `contact_lists`) fixed by removing the `status` write.
- Retarget list name length issue fixed by truncating list name to 40 chars.

## Key Code Changes

- `core/app/Http/Controllers/CronController.php`
  - Campaign cron processing runs in chunks and logs failures.
- `core/app/Http/Controllers/User/CampaignController.php`
  - Removed `ContactList->status` assignment.
  - Truncate retarget list name to 40 chars to satisfy `contact_lists.name` varchar(40).

## Database Notes

- `contact_lists.name` is varchar(40); no `status` column.
- Campaign 1 was reset once: all `campaign_contacts` set to status 0 and campaign totals reset.

## Other Notes

- Laravel caches cleared after deploys: `php artisan config:clear` and `php artisan cache:clear`.
- Retarget UI error screenshot reported: SQLSTATE[22001] due to long `contact_lists.name`.
