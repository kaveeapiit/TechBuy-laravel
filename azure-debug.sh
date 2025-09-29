#!/bin/bash

# Azure Laravel Debug and Fix Script
echo "Running Laravel debug and fix..."

cd /home/site/wwwroot

# 1. Check if Laravel is working
echo "=== Testing Laravel Application ==="
php -r "echo 'PHP is working'; echo PHP_EOL;"

# 2. Check if .env exists and has correct settings
echo "=== Checking Environment Configuration ==="
if [ -f ".env" ]; then
    echo ".env file exists"
    grep "APP_KEY" .env | head -1
    grep "APP_ENV" .env | head -1
    grep "APP_DEBUG" .env | head -1
else
    echo "Creating .env from production template..."
    if [ -f ".env.production" ]; then
        cp .env.production .env
    else
        echo "No .env.production found, creating basic .env..."
        cat > .env << 'EOF'
APP_NAME="TechBuy"
APP_ENV=production
APP_KEY=base64:YMRnZxsVoTJ9EuRI6AnDY/H7euIVWAYbNLa+j8hGoMc=
APP_DEBUG=true
APP_URL=https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net

DB_CONNECTION=pgsql
DB_HOST=techbuy-postgres-server.postgres.database.azure.com
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=techbuyadmin
DB_PASSWORD=AmmoEka0102

LOG_CHANNEL=errorlog
SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database
EOF
    fi
fi

# 3. Test database connection
echo "=== Testing Database Connection ==="
php artisan tinker --execute="try { \DB::connection()->getPdo(); echo 'Database: Connected'; } catch(Exception \$e) { echo 'Database Error: ' . \$e->getMessage(); }"

# 4. Clear all caches
echo "=== Clearing Caches ==="
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# 5. Check routes
echo "=== Checking Routes ==="
php artisan route:list --path=/ | head -5

# 6. Test the home route specifically
echo "=== Testing Home Route ==="
php artisan tinker --execute="echo 'Testing route...'; try { \$response = app('router')->dispatch(request()->create('/')); echo 'Route works!'; } catch(Exception \$e) { echo 'Route Error: ' . \$e->getMessage(); }"

# 7. Check if views exist
echo "=== Checking Views ==="
ls -la resources/views/ | head -10

# 8. Try to render home view directly
echo "=== Testing Home View ==="
php artisan tinker --execute="try { echo view('home')->render(); echo 'View renders!'; } catch(Exception \$e) { echo 'View Error: ' . \$e->getMessage(); }"

# 9. Set proper permissions
chmod -R 775 storage bootstrap/cache

echo "=== Debug completed ==="
