#!/bin/bash
# ============================================================
# Deploy ELICPO (Laravel 13 + Inertia 3 + Vue 3) len shared hosting cPanel
# ============================================================
# Cach dung:
#   1. Tao .env.production tu .env.production.example, dien thong tin DB + domain
#   2. Chay: bash deploy.sh
#   3. Upload ELICPO-deploy.zip len hosting, giai nen vao public_html
#   4. Doi ten .env.deploy thanh .env
#   5. SSH: php artisan migrate --force
#   6. SSH: php artisan optimize
#   7. SSH: chmod -R 775 storage bootstrap/cache
# ============================================================

set -e

ENV_FILE=".env.production"

if [ ! -f "$ENV_FILE" ]; then
    echo "!! Khong tim thay $ENV_FILE."
    echo "   Hay tao file .env.production (copy tu .env.production.example) va dien thong tin DB + domain truoc khi deploy."
    exit 1
fi

echo "==> Building frontend assets..."
npm install --no-audit --no-fund
npm run build

echo "==> Installing PHP dependencies (production only)..."
composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-progress

echo "==> Clearing caches..."
php artisan optimize:clear || true

echo "==> Building deploy archive..."
cp "$ENV_FILE" ".env.deploy"
php artisan app:build-deploy-archive

echo ""
echo "==> HOAN TAT!"
echo "   File: ELICPO-deploy.zip"
echo "   1. Upload ELICPO-deploy.zip len hosting"
echo "   2. Giai nen vao public_html"
echo "   3. Doi ten .env.deploy thanh .env"
echo "   4. SSH: php artisan migrate --force"
echo "   5. SSH: php artisan optimize"
echo "   6. SSH: chmod -R 775 storage bootstrap/cache"
