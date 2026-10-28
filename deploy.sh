#!/bin/bash
# ============================================================
# Deploy ROOTBIO (Laravel 13 + Inertia 3 + Vue 3) len shared hosting cPanel
# ============================================================
# Cach dung:
#   1. Dien thong tin DB/domain vao file .env.production (copy tu .env.example)
#   2. Chay: bash deploy.sh
#   3. Upload rootbio-deploy.zip len hosting (FileZilla / cPanel File Manager)
#   4. Giai nen vao public_html, doi ten .env.production thanh .env
#   5. SSH vao hosting va chay:
#      php artisan migrate --force
#      php artisan optimize
#      chmod -R 775 storage bootstrap/cache
# ============================================================

set -e

ARCHIVE="rootbio-deploy.zip"
ENV_FILE=".env.production"

echo "==> Cleaning previous archive..."
rm -f "$ARCHIVE"

echo "==> Building frontend assets..."
npm install --no-audit --no-fund
npm run build

echo "==> Installing PHP dependencies (production only)..."
composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-progress

echo "==> Clearing caches..."
php artisan optimize:clear || true

if [ ! -f "$ENV_FILE" ]; then
    echo "!! Khong tim thay $ENV_FILE."
    echo "   Hay tao file .env.production (copy tu .env.example) va dien thong tin DB + domain truoc khi deploy."
    exit 1
fi

echo "==> Creating archive..."
zip -r "$ARCHIVE" \
    app bootstrap config database/seeders database/migrations public resources routes storage \
    artisan composer.json composer.lock package.json package-lock.json vite.config.ts tsconfig.json \
    index.php .htaccess \
    -x "node_modules/*" "vendor/*" \
       "storage/framework/views/*" "storage/framework/cache/*" "storage/framework/sessions/*" \
       "storage/logs/*" "storage/app/private/*" \
       "database/database.sqlite" "*.map" ".env" ".env.*"

cp "$ENV_FILE" ".env.deploy"

echo "==> Adding .env to archive..."
zip "$ARCHIVE" ".env.deploy"

echo ""
echo "==> HOAN TAT!"
echo "   File: $ARCHIVE"
echo "   1. Upload $ARCHIVE len hosting"
echo "   2. Giai nen vao public_html"
echo "   3. Doi ten .env.deploy thanh .env"
echo "   4. SSH: php artisan migrate --force"
echo "   5. SSH: php artisan optimize"
echo "   6. SSH: chmod -R 775 storage bootstrap/cache"
