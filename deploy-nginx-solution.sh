#!/bin/bash

echo "==================== NGINX + PHP-FPM AZURE SOLUTION ===================="
echo "🚀 Deploying comprehensive nginx configuration for Laravel pretty URLs..."

# Make startup script executable
chmod +x startup.sh

# Commit all the nginx configuration files
git add .
git commit -m "feat: Complete nginx + php-fpm solution for Azure Laravel deployment

🎯 Comprehensive Azure nginx solution:
- Custom nginx.conf with Laravel pretty URL support
- Intelligent startup.sh script for automatic configuration
- Static asset optimization with caching headers
- Security rules for hidden files and sensitive directories
- PHP-FPM integration with performance tuning
- Health check endpoint for monitoring

🔧 Key features:
- try_files directive for Laravel routing (/login works without /index.php/)
- Static asset caching (CSS, JS, images) with proper headers
- Livewire and storage file handling
- CORS support for fonts and assets
- Gzip compression for performance
- Security headers and file protection
- Debug tool accessibility

🌐 This fixes all routing issues and optimizes performance!"

# Push to Azure
echo "📤 Deploying to Azure..."
git push origin main

echo ""
echo "==================== AZURE CONFIGURATION REQUIRED ===================="
echo ""
echo "🔧 MANUAL STEPS IN AZURE PORTAL:"
echo ""
echo "1. Go to Azure Portal → Your App Service → Configuration → General Settings"
echo ""
echo "2. Set the Startup Command:"
echo "   /home/site/wwwroot/startup.sh"
echo ""
echo "3. Add these Application Settings (Configuration → Application Settings):"
echo "   WEBSITES_ENABLE_APP_SERVICE_STORAGE = false"
echo "   WEBSITES_CONTAINER_START_TIME_LIMIT = 1800"
echo ""
echo "4. Save and restart your App Service"
echo ""
echo "==================== ALTERNATIVE: SSH DEPLOYMENT ===================="
echo ""
echo "🔄 OR use SSH for immediate deployment:"
echo ""
echo "1. Go to App Service → Development Tools → SSH"
echo ""
echo "2. In SSH console, run:"
echo "   cd /home/site/wwwroot"
echo "   chmod +x startup.sh"
echo "   ./startup.sh"
echo ""
echo "==================== EXPECTED RESULTS ===================="
echo ""
echo "✅ After configuration, these URLs should work:"
echo "   🏠 https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net/"
echo "   🔐 https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net/login"
echo "   📝 https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net/register"
echo "   📊 https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net/dashboard"
echo "   🛍️  https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net/products"
echo ""
echo "✅ Static assets should load correctly:"
echo "   🎨 CSS files with proper caching"
echo "   ⚡ JavaScript files optimized"
echo "   🖼️  Images and fonts with CORS headers"
echo "   ⚡ Livewire components working"
echo ""
echo "✅ Additional features:"
echo "   ❤️  /health - Health check endpoint"
echo "   🔧 /debug-routing.php - Routing diagnostics"
echo "   🍃 /mongodb-status.php - MongoDB status"
echo ""
echo "==================== WHAT THIS FIXES ===================="
echo ""
echo "🎯 Routing Issues:"
echo "   ✅ Pretty URLs (/login instead of /index.php/login)"
echo "   ✅ Laravel route resolution through nginx try_files"
echo "   ✅ Proper 404 handling for missing routes"
echo ""
echo "🎯 Static Assets:"
echo "   ✅ CSS, JS, images serve with proper MIME types"
echo "   ✅ Caching headers for performance (1 year for assets)"
echo "   ✅ Gzip compression for text files"
echo "   ✅ CORS headers for cross-origin requests"
echo ""
echo "🎯 Security:"
echo "   ✅ Hidden files (.env, .git) blocked"
echo "   ✅ Sensitive directories (storage/app) protected"
echo "   ✅ Security headers (XSS, CSRF protection)"
echo ""
echo "🎯 Performance:"
echo "   ✅ PHP-FPM optimization"
echo "   ✅ FastCGI buffering and timeouts"
echo "   ✅ Laravel route and config caching"
echo ""
echo "🚀 This is the definitive solution for your Azure Laravel deployment!"