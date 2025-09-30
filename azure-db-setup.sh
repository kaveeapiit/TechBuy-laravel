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
    echo "Environment check:"
    echo "DB_HOST: ${DB_HOST:-'Not set'}"
    echo "DB_DATABASE: ${DB_DATABASE:-'Not set'}"
    echo "MONGODB_HOST: ${MONGODB_HOST:-'Not set'}"
    echo ""

    php artisan tinker --execute="
        try {
            echo 'Testing PostgreSQL connection...' . PHP_EOL;
            \$userCount = \App\Models\User::count();
            echo 'PostgreSQL Users: ' . \$userCount . PHP_EOL;

            echo 'Testing Product models...' . PHP_EOL;
            \$productCount = \App\Models\Product::count();
            echo 'Products: ' . \$productCount . PHP_EOL;

            echo 'Database connections successful!' . PHP_EOL;

        } catch (Exception \$e) {
            echo 'Database Error: ' . \$e->getMessage() . PHP_EOL;
            echo 'Check Azure environment variables for database connections' . PHP_EOL;
        }
    " 2>/dev/null || echo "❌ Database test failed - check environment variables"

    # Cache configurations for production
    echo "⚡ Optimizing for production..."
    php artisan config:cache 2>/dev/null || echo "Config cache skipped"
    php artisan route:cache 2>/dev/null || echo "Route cache skipped"
    php artisan view:cache 2>/dev/null || echo "View cache skipped"

    echo "✅ Azure database setup complete"
else
    echo "💻 Running locally - skipping Azure setup"
fi
