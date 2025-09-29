#!/bin/bash

echo "Deploying HTTPS and Routing Fixes to Azure"
echo "=========================================="

# Add the changes to git
echo "Adding changes to git..."
git add .
git status

# Commit the changes
echo "Committing changes..."
git commit -m "Fix HTTPS mixed content and Laravel routing from root directory

- Updated .env.production with ASSET_URL and FORCE_HTTPS settings
- Enhanced .htaccess with proper Laravel rewrite rules and HTTPS headers
- Improved azure-laravel-setup.php with comprehensive cache clearing"

# Push to trigger Azure deployment
echo "Pushing to Azure..."
git push origin main

echo ""
echo "Deployment initiated!"
echo "Monitor the deployment at:"
echo "https://portal.azure.com/#@kaveeshasenarathneoutlook.onmicrosoft.com/resource/subscriptions/ca61cf33-9700-4d8c-9ffc-34c2a0cc66ad/resourceGroups/techbuy-rg/providers/Microsoft.Web/sites/techbuy-webapp/deploymentCenter"
echo ""
echo "After deployment completes (2-3 minutes), test:"
echo "1. Homepage: https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net/"
echo "2. Other pages to verify routing works"
echo "3. Check browser console for mixed content errors"
