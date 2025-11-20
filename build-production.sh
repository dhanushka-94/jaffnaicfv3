#!/bin/bash

# Production Build Script for JAFFNA ICF
# Run this script to prepare the application for production deployment

echo "🚀 Starting production build..."

# Build assets
echo "📦 Building assets..."
npm run build

# Optimize Composer autoloader
echo "⚙️  Optimizing Composer autoloader..."
composer dump-autoload --optimize

# Cache Laravel configuration
echo "💾 Caching Laravel configuration..."
php artisan config:cache

# Cache routes
echo "🛣️  Caching routes..."
php artisan route:cache

# Cache views
echo "👁️  Caching views..."
php artisan view:cache

# Cache events
echo "🎯 Caching events..."
php artisan event:cache

echo "✅ Production build completed successfully!"
echo ""
echo "📋 Next steps:"
echo "1. Update .env file with production settings"
echo "2. Run migrations: php artisan migrate --force"
echo "3. Create storage link: php artisan storage:link"
echo "4. Set proper file permissions on storage and bootstrap/cache"
echo ""
echo "See DEPLOYMENT.md for detailed deployment instructions."

