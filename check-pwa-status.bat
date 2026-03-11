@echo off
REM PWA Update Check Script for Windows
REM Run this to check PWA service worker status

echo.
echo Checking PWA Service Worker Status...
echo.

echo Checking PWA Files:

set "files[0]=manifest.json"
set "files[1]=service-worker.js"
set "files[2]=offline.html"
set "files[3]=pwa-client.js"

for %%F in (manifest.json service-worker.js offline.html pwa-client.js) do (
  if exist "%%F" (
    for %%A in (%%F) do set "size=%%~zA"
    echo   # %%F [!size! bytes]
  ) else (
    echo   X %%F - NOT FOUND
  )
)

echo.
echo Checking manifest.json validity...

if exist "manifest.json" (
  echo   # manifest.json exists
  echo   - Check the file in a JSON validator
  echo   - URL: https://jsonlint.com/
) else (
  echo   X manifest.json not found
)

echo.
echo PWA Status Check Complete!
echo.
echo Your app should be accessible at:
echo http://localhost:3000
echo.
pause
