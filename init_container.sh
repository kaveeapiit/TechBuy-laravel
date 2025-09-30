#!/bin/bash

echo "🚀 Azure Container Initialization"
echo "================================"

# Function to log with timestamp
log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1"
}

log "Container startup detected - applying Laravel configuration..."

# Ensure we're in the right directory
cd /home/site/wwwroot

# Apply nginx configuration FIRST (before any services start)
if [ -f "/home/site/wwwroot/nginx.conf" ]; then
    log "📁 Applying custom nginx configuration..."

    # Create backup directory
    mkdir -p /home/site/backups

    # Backup original nginx config (only once)
    if [ ! -f "/home/site/backups/nginx-default.backup" ]; then
        cp /etc/nginx/sites-available/default /home/site/backups/nginx-default.backup
        log "✅ Created backup of original nginx configuration"
    fi

    # Apply our custom nginx configuration
    cp /home/site/wwwroot/nginx.conf /etc/nginx/sites-available/default
    log "✅ Applied custom nginx configuration"

    # Test and reload nginx
    if nginx -t 2>/dev/null; then
        log "✅ Nginx configuration test passed"

        # Force nginx reload/restart
        nginx -s reload 2>/dev/null || {
            log "🔄 Reloading nginx failed, restarting..."
            service nginx restart
        }
        log "✅ Nginx restarted with new configuration"
    else
        log "❌ Nginx configuration test failed!"
        # Restore backup and restart
        cp /home/site/backups/nginx-default.backup /etc/nginx/sites-available/default
        service nginx restart
        log "🔄 Restored original configuration"
    fi
else
    log "⚠️  No custom nginx.conf found"
fi

# Set file permissions for Laravel
log "🔧 Setting Laravel permissions..."
chmod -R 755 /home/site/wwwroot
chmod -R 775 /home/site/wwwroot/storage 2>/dev/null || true
chmod -R 775 /home/site/wwwroot/bootstrap/cache 2>/dev/null || true

# Change ownership for writable directories
chown -R www-data:www-data /home/site/wwwroot/storage 2>/dev/null || true
chown -R www-data:www-data /home/site/wwwroot/bootstrap/cache 2>/dev/null || true

# Configure Laravel HTTPS settings
log "🔒 Configuring Laravel for HTTPS..."
if [ -f "/home/site/wwwroot/configure-https.php" ]; then
    php /home/site/wwwroot/configure-https.php
    log "✅ HTTPS configuration applied"
fi

# Clear Laravel caches
log "🧹 Clearing Laravel caches..."
php artisan config:clear 2>/dev/null || true
php artisan route:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true

# Optimize for production if needed
if [ "$APP_ENV" = "production" ]; then
    log "🏭 Production optimizations..."
    php artisan config:cache 2>/dev/null || true
    php artisan route:cache 2>/dev/null || true
    php artisan view:cache 2>/dev/null || true
fi

# Verify services are running
log "🔍 Verifying services..."

# Check nginx
if pgrep nginx > /dev/null; then
    log "✅ Nginx is running"
    NGINX_PORT=$(netstat -tlnp 2>/dev/null | grep nginx | grep :8080 | head -1)
    if [ ! -z "$NGINX_PORT" ]; then
        log "📡 Nginx listening on port 8080"
    fi
else
    log "❌ Nginx is not running!"
fi

# Check PHP-FPM
if pgrep php-fpm > /dev/null; then
    log "✅ PHP-FPM is running"
else
    log "⚠️  PHP-FPM status unknown"
fi

log "================================"
log "🎯 Container initialization complete!"
log "================================"
log "✅ Laravel pretty URLs should work: /login, /register, /dashboard"
log "✅ HTTPS should be enforced and secure"
log "✅ Static assets should load properly"

# Start the original process (usually apache2-foreground or similar)
# This ensures we don't interfere with Azure's normal startup
exec "$@"
