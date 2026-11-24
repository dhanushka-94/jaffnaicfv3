#!/bin/bash
# Production build for Jaffna ICF.
# Run on your build machine (or on the server) before / after uploading a release.

set -e

echo "Installing PHP dependencies (no dev packages)..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "Building frontend assets..."
npm ci
npm run build

echo "Running database migrations..."
php artisan migrate --force

echo "Linking public storage..."
php artisan storage:link || true

echo "Clearing and rebuilding caches..."
php artisan optimize:clear
php artisan filament:optimize
php artisan optimize          # config + routes + views + events

echo ""
echo "Done. Final checks:"
echo "  1. .env has APP_ENV=production, APP_DEBUG=false, SEO_INDEXABLE=true (live) and a unique APP_KEY"
echo "  2. storage/ and bootstrap/cache/ are writable by the web server user"
echo "  3. https://your-domain/up returns 200, /robots.txt and /sitemap.xml look correct"