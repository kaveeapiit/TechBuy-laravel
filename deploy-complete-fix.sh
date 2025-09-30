#!/bin/bash

echo "🚀 Complete Azure Fix: Routing + Database"
echo "========================================"

echo "📝 Adding all changes to git..."
git add .

echo ""
echo "📋 Changes being deployed:"
echo "✅ web.config - For Azure routing (nginx compatibility)"
echo "✅ nginx/default.conf - Nginx configuration"
echo "✅ azure-db-setup.sh - Database migration and seeding"
echo "✅ startup.sh - Azure startup script"
echo "✅ .env.azure - Environment template"
echo ""

# Show what we're committing
git status --porcelain | head -10

echo ""
echo "💾 Committing comprehensive Azure fix..."
git commit -m "Fix Azure routing and database issues

🔧 Routing Fixes:
- Add web.config for Azure App Service compatibility
- Add nginx configuration for proper routing
- Remove dependency on .htaccess (not supported in Azure Linux)

🗄️ Database Fixes:
- Add Azure database setup script
- Add migration and seeding for empty databases
- Add environment configuration template
- Add startup script for Azure deployment

This should fix:
❌ 404 errors on all pages except home
❌ Empty database issues in Azure
❌ Nginx routing problems"

echo ""
echo "🌐 Deploying to Azure..."
git push origin main

echo ""
echo "🎯 COMPREHENSIVE FIX DEPLOYED!"
echo ""
echo "This addresses both major issues:"
echo ""
echo "1. 🔗 ROUTING ISSUE:"
echo "   - Azure uses nginx, not Apache (.htaccess ignored)"
echo "   - Added web.config for proper URL rewriting"
echo "   - Added nginx configuration"
echo ""
echo "2. 🗄️ DATABASE ISSUE:"
echo "   - Azure databases likely empty/not connected"
echo "   - Added migration and seeding scripts"
echo "   - Added environment configuration"
echo ""
echo "⏰ Wait 3-4 minutes for deployment, then:"
echo ""
echo "🧪 Test URLs:"
echo "🔗 https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net/"
echo "🔗 https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net/products"
echo "🔗 https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net/login"
echo ""
echo "Expected: No more 404 errors, products should load!"
echo ""
echo "🔧 If databases are still empty, you'll need to:"
echo "1. Configure Azure PostgreSQL connection strings"
echo "2. Configure Azure MongoDB connection strings"
echo "3. Run: php artisan migrate:fresh --seed --force"
