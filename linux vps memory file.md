# Linux VPS Memory File

## Connection Information

- **IP Address:** `185.252.233.186`
- **User:** `root`
- **SSH Key:** `~/.ssh/id_rsa_new` (Passwordless set up)

## System Overview

- **OS:** Ubuntu 24.04.3 LTS (Noble Numbat)
- **Kernel:** 6.8.0-90-generic
- **Docker Engine:** 29.1.5
- **Main Entry Point:** Nginx Proxy Manager (Docker container)

## Exposed Ports & Services

| Port | Service | Description |
| :--- | :--- | :--- |
| 80 | HTTP | Managed by Nginx Proxy Manager |
| 443 | HTTPS | Managed by Nginx Proxy Manager |
| 81 | NPM Admin | Nginx Proxy Manager Web UI |
| 8000/9443 | Portainer | Docker Management UI |
| 22 | SSH | Default System SSH |
| 2222 | SSH/Other | MainThread service |

### Internal Local-Mapped Ports

- `8086`: Marriage Bureau Web
- `8085`: StreamVault Web
- `8083`: Polytronx WordPress
- `8082`: Amad Diagnostic Portal (Laravel)
- `8081`: Aims Academy WordPress
- `8080`: Amad Diagnostic Centre WordPress
- `9000`: Ovo WPP Web

## Project Locations (CWDs)

- **MarriageBureau:** `/root/doctormarriagebureau`
- **Nginx Proxy Manager:** `/opt/docker/nginx-proxy-manager`
- **Ovo WPP:** `/var/www/ovo-wpp`
- **Soketi:** `/root/soketi`
- **Polytronx:** `/root/polytronx`
- **Aims Academy:** `/root/aimsacademy`
- **Amad Diagnostic (WP):** `/opt/docker/wordpress/amaddiagnosticcentre`
- **Amad Diagnostic Portal (Laravel):** `/root/laravel-app`
- **Remnanode:** `/opt/remnanode`

## Running Docker Container Groups

1. **MarriageBureau:** `marriagebureau-web`, `marriagebureau-app`, `marriagebureau-db`
2. **Ovo WPP:** `ovo-wpp-web`, `ovo-wpp-app`, `ovo-wpp-db`
3. **StreamVault:** `streamvault-web`, `streamvault-app`, `streamvault-db`
4. **Soketi:** `soketi`, `soketi-redis`
5. **Nginx Proxy Manager:** `nginx-proxy-manager-app-1`
6. **Portainer:** `portainer`
7. **Amad Diagnostic Portal:** `laravel-app-app-1`, `laravel-app-db-1`
8. **WordPress Sites:** Multiple MariaDB/WordPress instances.

## Recent Changes (2026-02-04)

- **500 Error Fix:** Resolved a division-by-zero Internal Server Error on the campaign report page by adding defensive checks to `CampaignController.php`.
- **Security Cleanup:** Identified and removed `systemd-bench` crypto miner hidden in `/root/.system-cache/`.
- **Crontab Cleanup:** Removed rogue miner auto-restart entries from the system crontab.
- **Cron Restoration:** Added persistent Laravel cron job: `* * * * * curl -s http://localhost:9000/cron > /dev/null 2>&1`.
- **Campaign Processed:** Successfully manually triggered and verified campaign message delivery after system restoration.

## Previous Changes (2026-02-02)

- Added **Bulk Delete** for contacts (`core/app/Traits/ContactManager.php`, `core/routes/user.php`, `index.blade.php`).
- Fixed **WhatsApp Extractor** logic (`chrome-extension/popup.js`).
