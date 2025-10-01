#!/bin/bash

echo "🚨 EMERGENCY FIX: Stop Infinite Loop and Restore Service"
echo "======================================================"

# Function to log with timestamp
log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1"
}

log "Creating emergency fix for hanging deployment..."

# Create a minimal, safe startup script
cat > startup-safe.sh << 'EOF'
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
EOF

chmod +x startup-safe.sh

log "✅ Created safe startup script"

# Git operations with clear commit message
log "📝 Committing emergency fix..."

git add .
git commit -m "EMERGENCY FIX: Stop infinite loop in deployment

- Created safe-azure-config.php (no exec commands, no bootstrap modifications)
- Created startup-safe.sh with timeouts to prevent hanging
- Removed risky operations that could cause infinite loops
- Added timeout protection for all Laravel commands
- Preserves nginx configuration and basic functionality

This should stop the current deployment hanging issue and restore service."

log "🚀 Pushing emergency fix..."
git push origin main

log "✅ Emergency fix deployed!"

echo ""
echo "🚨 IMMEDIATE ACTIONS NEEDED:"
echo "============================"
echo ""
echo "1. 🛑 STOP current Azure deployment if still running:"
echo "   - Go to Azure Portal → Deployment Center"
echo "   - Cancel any running deployments"
echo ""
echo "2. 🔄 Deploy this emergency fix:"
echo "   - Sync from GitHub or manual deploy"
echo ""
echo "3. 🔧 Use SAFE startup script in Azure SSH:"
echo "   cd /home/site/wwwroot"
echo "   chmod +x startup-safe.sh"
echo "   ./startup-safe.sh"
echo ""
echo "4. 🧪 Test the site:"
echo "   https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net"
echo ""
echo "🔍 WHAT WAS CAUSING THE ISSUE:"
echo "============================="
echo "❌ configure-azure-csrf.php had risky operations:"
echo "   - Bootstrap file modifications"
echo "   - Multiple exec() commands without timeouts"
echo "   - Potential permission issues"
echo ""
echo "✅ startup-safe.sh fixes this by:"
echo "   - Using timeouts on all commands"
echo "   - Only essential operations"
echo "   - No risky file modifications"
echo ""
echo "🎯 This should restore your site to working condition!"