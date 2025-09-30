#!/bin/bash

echo "🚀 Deploying Complete Root Migration Fix"
echo "======================================="

# Add all changes
echo "1. 📝 Adding changes to git..."
git add .

# Show what we're about to commit
echo ""
echo "2. 📋 Changes to be deployed:"
git status --porcelain | head -10

# Commit the changes
echo ""
echo "3. 💾 Committing root migration fix..."
git commit -m "Complete root directory migration - Remove public conflicts

- Remove conflicting public/index.php and public/.htaccess
- Ensure all requests route through root index.php
- Move remaining public assets to root
- Fix Laravel routing for root deployment
- Resolve 404 errors for non-home pages"

# Push to Azure
echo ""
echo "4. 🌐 Deploying to Azure..."
git push origin main

echo ""
echo "🎯 Root Migration Fix Deployment Complete!"
echo ""
echo "This fix addresses the core routing issue by:"
echo "✅ Eliminating conflicts between root and public setups"
echo "✅ Ensuring all routes go through the correct index.php"
echo "✅ Removing duplicate .htaccess configurations"
echo "✅ Completing the root directory migration you started"
echo ""
echo "Wait 2-3 minutes, then test:"
echo "🔗 Home: https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net/"
echo "🔗 Products: https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net/products"
echo "🔗 Login: https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net/login"
echo "🔗 Register: https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net/register"
echo ""
echo "Expected result: All pages should work without 404 errors!"