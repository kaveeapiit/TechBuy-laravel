#!/bin/bash

echo "🔄 LIVEWIRE ROUTING FIX"
echo "======================"
echo "Fixing: 404/405 errors for Livewire AJAX actions"
echo "Preserving: URL routing, HTTPS, CSRF, and all existing fixes"
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

log "Deploying Livewire routing fix..."

# Make sure startup script is executable
chmod +x startup.sh

log "🔧 Updated nginx.conf with Livewire routing fix"

# Display what was fixed
echo ""
echo "🎯 LIVEWIRE ROUTING FIX APPLIED:"
echo "==============================="
echo ""
echo "✅ nginx.conf now handles:"
echo "   🔄 Dynamic Livewire requests: /livewire/update → Laravel"
echo "   📁 Static Livewire assets: /livewire/*.js → Direct file serving"
echo "   🔀 Fallback routing: Missing Livewire files → Laravel"
echo ""
echo "🔧 Technical changes:"
echo "   1. Added specific location for dynamic Livewire endpoints"
echo "   2. Modified static Livewire location to use fallback"
echo "   3. Added @livewire_fallback for routing missed requests"
echo "   4. Maintained caching for static assets"
echo ""
echo "✅ PRESERVED (all existing functionality):"
echo "   🌐 URL routing (/login, /register, /dashboard)"
echo "   🔒 HTTPS redirect and security headers"
echo "   🛡️ CSRF protection and form submission"
echo "   📱 Static asset serving and caching"
echo ""

# Git operations
log "📝 Committing Livewire routing fix..."

git add .
git commit -m "fix: Livewire AJAX routing - resolve 404/405 cart errors

🔄 LIVEWIRE ROUTING FIX:
   - Handle dynamic Livewire requests (/livewire/update, /livewire/message)
   - Route Livewire AJAX calls through Laravel index.php
   - Preserve static Livewire asset serving with caching
   - Add fallback routing for missed Livewire requests

🎯 FIXES SPECIFIC ISSUES:
   - 404 errors on /livewire/update (cart actions)
   - 405 Method Not Allowed for Livewire POST requests
   - Livewire component interactions not working

✅ PRESERVES ALL EXISTING FIXES:
   - URL routing (/login, /register work)
   - HTTPS redirect and security
   - CSRF protection and forms
   - Static asset optimization

This enables Livewire cart functionality while maintaining all
previously implemented fixes for Azure deployment."

log "🚀 Pushing Livewire fix..."
git push origin main

log "✅ Livewire routing fix deployed!"

echo ""
echo "🚀 DEPLOYMENT STEPS:"
echo "==================="
echo ""
echo "1. 🌐 Deploy to Azure (should complete successfully now)"
echo ""
echo "2. 🔧 After deployment, run in Azure SSH:"
echo "   cd /home/site/wwwroot"
echo "   chmod +x startup.sh && ./startup.sh"
echo ""
echo "3. 🧪 Test Livewire functionality:"
echo "   ✅ Add products to cart"
echo "   ✅ Update cart quantities"
echo "   ✅ Remove items from cart"
echo "   ✅ All Livewire component interactions"
echo ""
echo "Expected Results:"
echo "   ✅ No more 404 errors on /livewire/update"
echo "   ✅ No more 405 Method Not Allowed errors"
echo "   ✅ Cart actions work properly"
echo "   ✅ All existing functionality preserved"
echo ""
echo "🎯 This fix specifically handles the Livewire routing issue"
echo "   while preserving all your working Azure deployment fixes!"
