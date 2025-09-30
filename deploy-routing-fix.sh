#!/bin/bash

echo "==================== AZURE ROUTING FIX DEPLOYMENT ===================="
echo "🔧 Deploying enhanced routing configuration for Azure..."

# Add all changes
git add .

# Commit the routing improvements
git commit -m "fix: Enhanced Azure routing with comprehensive web.config and debugging

🎯 Key fixes for Azure App Service routing:
- Enhanced web.config with proper Laravel route handling
- Improved index.php with better request processing
- Added debug-routing.php for troubleshooting
- Fixed static file handling and HTTPS enforcement
- Added PHP FastCGI configuration for Azure

🔧 Technical improvements:
- URL rewrite rules optimized for Azure nginx
- Better environment detection in index.php
- Debug logging for route resolution
- Comprehensive error handling"

# Deploy to Azure
echo "📤 Pushing to Azure..."
git push origin main

echo ""
echo "🎯 ROUTING FIX DEPLOYED!"
echo ""
echo "==================== TEST YOUR ROUTES ===================="
echo ""
echo "1. Test the debug tool first:"
echo "   https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net/debug-routing.php"
echo ""
echo "2. Test if direct Laravel routing works:"
echo "   https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net/index.php/login"
echo ""
echo "3. Test the problematic routes (should work now):"
echo "   https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net/login"
echo "   https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net/register"
echo ""
echo "==================== WHAT WAS FIXED ===================="
echo ""
echo "✅ web.config enhancements:"
echo "   - Proper Laravel route rewriting"
echo "   - Static file handling"
echo "   - HTTPS enforcement"
echo "   - PHP FastCGI configuration"
echo ""
echo "✅ index.php improvements:"
echo "   - Better Azure detection"
echo "   - Enhanced request handling"
echo "   - Debug logging support"
echo ""
echo "✅ Debug tools added:"
echo "   - Route resolution testing"
echo "   - Environment diagnostics"
echo "   - File system checks"
echo ""
echo "🚀 Your Laravel routes should now work properly in Azure!"
