#!/bin/bash

echo "🚀 Deploying Azure Diagnostic Tools"
echo "=================================="

git add azure-diagnostic-commands.sh azure-diagnostic.php

echo "📋 Adding diagnostic tools:"
echo "✅ azure-diagnostic-commands.sh - Console commands reference"
echo "✅ azure-diagnostic.php - Automated diagnostic script"

git commit -m "Add Azure database diagnostic tools

- azure-diagnostic-commands.sh: Reference for manual testing
- azure-diagnostic.php: Automated diagnostic script
- Test PostgreSQL and MongoDB connections
- Check environment variables and Laravel models
- Verify file permissions and system status"

echo ""
echo "🌐 Deploying to Azure..."
git push origin main

echo ""
echo "✅ DIAGNOSTIC TOOLS DEPLOYED!"
echo ""
echo "🔧 How to test your database connections in Azure:"
echo ""
echo "Method 1 - Azure Portal Console:"
echo "1. Go to: https://techbuy-webapp-agbgf2gbgud8apaw.scm.centralindia-01.azurewebsites.net/"
echo "2. Click 'Debug console' → 'CMD' or 'PowerShell'"
echo "3. Navigate to: cd site\\wwwroot"
echo "4. Run: php azure-diagnostic.php"
echo ""
echo "Method 2 - Azure SSH:"
echo "1. Azure Portal → Your App Service → SSH"
echo "2. cd /home/site/wwwroot"
echo "3. php azure-diagnostic.php"
echo ""
echo "Method 3 - Quick Laravel Test:"
echo "php artisan tinker --execute=\"echo 'Users: ' . \App\Models\User::count(); echo 'Products: ' . \App\Models\Product::count();\""
echo ""
echo "Method 4 - Check Environment Variables:"
echo "php artisan tinker --execute=\"echo 'DB_HOST: ' . env('DB_HOST'); echo 'DB_DATABASE: ' . env('DB_DATABASE');\""
echo ""
echo "🔍 What to look for:"
echo "✅ Environment variables are set correctly"
echo "✅ PostgreSQL connection works"
echo "✅ MongoDB connection works (if configured)"
echo "✅ User and Product counts > 0"
echo ""
echo "❌ If you see errors:"
echo "- Check Azure environment variables"
echo "- Verify database server is running"
echo "- Check firewall rules"
echo "- Verify connection strings"
