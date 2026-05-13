@echo off
chcp 65001 >nul
cd /d "%~dp0"
echo Bilenyum v2 - GitHub ilk push
echo.
powershell -NoProfile -ExecutionPolicy Bypass -File "%~dp0git-ilk-push.ps1"
pause
