$ErrorActionPreference = "Stop"
$SourceZip = "C:\Users\Admin\Desktop\whatsapp_crm.tar.gz"
$DestDir = "C:\Users\Admin\Desktop\whatsapp_crm_source"
$RepoUrl = "https://github.com/jerryboganda/whatsappsystem"

if (!(Test-Path $SourceZip)) { Write-Error "Archive not found!"; exit 1 }
if (!(Test-Path $DestDir)) { New-Item -ItemType Directory -Path $DestDir | Out-Null }

Write-Host "Extracting archive..."
# tar is available as bsdtar on Windows 10+
tar -xzf $SourceZip -C $DestDir

Set-Location $DestDir

Write-Host "Initializing Git..."
git init
git config user.name "Migration Assistant"
git config user.email "migration@example.com"
try { git remote remove origin 2>&1 | Out-Null } catch {} 
git remote add origin $RepoUrl
git add .
git commit -m "Initial commit from VPS migration"

Write-Host "Pushing to GitHub..."
git push -u origin master

Write-Host "Done!"
