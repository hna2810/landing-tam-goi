# ==============================================================================
# Fast Theme Deployment via WordPress REST API & Admin Application Password
# ==============================================================================

$themeDir = $PSScriptRoot
$siteUrl  = "https://tamgoigungnghe.homecarevietnam.com"
$user     = "admin"
$pass     = "k5CK Dxxv Q9Zx StNU 9VDt 93XK"
$pair     = "${user}:${pass}"
$bytes    = [System.Text.Encoding]::ASCII.GetBytes($pair)
$base64   = [System.Convert]::ToBase64String($bytes)
$headers  = @{
    Authorization = "Basic $base64"
}

Write-Host "Creating lightweight theme package..." -ForegroundColor Cyan
$zipPath = "$env:TEMP\landing-tam-goi-deploy.zip"
if (Test-Path $zipPath) { Remove-Item $zipPath -Force }

# Gather files excluding git and temporary files
$files = Get-ChildItem -Path $themeDir -Recurse -File | Where-Object {
    $_.FullName -notmatch '\\\.git(\\|$)' -and
    $_.FullName -notmatch '\\node_modules(\\|$)' -and
    $_.Extension -ne '.zip'
}

# Compress into zip
Add-Type -AssemblyName System.IO.Compression.FileSystem
$zip = [System.IO.Compression.ZipFile]::Open($zipPath, [System.IO.Compression.ZipArchiveMode]::Create)
foreach ($file in $files) {
    $relPath = $file.FullName.Substring($themeDir.Length + 1).Replace('\', '/')
    [System.IO.Compression.ZipFileExtensions]::CreateEntryFromFile($zip, $file.FullName, $relPath)
}
$zip.Dispose()

$zipSize = (Get-Item $zipPath).Length
Write-Host "Package ready ($([Math]::Round($zipSize/1024, 1)) KB). Deploying to $siteUrl..." -ForegroundColor Cyan

$zipBytes = [System.IO.File]::ReadAllBytes($zipPath)
$headers["Content-Type"] = "application/zip"

try {
    $res = Invoke-RestMethod -Uri "$siteUrl/wp-json/lx-deploy/v1/sync" -Method Post -Headers $headers -Body $zipBytes -TimeoutSec 60
    Write-Host "Deployment SUCCESS: $($res.message)" -ForegroundColor Green
    Write-Host "Time: $($res.time_ms) ms | Version: $($res.theme_version)" -ForegroundColor Green
} catch {
    Write-Host "Deploy Error: $($_.Exception.Message)" -ForegroundColor Red
} finally {
    if (Test-Path $zipPath) { Remove-Item $zipPath -Force }
}
