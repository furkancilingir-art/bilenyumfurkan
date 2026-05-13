# Bilenyum v2 -> GitHub ilk push (token sadece push sirasinda sorulursa yapistirilir)
$ErrorActionPreference = 'Stop'
Set-Location $PSScriptRoot

Write-Host "Klasor: $PSScriptRoot" -ForegroundColor Cyan

$git = Get-Command git -ErrorAction SilentlyContinue
if (-not $git) {
    Write-Host "HATA: 'git' bulunamadi. Git for Windows kurun: https://git-scm.com/download/win" -ForegroundColor Red
    Write-Host "Kurulumdan sonra bu dosyayi tekrar calistirin." -ForegroundColor Yellow
    Read-Host "Cikmak icin Enter"
    exit 1
}

$gitName = (git config user.name 2>$null).Trim()
$gitEmail = (git config user.email 2>$null).Trim()
if (-not $gitName -or -not $gitEmail) {
    Write-Host ""
    Write-Host "HATA: Git commit icin ad ve e-posta ayarli degil." -ForegroundColor Red
    Write-Host "PowerShell veya Git Bash'te bir kez calistirin (kendi bilgilerinizle):" -ForegroundColor Yellow
    Write-Host '  git config --global user.name "Ad Soyad"' -ForegroundColor White
    Write-Host '  git config --global user.email "github-hesabiniz@ornek.com"' -ForegroundColor White
    Write-Host ""
    Write-Host "Sonra git-ilk-push.bat dosyasini tekrar calistirin." -ForegroundColor Cyan
    Read-Host "Cikmak icin Enter"
    exit 1
}

$origin = 'https://github.com/furkancilingir-art/bilenyumfurkan.git'

if (-not (Test-Path '.git')) {
    git init
} else {
    Write-Host ".git zaten var, init atlandi." -ForegroundColor DarkGray
}

git branch -M main 2>$null

git add -A
$st = git status --porcelain
if (-not $st) {
    Write-Host "Yeni commit edilecek dosya yok (zaten commitli olabilir)." -ForegroundColor Yellow
} else {
    git commit -m "Initial commit: Bilenyum v2 + Vercel PHP router"
    if ($LASTEXITCODE -ne 0) {
        Write-Host "Commit basarisiz (yukaridaki mesaja bakin)." -ForegroundColor Red
        Read-Host "Cikmak icin Enter"
        exit 1
    }
}

$remotes = @(git remote 2>$null)
if ($remotes -contains 'origin') {
    git remote set-url origin $origin
} else {
    git remote add origin $origin
}
Write-Host "Remote: $origin" -ForegroundColor Green

Write-Host ""
Write-Host "Simdi GitHub kimligi istenebilir." -ForegroundColor Cyan
Write-Host "- Kullanici: GitHub kullanici adin" -ForegroundColor White
Write-Host "- Sifre: GitHub sifren DEGIL, Personal Access Token" -ForegroundColor White
Write-Host ""

git push -u origin main

if ($LASTEXITCODE -ne 0) {
    Write-Host ""
    Write-Host "Push basarisiz. Token / repo erisimini kontrol edin." -ForegroundColor Red
} else {
    Write-Host ""
    Write-Host "Tamam. Sonra Vercel'de repoyu Import edin (Root: .)." -ForegroundColor Green
}

Read-Host "`nCikmak icin Enter"
