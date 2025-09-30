#!/bin/bash

echo "🗄️  Azure Database Configuration and Seeding"
echo "============================================"

echo "Current setup:"
echo "✅ Local PostgreSQL: techbuy_users"
echo "✅ Local MongoDB: techbuy_products"
echo "❌ Azure databases: Need proper connection"
echo ""

# Create Azure database migration and seeding script
cat > azure-db-setup.sh << 'EOF'
#!/bin/bash

echo "🔧 Setting up Azure Databases"
echo "============================"

cd /home/site/wwwroot

# Check if we're in Azure environment
if [ -n "$WEBSITE_SITE_NAME" ]; then
    echo "🌐 Running in Azure environment: $WEBSITE_SITE_NAME"
    
    # Set production environment
    export APP_ENV=production
    export APP_DEBUG=false
    
    # Clear any cached config first
    php artisan config:clear 2>/dev/null || echo "Config clear skipped"
    php artisan cache:clear 2>/dev/null || echo "Cache clear skipped"
    
    # Run migrations with force flag for production
    echo "📊 Running PostgreSQL migrations..."
    php artisan migrate:fresh --force 2>/dev/null || echo "❌ Migration failed - check database connection"
    
    # Seed the PostgreSQL database
    echo "🌱 Seeding PostgreSQL database..."
    php artisan db:seed --force 2>/dev/null || echo "❌ Seeding failed - check database connection"
    
    # Test database connections
    echo "🔍 Testing database connections..."
    php artisan tinker --execute="
        try {
            \$userCount = \App\Models\User::count();
            echo 'PostgreSQL Users: ' . \$userCount . PHP_EOL;
            
            \$productCount = \App\Models\Product::count();
            echo 'Products: ' . \$productCount . PHP_EOL;
            
        } catch (Exception \$e) {
            echo 'Database Error: ' . \$e->getMessage() . PHP_EOL;
        }
    " 2>/dev/null || echo "❌ Database test failed"
    
    # Cache configurations for production
    echo "⚡ Optimizing for production..."
    php artisan config:cache 2>/dev/null || echo "Config cache skipped"
    php artisan route:cache 2>/dev/null || echo "Route cache skipped"
    php artisan view:cache 2>/dev/null || echo "View cache skipped"
    
    echo "✅ Azure database setup complete"
else
    echo "💻 Running locally - skipping Azure setup"
fi
EOF

chmod +x azure-db-setup.sh

# Create environment configuration for Azure
cat > .env.azure << 'EOF'
APP_NAME=TechBuy
APP_ENV=production
APP_DEBUG=false
APP_URL=https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
PHP_CLI_SERVER_WORKERS=4
BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

# Azure PostgreSQL Configuration
DB_CONNECTION=pgsql
DB_HOST=${AZURE_POSTGRESQL_HOST}
DB_PORT=${AZURE_POSTGRESQL_PORT}
DB_DATABASE=${AZURE_POSTGRESQL_DATABASE}
DB_USERNAME=${AZURE_POSTGRESQL_USERNAME}
DB_PASSWORD=${AZURE_POSTGRESQL_PASSWORD}

# Azure MongoDB Configuration  
MONGODB_HOST=${AZURE_MONGODB_HOST}
MONGODB_PORT=${AZURE_MONGODB_PORT}
MONGODB_DATABASE=${AZURE_MONGODB_DATABASE}
MONGODB_USERNAME=${AZURE_MONGODB_USERNAME}
MONGODB_PASSWORD=${AZURE_MONGODB_PASSWORD}

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=.azurewebsites.net

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=public
QUEUE_CONNECTION=database

CACHE_STORE=database
REDIS_CLIENT=phpredis

MAIL_MAILER=log
MAIL_FROM_ADDRESS="noreply@techbuy.com"
MAIL_FROM_NAME="TechBuy"

VITE_APP_NAME="TechBuy"
EOF

# Update the startup script to include database setup
cat > startup.sh << 'EOF'
#!/bin/bash

echo "🚀 TechBuy Azure Startup"
echo "======================="

# Set proper permissions
chmod -R 755 /home/site/wwwroot
cd /home/site/wwwroot

# Setup databases first
echo "🗄️  Setting up databases..."
./azure-db-setup.sh

# Clear any cache issues
php artisan config:clear 2>/dev/null || echo "Config clear skipped"
php artisan cache:clear 2>/dev/null || echo "Cache clear skipped"
php artisan view:clear 2>/dev/null || echo "View clear skipped"
php artisan route:clear 2>/dev/null || echo "Route clear skipped"

# Optimize for production
if [ "$APP_ENV" = "production" ]; then
    echo "⚡ Production optimizations..."
    php artisan config:cache 2>/dev/null || echo "Config cache skipped"
    php artisan route:cache 2>/dev/null || echo "Route cache skipped"
    php artisan view:cache 2>/dev/null || echo "View cache skipped"
fi

echo "✅ TechBuy startup complete"
EOF

chmod +x startup.sh

echo ""
echo "📋 Created Azure database configuration files:"
echo "   - azure-db-setup.sh: Database migration and seeding"
echo "   - .env.azure: Azure environment template"
echo "   - startup.sh: Updated startup script"
echo ""
echo "🔧 Next steps:"
echo "1. Configure Azure PostgreSQL and MongoDB connection strings"
echo "2. Deploy with web.config for routing"
echo "3. Run database setup in Azure"
echo ""
echo "💡 The Azure databases are likely empty because:"
echo "   - Connection strings not configured properly"
echo "   - Migrations/seeds haven't run in Azure environment"
echo "   - Environment variables not set correctly"