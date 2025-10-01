#!/bin/bash

echo "🛡️ CSRF 419 Error Fix Deployment"
echo "================================"

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

log "Deploying CSRF 419 error fixes..."

# Make scripts executable
chmod +x startup.sh
chmod +x configure-https.php
chmod +x csrf-debug.php

log "🔧 Files prepared for deployment"

# Display what's being fixed
echo ""
echo "🎯 CSRF 419 ERROR FIXES:"
echo "========================"
echo "✅ Enhanced configure-https.php:"
echo "   - Session domain configuration"
echo "   - Session same-site policy (lax)"
echo "   - Session driver and lifetime settings"
echo "   - Complete cache clearing (config, route, view, cache)"
echo "   - CSRF protection optimization for HTTPS"
echo "   - Session storage writability check"
echo ""
echo "✅ Added csrf-debug.php:"
echo "   - CSRF token generation testing"
echo "   - Session information display"
echo "   - Environment variables check"
echo "   - Server variables verification"
echo "   - Quick test form for debugging"
echo ""

# Git operations
log "📝 Committing CSRF fixes to Git..."

git add .
git commit -m "fix: Resolve 419 CSRF token mismatch errors in HTTPS forms

- Enhanced configure-https.php with comprehensive session configuration
- Added SESSION_DOMAIN and SESSION_SAME_SITE settings to .env
- Added session driver and lifetime configuration
- Complete cache clearing (config, route, view, cache)
- CSRF protection optimization for HTTPS environment
- Session storage writability verification
- Added csrf-debug.php for troubleshooting CSRF issues
- Session security configuration (secure, http_only, same_site)

Fixes: POST 419 errors on /login and /register forms
Previous: HTTPS redirect and security headers working
Next: Forms should submit successfully with proper CSRF validation"

log "🚀 Pushing to repository..."
git push origin main

log "✅ Deployment complete!"

echo ""
echo "🎯 NEXT STEPS TO FIX 419 ERRORS:"
echo "================================"
echo "1. 🌐 Deploy to Azure (pull from GitHub or use Azure portal)"
echo "2. 🔧 Run in Azure SSH:"
echo "   cd /home/site/wwwroot"
echo "   chmod +x startup.sh && ./startup.sh"
echo ""
echo "🧪 TESTING AFTER FIX:"
echo "===================="
echo "1. 🔍 Debug information:"
echo "   https://your-app.azurewebsites.net/csrf-debug.php"
echo ""
echo "2. 🧪 Test forms:"
echo "   https://your-app.azurewebsites.net/login"
echo "   https://your-app.azurewebsites.net/register"
echo ""
echo "Expected results:"
echo "   ✅ No more 419 errors"
echo "   ✅ Forms submit successfully"
echo "   ✅ CSRF tokens generate properly"
echo "   ✅ Sessions work with HTTPS"
echo ""
echo "🔍 WHAT THE ENHANCED FIXES DO:"
echo "=============================="
echo "1. 🍪 Session Configuration: Proper domain and same-site settings"
echo "2. 🔄 Complete Cache Clear: All Laravel caches refreshed"
echo "3. 🛡️ CSRF Optimization: Token generation works with HTTPS"
echo "4. 📁 Session Storage: Ensures writability for session files"
echo "5. 🧪 Debug Tools: csrf-debug.php for troubleshooting"
echo ""
echo "This should completely resolve the 419 CSRF token mismatch errors!"
