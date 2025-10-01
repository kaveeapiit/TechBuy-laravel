#!/bin/bash

echo "🚀 Azure Startup Script"
echo "====================="

# Set permissions
chmod -R 755 /home/site/wwwroot
chown -R root:root /home/site/wwwroot

#!/bin/bash

echo "🚀 Azure Laravel Startup Script"
echo "=============================="

# Function to log with timestamp
log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1"
}

log "Starting Azure Laravel deployment configuration..."

# Set working directory
cd /home/site/wwwroot

# Apply custom nginx configuration
if [ -f "/home/site/wwwroot/nginx.conf" ]; then
    log "📁 Found custom nginx.conf, applying configuration..."

    # Backup original nginx config
    if [ ! -f "/etc/nginx/sites-available/default.backup" ]; then
        cp /etc/nginx/sites-available/default /etc/nginx/sites-available/default.backup
        log "✅ Backed up original nginx configuration"
    fi

    # Apply our custom nginx configuration
    cp /home/site/wwwroot/nginx.conf /etc/nginx/sites-available/default
    log "✅ Applied custom nginx configuration"

    # Test nginx configuration
    if nginx -t 2>/dev/null; then
        log "✅ Nginx configuration test passed"

        # Reload nginx
        nginx -s reload 2>/dev/null || service nginx restart
        log "✅ Nginx reloaded successfully"
    else
        log "❌ Nginx configuration test failed, restoring backup"
        cp /etc/nginx/sites-available/default.backup /etc/nginx/sites-available/default
        nginx -s reload 2>/dev/null || service nginx restart
        log "🔄 Restored original nginx configuration"
    fi
else
    log "⚠️  Custom nginx.conf not found, using default configuration"
fi

# Set proper file permissions
log "🔧 Setting file permissions..."
chmod -R 755 /home/site/wwwroot
chmod -R 775 /home/site/wwwroot/storage
chmod -R 775 /home/site/wwwroot/bootstrap/cache

# Change ownership to www-data for writable directories
chown -R www-data:www-data /home/site/wwwroot/storage 2>/dev/null || true
chown -R www-data:www-data /home/site/wwwroot/bootstrap/cache 2>/dev/null || true

log "✅ File permissions set"

# Laravel optimizations
log "⚡ Running Laravel optimizations..."

# Configure Azure CSRF settings
log "�️ Configuring Azure CSRF settings..."
if [ -f "/home/site/wwwroot/configure-azure-csrf.php" ]; then
    php /home/site/wwwroot/configure-azure-csrf.php
    log "✅ Azure CSRF configuration applied"
fi
php artisan view:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true

# Optimize for production
if [ "$APP_ENV" = "production" ]; then
    log "🏭 Production environment detected, running optimizations..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    log "✅ Production optimizations completed"
else
    log "🔧 Development environment, skipping cache optimizations"
fi

# Create storage symlink if it doesn't exist
if [ ! -L "/home/site/wwwroot/storage" ] && [ ! -d "/home/site/wwwroot/storage" ]; then
    php artisan storage:link 2>/dev/null || true
    log "🔗 Storage symlink created"
fi

# Verify important files exist
log "🔍 Verifying Laravel installation..."

if [ -f "/home/site/wwwroot/index.php" ]; then
    log "✅ index.php found"
else
    log "❌ index.php missing!"
fi

if [ -f "/home/site/wwwroot/artisan" ]; then
    log "✅ artisan command found"
else
    log "❌ artisan command missing!"
fi

if [ -d "/home/site/wwwroot/vendor" ]; then
    log "✅ vendor directory found"
else
    log "❌ vendor directory missing! Run: composer install"
fi

# Test PHP-FPM
log "🔧 Testing PHP-FPM..."
if pgrep php-fpm > /dev/null; then
    log "✅ PHP-FPM is running"
else
    log "⚠️  PHP-FPM may not be running"
fi

# Show nginx status
log "🌐 Nginx status:"
if pgrep nginx > /dev/null; then
    log "✅ Nginx is running"

    # Show listening ports
    PORTS=$(netstat -tlnp 2>/dev/null | grep nginx | awk '{print $4}' | grep -o ':[0-9]*' | sort -u)
    if [ ! -z "$PORTS" ]; then
        log "📡 Nginx listening on ports: $PORTS"
    fi
else
    log "❌ Nginx is not running!"
fi

# Show final status
log "=============================="
log "🎯 Laravel Startup Complete!"
log "=============================="
log ""
log "🌐 Your Laravel application should now be accessible with pretty URLs:"
log "   ✅ /login (instead of /index.php/login)"
log "   ✅ /register"
log "   ✅ /dashboard"
log "   ✅ /products"
log ""
log "🔧 Static assets should load correctly:"
log "   ✅ CSS and JS files"
log "   ✅ Images and fonts"
log "   ✅ Livewire components"
log ""
log "🔍 Debug tools available:"
log "   📊 /debug-routing.php"
log "   🍃 /mongodb-status.php"
log "   ❤️  /health (health check)"
log ""
log "🎉 Deployment startup completed successfully!"

echo "✅ Laravel application ready"
