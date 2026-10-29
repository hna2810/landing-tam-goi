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
$packDir = "$env:TEMP\landing-tam-goi-pack"
if (Test-Path $zipPath) { Remove-Item $zipPath -Force }
if (Test-Path $packDir) { Remove-Item $packDir -Recurse -Force }
New-Item -ItemType Directory -Path $packDir | Out-Null

Copy-Item -Path "$themeDir\*" -Destination $packDir -Recurse -Exclude ".git", "*.zip"
Compress-Archive -Path "$packDir\*" -DestinationPath $zipPath -Force
Remove-Item $packDir -Recurse -Force

$zipSize = (Get-Item $zipPath).Length
Write-Host "Package ready ($([Math]::Round($zipSize/1024, 1)) KB). Deploying to $siteUrl..." -ForegroundColor Cyan

$zipBytes = [System.IO.File]::ReadAllBytes($zipPath)
$headers["Content-Type"] = "application/zip"

try {
    $res = Invoke-RestMethod -Uri "$siteUrl/wp-json/lx-deploy/v1/sync" -Method Post -Headers $headers -Body $zipBytes -TimeoutSec 60
    Write-Host "Deployment SUCCESS: $($res.message)" -ForegroundColor Green
    Write-Host "Method: $($res.method) | Time: $($res.time_ms) ms | Version: $($res.theme_version)" -ForegroundColor Green
} catch {
    Write-Host "Deploy Error: $($_.Exception.Message)" -ForegroundColor Red
} finally {
    if (Test-Path $zipPath) { Remove-Item $zipPath -Force }
}
