#!/bin/bash

echo "🔧 SAFE Azure Startup Script"
echo "============================"

log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1"
}

log "Starting SAFE Azure Laravel deployment..."

# Set working directory
cd /home/site/wwwroot

# Apply nginx configuration ONLY
if [ -f "/home/site/wwwroot/nginx.conf" ]; then
    log "📁 Applying nginx configuration..."
    
    # Backup original
    if [ ! -f "/etc/nginx/sites-available/default.backup" ]; then
        cp /etc/nginx/sites-available/default /etc/nginx/sites-available/default.backup
        log "✅ Backed up original nginx config"
    fi
    
    # Apply custom config
    cp /home/site/wwwroot/nginx.conf /etc/nginx/sites-available/default
    log "✅ Applied custom nginx configuration"
    
    # Test and reload
    if nginx -t 2>/dev/null; then
        nginx -s reload 2>/dev/null || service nginx restart
        log "✅ Nginx reloaded successfully"
    else
        log "❌ Nginx test failed, restoring backup"
        cp /etc/nginx/sites-available/default.backup /etc/nginx/sites-available/default
        service nginx restart
    fi
else
    log "⚠️  No custom nginx.conf found"
fi

# Set basic permissions
log "🔧 Setting basic permissions..."
chmod -R 755 /home/site/wwwroot
chmod -R 775 /home/site/wwwroot/storage 2>/dev/null || true
chmod -R 775 /home/site/wwwroot/bootstrap/cache 2>/dev/null || true

# SAFE configuration update (no risky operations)
log "🛡️ Running SAFE Azure configuration..."
if [ -f "/home/site/wwwroot/safe-azure-config.php" ]; then
    timeout 30 php /home/site/wwwroot/safe-azure-config.php
    log "✅ Safe configuration applied (with timeout)"
else
    log "⚠️  Safe config script not found"
fi

# Basic cache clear with timeout
log "🧹 Basic cache clearing (with timeout)..."
timeout 15 php artisan config:clear 2>/dev/null || log "⚠️  Config clear timed out"
timeout 15 php artisan route:clear 2>/dev/null || log "⚠️  Route clear timed out"

log "✅ SAFE startup completed!"
log "🌐 Your application should now be accessible"
