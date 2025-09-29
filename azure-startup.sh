#!/bin/bash

# Azure App Service startup script for Laravel
echo "Starting Laravel Azure deployment setup..."

# Set proper permissions for Laravel directories
echo "Setting up Laravel directories and permissions..."

# Create cache directories if they don't exist
mkdir -p /home/site/wwwroot/storage/framework/cache/data
mkdir -p /home/site/wwwroot/storage/framework/sessions
mkdir -p /home/site/wwwroot/storage/framework/views
mkdir -p /home/site/wwwroot/storage/logs
mkdir -p /home/site/wwwroot/bootstrap/cache

# Set proper permissions
chmod -R 775 /home/site/wwwroot/storage
chmod -R 775 /home/site/wwwroot/bootstrap/cache

# Copy environment file if production version exists
if [ -f /home/site/wwwroot/.env.production ]; then
    echo "Copying production environment file..."
    cp /home/site/wwwroot/.env.production /home/site/wwwroot/.env
fi

# Generate application key if not set
echo "Checking application key..."
if grep -q "APP_KEY=$" /home/site/wwwroot/.env || grep -q "APP_KEY=" /home/site/wwwroot/.env | grep -v "APP_KEY=base64:"; then
    echo "Generating new application key..."
    cd /home/site/wwwroot
    php artisan key:generate --force
fi

# Clear and cache Laravel configurations
echo "Optimizing Laravel for production..."
cd /home/site/wwwroot

# Clear all caches first
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Cache configurations for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create symbolic link for storage if it doesn't exist
if [ ! -L "/home/site/wwwroot/public/storage" ]; then
    php artisan storage:link
fi

echo "Laravel setup completed successfully!"

# Start Apache or your web server
# This will be handled by Azure App Service automatically
