#!/bin/bash

echo "🔧 Azure Laravel Startup (Deployment Safe)"
echo "=========================================="

log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1"
}

log "Starting Azure Laravel configuration..."

# Set working directory
cd /home/site/wwwroot

# Apply nginx configuration (essential for URL routing)
if [ -f "/home/site/wwwroot/nginx.conf" ]; then
    log "📁 Applying nginx configuration..."

    # Simple backup
    cp /etc/nginx/sites-available/default /etc/nginx/sites-available/default.backup 2>/dev/null || true

    # Apply configuration
    cp /home/site/wwwroot/nginx.conf /etc/nginx/sites-available/default

    # Reload nginx
    nginx -s reload 2>/dev/null || service nginx restart 2>/dev/null
    log "✅ Nginx configuration applied"
fi

# Set basic permissions
chmod -R 755 /home/site/wwwroot 2>/dev/null || true
chmod -R 775 /home/site/wwwroot/storage 2>/dev/null || true
chmod -R 775 /home/site/wwwroot/bootstrap/cache 2>/dev/null || true

log "✅ Basic Laravel startup completed"
log "🌐 Application ready with all fixes preserved"

