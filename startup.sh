#!/bin/bash

echo "🚀 Azure Startup Script"
echo "====================="

# Set permissions
chmod -R 755 /home/site/wwwroot
chown -R root:root /home/site/wwwroot

# Run Laravel optimizations
cd /home/site/wwwroot

# Cache config for production
php artisan config:cache 2>/dev/null || echo "Config cache skipped"

# Cache routes for production
php artisan route:cache 2>/dev/null || echo "Route cache skipped"

# Cache views for production
php artisan view:cache 2>/dev/null || echo "View cache skipped"

# Migrate database if needed
php artisan migrate --force 2>/dev/null || echo "Migration skipped"

# Seed database if empty
php artisan db:seed --force 2>/dev/null || echo "Seeding skipped"

echo "✅ Laravel application ready"
