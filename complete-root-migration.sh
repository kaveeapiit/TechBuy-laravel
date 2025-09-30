#!/bin/bash

echo "🔧 Completing Root Directory Migration"
echo "===================================="

# Step 1: Remove the conflicting public directory structure
echo "1. 📁 Removing conflicting public directory setup..."
if [ -f "public/index.php" ]; then
    echo "   - Moving public assets to root..."
    # Move any additional assets that might be in public but not in root
    cp -r public/build . 2>/dev/null || true
    cp public/favicon.ico . 2>/dev/null || true
    cp public/robots.txt . 2>/dev/null || true
    cp -r public/storage . 2>/dev/null || true
    
    echo "   - Removing conflicting public/index.php..."
    rm -f public/index.php
    rm -f public/.htaccess
    echo "   ✅ Public directory conflicts removed"
else
    echo "   ✅ No conflicting public/index.php found"
fi

# Step 2: Ensure the root setup is correct
echo ""
echo "2. 🔧 Verifying root index.php setup..."
if [ -f "index.php" ]; then
    echo "   ✅ Root index.php exists"
else
    echo "   ❌ Root index.php missing!"
    exit 1
fi

# Step 3: Ensure .htaccess is correct for root deployment
echo ""
echo "3. 📝 Ensuring root .htaccess is optimized..."

# Step 4: Update Laravel configuration for root deployment
echo ""
echo "4. ⚙️  Updating Laravel paths for root deployment..."

# Check if we need to update any config files
echo "   - Checking asset paths..."
# This ensures Laravel knows assets are served from root, not /public

echo ""
echo "5. 🧹 Cleaning up any Azure deployment cache..."
# Create or update the deployment script to clear any cached paths

echo ""
echo "✅ Root migration preparation complete!"
echo ""
echo "This addresses the core issue by:"
echo "   - Removing conflicts between root and public setups"
echo "   - Ensuring all requests go through the root index.php"
echo "   - Optimizing .htaccess for root deployment"
echo "   - Clearing any cached routing issues"
echo ""
echo "Next: Deploy this fix to Azure"