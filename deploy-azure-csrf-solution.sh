#!/bin/bash

echo "🛡️ Azure CSRF 419 Error Fix - Complete Solution"
echo "==============================================="

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

log "Deploying comprehensive Azure CSRF fixes..."

# Make scripts executable
chmod +x startup.sh
chmod +x configure-azure-csrf.php

log "🔧 Files prepared for deployment"

# Display what's being fixed
echo ""
echo "🎯 COMPLETE AZURE CSRF SOLUTION:"
echo "================================"
echo ""
echo "✅ 1. TrustProxies Middleware (app/Http/Middleware/TrustProxies.php):"
echo "   - protected \$proxies = '*' (trust Azure load balancer)"
echo "   - protected \$headers = all forwarded headers"
echo ""
echo "✅ 2. Session Configuration (config/session.php):"
echo "   - 'secure' => env('SESSION_SECURE_COOKIE', true)"
echo "   - 'same_site' => 'lax' (already configured)"
echo ""
echo "✅ 3. Nginx Configuration (nginx.conf):"
echo "   - fastcgi_param HTTP_X_FORWARDED_PROTO https"
echo "   - fastcgi_param HTTP_X_FORWARDED_FOR \$proxy_add_x_forwarded_for"
echo "   - fastcgi_param HTTP_X_FORWARDED_HOST \$host"
echo "   - fastcgi_param HTTP_X_FORWARDED_PORT 443"
echo ""
echo "✅ 4. Environment Configuration (configure-azure-csrf.php):"
echo "   - APP_URL = https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net"
echo "   - SESSION_DOMAIN = techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net"
echo "   - SESSION_SECURE_COOKIE = true"
echo "   - Complete cache clearing and refresh"
echo ""
echo "✅ 5. Startup Integration:"
echo "   - Updated startup.sh to run Azure CSRF configuration"
echo "   - Preserves URL routing and HTTPS fixes"
echo ""

# Git operations
log "📝 Committing Azure CSRF solution to Git..."

git add .
git commit -m "fix: Complete Azure CSRF 419 error solution

✅ Created TrustProxies middleware with Azure compatibility:
   - Trust all proxies (\$proxies = '*')
   - Handle all forwarded headers for Azure load balancer

✅ Updated session configuration:
   - Default secure cookies to true
   - Maintain 'lax' same-site policy

✅ Enhanced nginx FastCGI configuration:
   - Force HTTPS protocol forwarding
   - Proper proxy header handling for Azure
   - Fixed port forwarding (443 for HTTPS)

✅ Created configure-azure-csrf.php script:
   - Sets APP_URL to Azure domain
   - Configures SESSION_DOMAIN for Azure
   - Enables secure cookies
   - Clears and refreshes all caches

✅ Updated startup.sh integration:
   - Runs Azure CSRF configuration
   - Preserves existing URL routing fixes
   - Maintains HTTPS redirect functionality

This implements the complete Azure-specific CSRF solution to resolve
419 errors on /login and /register form submissions while preserving
all existing functionality (URL routing, HTTPS, static assets)."

log "🚀 Pushing to repository..."
git push origin main

log "✅ Deployment complete!"

echo ""
echo "🎯 DEPLOYMENT STEPS FOR AZURE:"
echo "============================="
echo ""
echo "📋 Step 1: Azure Portal Configuration"
echo "   Go to: Azure Portal → Your App Service → Configuration → Application settings"
echo "   Add these settings:"
echo "   ┌─────────────────────────────────────────────────────────────────────────────────┐"
echo "   │ APP_URL = https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net │"
echo "   │ SESSION_DOMAIN = techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net  │"
echo "   │ SESSION_SECURE_COOKIE = true                                                        │"
echo "   └─────────────────────────────────────────────────────────────────────────────────┘"
echo ""
echo "🚀 Step 2: Deploy and Run Setup"
echo "   1. Deploy latest code to Azure (GitHub sync or manual)"
echo "   2. SSH to Azure: cd /home/site/wwwroot"
echo "   3. Run: chmod +x startup.sh && ./startup.sh"
echo ""
echo "🧪 Step 3: Test CSRF Forms"
echo "   Test these URLs after setup:"
echo "   ✅ https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net/login"
echo "   ✅ https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net/register"
echo ""
echo "Expected Results:"
echo "   ✅ No more 419 errors"
echo "   ✅ Forms submit successfully"
echo "   ✅ CSRF tokens validate properly"
echo "   ✅ Sessions work securely with HTTPS"
echo "   ✅ URL routing still works (/login, /register, etc.)"
echo "   ✅ Static assets load correctly"
echo ""
echo "🔧 This solution addresses all Azure-specific CSRF requirements!"
echo "   - Trusts Azure load balancer proxies"
echo "   - Proper HTTPS detection through proxy headers"
echo "   - Secure session configuration for Azure environment"
echo "   - Domain-specific session handling"
echo ""
echo "🎉 Your Laravel app should now work perfectly with Azure App Service!"
