#!/bin/bash

echo "Complete Asset Deployment Fix"
echo "============================="
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
    "public/build/manifest.json"
    "vendor/livewire/livewire/dist/livewire.min.js"
    ".htaccess"
    "azure-root-setup.sh"
)

for file in "${required_files[@]}"; do
    if [ -f "$file" ]; then
        echo "✅ $file exists"
    else
        echo "❌ $file missing - deployment may fail"
    fi
done

# Step 3: Add all changes to git
echo ""
echo "3. Adding changes to git..."
git add .

# Step 4: Show what will be committed
echo ""
echo "4. Changes to be committed:"
git status --porcelain

# Step 5: Commit with descriptive message
echo ""
echo "5. Committing changes..."
git commit -m "Fix CSS and JS 404 errors - Complete public assets deployment

- Move ALL public/ contents to wwwroot root directory
- Update .htaccess with proper static asset serving rules
- Ensure build/ directory and Livewire assets are accessible
- Add comprehensive asset verification in azure-root-setup.sh
- Build fresh frontend assets with updated file names
- Add caching headers for better performance

Resolves:
- app-*.css 404 errors
- livewire.min.js 404 errors
- Static asset serving from root directory"

# Step 6: Push to trigger Azure deployment
echo ""
echo "6. Pushing to Azure..."
git push origin main

echo ""
echo "🚀 Deployment initiated!"
echo ""
echo "This fix addresses:"
echo "✅ Moves all public/ contents to root"
echo "✅ Updates .htaccess for static asset serving"
echo "✅ Ensures build/ and Livewire assets are accessible"
echo "✅ Adds verification steps"
echo ""
echo "Wait 2-3 minutes, then test:"
echo "🔗 https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net/"
echo ""
echo "Expected results:"
echo "✅ No more CSS 404 errors"
echo "✅ No more Livewire JS 404 errors"
echo "✅ Properly styled homepage"
echo "✅ Working navigation"
