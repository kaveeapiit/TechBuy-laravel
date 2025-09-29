#!/bin/bash

# Azure Laravel Root Deployment Script
echo "Setting up Laravel for root deployment..."

cd /home/site/wwwroot

# Copy public assets to root if they don't exist
if [ ! -f "/home/site/wwwroot/favicon.ico" ]; then
    echo "Copying public assets to root..."
    cp public/favicon.ico . 2>/dev/null || true
    cp public/robots.txt . 2>/dev/null || true
    cp -r public/build . 2>/dev/null || true
fi

# Ensure .htaccess is correct for root deployment
cat > .htaccess << 'EOF'
<IfModule mod_rewrite.c>
    RewriteEngine On

    # Handle Laravel routes from root
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php [L,QSA]
</IfModule>

DirectoryIndex index.php
EOF

# Ensure index.php is correct for root deployment
cat > index.php << 'EOF'
<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/bootstrap/app.php';

$app->handleRequest(Request::capture());
EOF

# Set proper permissions
chmod 755 index.php
chmod 644 .htaccess

# Setup Laravel directories and environment
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Copy environment file or create from Azure App Settings
if [ -f ".env.production" ]; then
    cp .env.production .env
else
    echo "Creating .env from Azure App Settings..."
    cat > .env << 'EOF'
APP_NAME=TechBuy
APP_ENV=production
APP_KEY=base64:YMRnZxsVoTJ9EuRI6AnDY/H7euIVWAYbNLa+j8hGoMc=
APP_DEBUG=false
APP_URL=https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net

ASSET_URL=https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net
FORCE_HTTPS=true

LOG_CHANNEL=errorlog
LOG_LEVEL=error

DB_CONNECTION=pgsql
DB_HOST=techbuy-postgres-server.postgres.database.azure.com
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=techbuyadmin
DB_PASSWORD=AmmoEka0102

SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync

SANCTUM_STATEFUL_DOMAINS=techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net

MAIL_MAILER=log
EOF
    echo ".env file created from template"
fi

# Clear and cache Laravel configurations
echo "Clearing Laravel caches..."
php artisan config:clear 2>/dev/null || echo "Config clear failed"
php artisan cache:clear 2>/dev/null || echo "Cache clear failed"
php artisan view:clear 2>/dev/null || echo "View clear failed"
php artisan route:clear 2>/dev/null || echo "Route clear failed"

echo "Caching Laravel configurations..."
php artisan config:cache 2>/dev/null || echo "Config cache failed"
php artisan route:cache 2>/dev/null || echo "Route cache failed"
php artisan view:cache 2>/dev/null || echo "View cache failed"

# Create storage link
echo "Creating storage link..."
php artisan storage:link 2>/dev/null || echo "Storage link failed"

# Test Laravel installation
echo "Testing Laravel..."
php artisan about 2>/dev/null || echo "Laravel test failed"

echo "Laravel root deployment setup completed!"
