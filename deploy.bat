@echo off
REM ============================================================
REM Deploy ROOTBIO (Laravel 13 + Inertia 3 + Vue 3) len shared hosting cPanel
REM ============================================================
REM Cach dung:
REM   1. Tao .env.production tu .env.production.example, dien thong tin DB + domain
REM   2. Chay: deploy.bat
REM   3. Upload rootbio-deploy.zip len hosting, giai nen vao public_html
REM   4. Doi ten .env.deploy thanh .env
REM   5. SSH: php artisan migrate --force
REM   6. SSH: php artisan optimize
REM   7. SSH: chmod -R 775 storage bootstrap/cache
REM ============================================================

setlocal
cd /d "%~dp0"

if not exist ".env.production" (
    echo !! Khong tim thay .env.production
    echo    Hay tao file nay tu .env.production.example va dien thong tin DB + domain truoc khi deploy.
    exit /b 1
)

echo ==^> Building frontend assets...
call npm install --no-audit --no-fund
call npm run build

echo ==^> Installing PHP dependencies (production only)...
call composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-progress

echo ==^> Clearing caches...
call php artisan optimize:clear

echo ==^> Building deploy archive...
copy /Y ".env.production" ".env.deploy" >nul
call php artisan app:build-deploy-archive

echo.
echo ==^> HOAN TAT!
echo    File: rootbio-deploy.zip
echo    1. Upload rootbio-deploy.zip len hosting
echo    2. Giai nen vao public_html
echo    3. Doi ten .env.deploy thanh .env
echo    4. SSH: php artisan migrate --force
echo    5. SSH: php artisan optimize
echo    6. SSH: chmod -R 775 storage bootstrap/cache
endlocal
