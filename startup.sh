#!/bin/bash

echo "🚀 TechBuy Azure Startup"
echo "======================="

# Set proper permissions
chmod -R 755 /home/site/wwwroot
cd /home/site/wwwroot

# Setup databases first
echo "🗄️  Setting up databases..."
./azure-db-setup.sh

# Clear any cache issues
php artisan config:clear 2>/dev/null || echo "Config clear skipped"
php artisan cache:clear 2>/dev/null || echo "Cache clear skipped"
php artisan view:clear 2>/dev/null || echo "View clear skipped"
php artisan route:clear 2>/dev/null || echo "Route clear skipped"

# Optimize for production
if [ "$APP_ENV" = "production" ]; then
    echo "⚡ Production optimizations..."
    php artisan config:cache 2>/dev/null || echo "Config cache skipped"
    php artisan route:cache 2>/dev/null || echo "Route cache skipped"
    php artisan view:cache 2>/dev/null || echo "View cache skipped"
fi

echo "✅ TechBuy startup complete"
