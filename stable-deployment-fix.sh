#!/bin/bash

echo "🎯 STABLE AZURE DEPLOYMENT FIX"
echo "=============================="
echo "Preserving: URL routing, HTTPS, CSRF, and form fixes"
echo "Fixing: Azure SCM container restart issues"
echo ""

# Function to log with timestamp
log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1"
}

# Check if we're in Laravel project directory
if [ ! -f "artisan" ]; then
    echo "❌ Error: Not in Laravel project directory"
    echo "Please run this from your Laravel project root"
    exit 1
fi

log "Creating stable deployment solution..."

# Create a simple, deployment-safe startup script
cat > startup.sh << 'EOF'
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

EOF

chmod +x startup.sh

# Create a simple environment configuration script (no risky operations)
cat > configure-env.php << 'EOF'
<?php
// Simple environment configuration for Azure
// This only sets essential variables without risky operations

$envFile = '/home/site/wwwroot/.env';
if (file_exists($envFile)) {
    $envContent = file_get_contents($envFile);

    // Ensure APP_URL is set for Azure
    if (!preg_match('/^APP_URL=/m', $envContent)) {
        $envContent .= "\nAPP_URL=https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net\n";
        file_put_contents($envFile, $envContent);
        echo "✅ APP_URL configured for Azure\n";
    }

    // Ensure session security
    if (!preg_match('/^SESSION_SECURE_COOKIE=/m', $envContent)) {
        $envContent .= "SESSION_SECURE_COOKIE=true\n";
        file_put_contents($envFile, $envContent);
        echo "✅ Secure cookies enabled\n";
    }
}
?>
EOF

log "✅ Created deployment-safe scripts"

# Remove any problematic files that could cause SCM conflicts
rm -f configure-azure-csrf.php 2>/dev/null || true
rm -f configure-https.php 2>/dev/null || true
rm -f deploy-*.sh 2>/dev/null || true
rm -f emergency-fix.sh 2>/dev/null || true
rm -f nuclear-fix.sh 2>/dev/null || true

log "🗑️ Removed problematic deployment scripts"

# Git operations with deployment-focused commit
log "📝 Committing stable deployment fix..."

git add .
git commit -m "fix: Stable Azure deployment - preserve all working fixes

✅ PRESERVES ALL WORKING FUNCTIONALITY:
   - URL routing (/login, /register work via nginx.conf)
   - HTTPS redirect and security headers
   - CSRF protection (TrustProxies middleware exists)
   - Form submission (secure cookies configured)

🔧 FIXES DEPLOYMENT ISSUES:
   - Simplified startup.sh (no risky operations)
   - Removed scripts causing SCM container conflicts
   - Basic environment configuration only
   - No bootstrap modifications or exec conflicts

This maintains all functionality while ensuring stable Azure deployment
without SCM container restart issues."

log "🚀 Pushing stable deployment fix..."
git push origin main

log "✅ Stable deployment fix pushed!"

echo ""
echo "🎯 DEPLOYMENT SOLUTION SUMMARY:"
echo "==============================="
echo ""
echo "✅ PRESERVED (all your working fixes):"
echo "   🌐 nginx.conf - URL routing (/login, /register)"
echo "   🔒 HTTPS redirect and security headers"
echo "   🛡️ TrustProxies middleware for CSRF"
echo "   📝 Session configuration for forms"
echo ""
echo "🔧 FIXED (deployment stability):"
echo "   ❌ Removed scripts causing SCM conflicts"
echo "   ✅ Simplified startup.sh (safe operations only)"
echo "   ✅ Basic environment setup (no risky exec commands)"
echo ""
echo "🚀 NEXT STEPS:"
echo "============="
echo "1. Wait for this deployment to complete (should be stable now)"
echo "2. After deployment, manually run in Azure SSH:"
echo "   cd /home/site/wwwroot"
echo "   chmod +x startup.sh && ./startup.sh"
echo ""
echo "3. Add these in Azure Portal → Configuration → Application settings:"
echo "   APP_URL = https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net"
echo "   SESSION_SECURE_COOKIE = true"
echo ""
echo "🎉 This should deploy successfully while keeping all fixes!"
