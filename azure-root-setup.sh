#!/bin/bash

# Azure Laravel Root Deployment Script
echo "Setting up Laravel for root deployment..."

cd /home/site/wwwroot

# Move ALL public assets to root (comprehensive approach)
echo "Moving all public assets to root directory..."

# Copy all files from public/ to root, excluding index.php (we'll handle it separately)
if [ -d "public" ]; then
    echo "Copying public assets..."
    
    # Copy individual files and directories from public/
    find public/ -maxdepth 1 -type f ! -name "index.php" -exec cp {} . \;
    
    # Copy directories from public/
    find public/ -maxdepth 1 -type d ! -name "public" -exec cp -r {} . \;
    
    # Specifically ensure build directory is copied
    if [ -d "public/build" ]; then
        cp -r public/build . 2>/dev/null || echo "Build directory copy failed"
        echo "✅ Build assets copied"
    else
        echo "⚠️  No build directory found in public/"
    fi
    
    # Create storage link in root
    if [ -d "storage/app/public" ]; then
        ln -sf ../storage/app/public storage 2>/dev/null || echo "Storage link failed"
        echo "✅ Storage link created"
    fi
    
    echo "✅ All public assets moved to root"
else
    echo "❌ Public directory not found"
fi

# Ensure Livewire assets are accessible
if [ -d "vendor/livewire" ]; then
    # Create livewire directory in root and copy assets
    mkdir -p livewire
    if [ -f "vendor/livewire/livewire/dist/livewire.min.js" ]; then
        cp vendor/livewire/livewire/dist/livewire.min.js livewire/ 2>/dev/null || echo "Livewire JS copy failed"
        echo "✅ Livewire assets copied"
    fi
fi

# Create comprehensive .htaccess for root deployment
cat > .htaccess << 'EOF'
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Serve static assets directly (CSS, JS, images, etc.)
    RewriteCond %{REQUEST_FILENAME} -f
    RewriteRule ^(build/.*|livewire/.*|storage/.*|.*\.(css|js|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot))$ - [L]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

DirectoryIndex index.php

# Force HTTPS
<IfModule mod_headers.c>
    Header always set Strict-Transport-Security "max-age=63072000; includeSubDomains; preload"
    
    # Cache static assets
    <FilesMatch "\.(css|js|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$">
        Header set Cache-Control "max-age=31536000, public"
    </FilesMatch>
</IfModule>
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

# Verify asset deployment
echo ""
echo "Verifying asset deployment..."
echo "================================"

# Check for key files
files_to_check=("index.php" ".htaccess" ".env")
for file in "${files_to_check[@]}"; do
    if [ -f "$file" ]; then
        echo "✅ $file exists"
    else
        echo "❌ $file missing"
    fi
done

# Check for directories
dirs_to_check=("build" "livewire" "storage")
for dir in "${dirs_to_check[@]}"; do
    if [ -d "$dir" ]; then
        echo "✅ $dir/ directory exists"
        file_count=$(find "$dir" -type f | wc -l)
        echo "   └── Contains $file_count files"
    else
        echo "❌ $dir/ directory missing"
    fi
done

# Check for specific asset files that were causing 404s
if [ -f "build/assets/app-B0xxWJs0.css" ] || [ -n "$(find build -name '*.css' 2>/dev/null)" ]; then
    echo "✅ CSS assets found in build/"
else
    echo "⚠️  CSS assets not found in build/"
fi

if [ -f "livewire/livewire.min.js" ]; then
    echo "✅ Livewire JS found"
else
    echo "⚠️  Livewire JS not found"
fi

echo "Laravel root deployment setup completed!"
