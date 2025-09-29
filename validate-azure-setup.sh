#!/bin/bash

# Azure Deployment Validation Script
# Run this to validate your environment configuration

echo "🔍 TechBuy Azure Deployment Validation"
echo "======================================"

# Check if we're in the right directory
if [ ! -f "composer.json" ]; then
    echo "❌ Error: Not in Laravel project directory"
    exit 1
fi

echo "✅ Laravel project directory confirmed"

# Check if .env.production exists
if [ -f ".env.production" ]; then
    echo "✅ .env.production file exists"
    
    # Check for required environment variables
    echo ""
    echo "📋 Environment Configuration Check:"
    echo "-----------------------------------"
    
    # Check APP_KEY
    if grep -q "APP_KEY=base64:" .env.production; then
        echo "✅ APP_KEY is configured"
    else
        echo "❌ APP_KEY is missing or invalid"
    fi
    
    # Check Database settings
    if grep -q "DB_HOST=techbuy-postgres-server" .env.production; then
        echo "✅ PostgreSQL configuration found"
    else
        echo "❌ PostgreSQL configuration missing"
    fi
    
    # Check MongoDB settings
    if grep -q "MONGODB_CONNECTION=" .env.production; then
        echo "✅ MongoDB configuration found"
    else
        echo "❌ MongoDB configuration missing"
    fi
    
    # Check APP_URL
    if grep -q "APP_URL=https://techbuy-webapp" .env.production; then
        echo "✅ Azure App URL configured"
    else
        echo "❌ Azure App URL missing"
    fi
    
    # Check production settings
    if grep -q "APP_ENV=production" .env.production && grep -q "APP_DEBUG=false" .env.production; then
        echo "✅ Production settings configured"
    else
        echo "❌ Production settings need attention"
    fi
    
else
    echo "❌ .env.production file not found"
fi

# Check if built assets exist
if [ -d "public/build" ] && [ -f "public/build/manifest.json" ]; then
    echo "✅ Frontend assets are built"
else
    echo "⚠️  Frontend assets not found - run 'npm run build'"
fi

# Check composer dependencies
if [ -d "vendor" ] && [ -f "vendor/autoload.php" ]; then
    echo "✅ Composer dependencies installed"
else
    echo "❌ Composer dependencies missing - run 'composer install --no-dev'"
fi

# Check helper scripts
if [ -f "azure-laravel-setup.php" ] && [ -f "azure-startup.sh" ]; then
    echo "✅ Azure helper scripts present"
else
    echo "❌ Azure helper scripts missing"
fi

echo ""
echo "🚀 Next Steps:"
echo "-------------"
echo "1. Ensure all ✅ items are checked"
echo "2. Go to Azure Portal → App Service → Configuration"
echo "3. Add all environment variables from .env.production"
echo "4. Test your application at: https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net"
echo ""
echo "🔗 Useful URLs:"
echo "- App Service: https://portal.azure.com/#resource/subscriptions/[your-subscription]/resourceGroups/techbuy-rg/providers/Microsoft.Web/sites/techbuy-webapp"
echo "- Database: https://portal.azure.com/#resource/subscriptions/[your-subscription]/resourceGroups/techbuy-rg/providers/Microsoft.DBforPostgreSQL/flexibleServers/techbuy-postgres-server"
echo "- Cosmos DB: https://portal.azure.com/#resource/subscriptions/[your-subscription]/resourceGroups/techbuy-rg/providers/Microsoft.DocumentDB/databaseAccounts/techbuy-cosmos-mongo"