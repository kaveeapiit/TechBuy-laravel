#!/bin/bash

echo "Laravel Route Fix Deployment"
echo "=========================="
echo ""

# Step 1: Build assets
echo "1. Building frontend assets..."
npm run build
if [ $? -eq 0 ]; then
    echo "✅ Assets built successfully"
else
    echo "❌ Asset build failed"
    exit 1
fi

# Step 2: Check if all required files exist
echo ""
echo "2. Verifying required files..."

required_files=(
    "index.php"
    ".htaccess"
    "public/build/manifest.json"
    "vendor/livewire/livewire/dist/livewire.min.js"
)

for file in "${required_files[@]}"; do
    if [ -f "$file" ]; then
        echo "✅ $file exists"
    else
        echo "❌ $file missing - deployment may fail"
    fi
done

# Step 3: Add changes to git
echo ""
echo "3. Adding changes to git..."
git add .htaccess azure-root-setup.sh index.php

# Step 4: Show what will be committed
echo ""
echo "4. Changes to be committed:"
git status --porcelain

# Step 5: Commit with descriptive message
echo ""
echo "5. Committing changes..."
git commit -m "Fix routing issues for all pages

- Updated index.php to properly handle Laravel requests
- Enhanced .htaccess with comprehensive routing rules
- Improved routing verification in azure-root-setup.sh
- Added route cache clearing steps
- Should resolve 404 errors on login and other pages"

# Step 6: Push to trigger Azure deployment
echo ""
echo "6. Pushing to Azure..."
git push origin main

echo ""
echo "🚀 Route fix deployment initiated!"
echo ""
echo "This fix addresses:"
echo "✅ 404 errors on /login and other pages"
echo "✅ Proper Laravel routing from root directory"
echo "✅ Route cache handling"
echo "✅ Request handling in index.php"
echo ""
echo "Wait 2-3 minutes, then test these URLs:"
echo "1. 🔗 Homepage: https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net/"
echo "2. 🔗 Login: https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net/login"
echo "3. 🔗 Register: https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net/register"
echo "4. 🔗 Dashboard: https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net/dashboard"
echo ""
echo "Expected results:"
echo "✅ All pages should load without 404 errors"
echo "✅ Login and registration should work"
echo "✅ Navigation between pages should work"
echo "✅ All assets should load correctly"
