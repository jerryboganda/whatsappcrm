$ErrorActionPreference = "Stop"
Set-Location "C:\Users\Admin\Desktop\whatsapp_crm_source"

Write-Host "Unstaging sensitive files..."
# Undo the last commit but keep changes
git reset --soft HEAD~1

# Unstage .env
git reset HEAD .env

# Add to gitignore
Add-Content -Path .gitignore -Value "`n.env"

# Add gitignore and commit
git add .gitignore
git commit -m "Initial commit (excluded sensitive .env)"

Write-Host "Pushing to GitHub..."
git push -u origin master
