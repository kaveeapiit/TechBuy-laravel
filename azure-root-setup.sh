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

# Copy environment file
if [ -f ".env.production" ]; then
    cp .env.production .env
fi

# Clear and cache Laravel configurations
php artisan config:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true
php artisan route:clear 2>/dev/null || true

php artisan config:cache 2>/dev/null || true
php artisan route:cache 2>/dev/null || true
php artisan view:cache 2>/dev/null || true

# Create storage link
php artisan storage:link 2>/dev/null || true

echo "Laravel root deployment setup completed!"