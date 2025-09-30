#!/bin/bash

echo "==================== SIMPLE AZURE ROUTING FIX ===================="
echo "🎯 Deploying simplified URL rewriting fix..."

# Commit the simplified routing fix
git add .
git commit -m "fix: Simplified Azure URL rewriting for Laravel routes

🎯 Simple but effective Azure routing fix:
- Fixed web.config rewrite rule (removed {R:1} from URL)
- Simplified .htaccess for better Azure compatibility
- Cleaner rewrite rules focused on core functionality

🔧 Key change:
- web.config now uses: url=\"index.php\" (not index.php/{R:1})
- .htaccess simplified to: RewriteRule ^ index.php [L]
- This should make /login work properly in Azure"

# Deploy to Azure
echo "📤 Pushing simplified fix to Azure..."
git push origin main

echo ""
echo "🎯 SIMPLIFIED ROUTING FIX DEPLOYED!"
echo ""
echo "==================== TEST IMMEDIATELY ===================="
echo ""
echo "The fix should work right away. Test these URLs:"
echo ""
echo "✅ Home page (should still work):"
echo "   https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net/"
echo ""
echo "🔥 The problematic routes (should work now):"
echo "   https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net/login"
echo "   https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net/register"
echo ""
echo "🔍 Debug tool (to verify changes):"
echo "   https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net/debug-routing.php"
echo ""
echo "==================== WHAT CHANGED ===================="
echo ""
echo "🔧 web.config fix:"
echo "   OLD: <action type=\"Rewrite\" url=\"index.php/{R:1}\" />"
echo "   NEW: <action type=\"Rewrite\" url=\"index.php\" />"
echo ""
echo "🔧 .htaccess simplification:"
echo "   Removed complex redirects and trailing slash handling"
echo "   Simple rule: RewriteRule ^ index.php [L]"
echo ""
echo "💡 This matches the working pattern you found!"
echo "   /index.php/login works → now /login should work too"
echo ""
echo "🚀 Test your routes now - they should work immediately!"
