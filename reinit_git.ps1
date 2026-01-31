$ErrorActionPreference = "Stop"
Set-Location "C:\Users\Admin\Desktop\whatsapp_crm_source"

Write-Host "Cleaning up old git..."
if (Test-Path .git) { Remove-Item -Path .git -Recurse -Force }

Write-Host "Initializing clean Git..."
git init
git config user.name "Migration Assistant"
git config user.email "migration@example.com"

# Exclude .env immediately
if (!(Test-Path .gitignore)) { New-Item .gitignore -Type File }
if (!(Select-String -Path .gitignore -Pattern "\.env")) { Add-Content .gitignore "`n.env" }

git add .
git commit -m "Initial commit from VPS migration (Clean)"

git remote add origin "https://github.com/jerryboganda/whatsappsystem"

# Upload Large File configuration (Precaution)
git config http.postBuffer 524288000

Write-Host "Pushing..."
git push -u origin master --force
