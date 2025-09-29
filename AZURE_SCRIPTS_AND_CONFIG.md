# Azure Deployment Scripts and Configurations

## GitHub Actions Workflow for Automated Deployment

Create this file at `.github/workflows/azure-deploy.yml`:

```yaml
name: Deploy to Azure App Service

on:
    push:
        branches:
            - main
    workflow_dispatch:

jobs:
    build-and-deploy:
        runs-on: ubuntu-latest

        steps:
            - name: "Checkout GitHub Action"
              uses: actions/checkout@v4

            - name: Setup PHP
              uses: shivammathur/setup-php@v2
              with:
                  php-version: "8.2"
                  extensions: mbstring, xml, ctype, iconv, intl, pdo_sqlite, pdo_mysql, pgsql, pdo_pgsql, mongodb
                  tools: composer:v2

            - name: Setup Node.js
              uses: actions/setup-node@v4
              with:
                  node-version: "20"
                  cache: "npm"

            - name: Install PHP Dependencies
              run: composer install --optimize-autoloader --no-dev

            - name: Install Node Dependencies
              run: npm ci

            - name: Build Assets
              run: npm run build

            - name: Create deployment package
              run: |
                  zip -r deployment.zip . -x "*.git*" "node_modules/*" "tests/*" "*.md"

            - name: Deploy to Azure Web App
              uses: azure/webapps-deploy@v2
              with:
                  app-name: "techbuy-webapp"
                  slot-name: "production"
                  publish-profile: ${{ secrets.AZURE_WEBAPP_PUBLISH_PROFILE }}
                  package: "deployment.zip"
```

## Production Environment Variables Template

Create `.env.azure` file with production-ready configuration:

```bash
# Application
APP_NAME="TechBuy"
APP_ENV=production
APP_KEY=base64:YOUR_GENERATED_KEY_HERE
APP_DEBUG=false
APP_URL=https://techbuy-webapp.azurewebsites.net

# Database (PostgreSQL)
DB_CONNECTION=pgsql
DB_HOST=techbuy-postgres-server.postgres.database.azure.com
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=techbuyadmin
DB_PASSWORD=YOUR_POSTGRES_PASSWORD

# MongoDB (Cosmos DB)
MONGODB_CONNECTION="YOUR_COSMOS_DB_CONNECTION_STRING"
MONGODB_DATABASE=techbuy_mongo

# Cache & Sessions
CACHE_DRIVER=database
SESSION_DRIVER=database
SESSION_LIFETIME=120
QUEUE_CONNECTION=database

# Mail Configuration (using Azure Communication Services or SendGrid)
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=YOUR_SENDGRID_API_KEY
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"

# Logging
LOG_CHANNEL=errorlog
LOG_LEVEL=error

# File Storage
FILESYSTEM_DISK=local

# Security
SANCTUM_STATEFUL_DOMAINS=techbuy-webapp.azurewebsites.net
SESSION_DOMAIN=.azurewebsites.net
```

## Azure CLI Deployment Script

Create `deploy-to-azure.sh` for command-line deployment:

```bash
#!/bin/bash

# Azure deployment script for TechBuy Laravel app
echo "Starting Azure deployment for TechBuy..."

# Variables - Update these with your actual values
RESOURCE_GROUP="techbuy-rg"
LOCATION="eastus"
APP_SERVICE_PLAN="techbuy-app-plan"
WEB_APP_NAME="techbuy-webapp"
POSTGRES_SERVER="techbuy-postgres-server"
COSMOS_ACCOUNT="techbuy-cosmos-mongo"
POSTGRES_ADMIN_USER="techbuyadmin"
POSTGRES_ADMIN_PASSWORD="TechBuy2024!"

# Login to Azure (comment out if already logged in)
echo "Logging into Azure..."
az login

# Create resource group
echo "Creating resource group..."
az group create --name $RESOURCE_GROUP --location $LOCATION

# Create App Service Plan
echo "Creating App Service Plan..."
az appservice plan create --name $APP_SERVICE_PLAN --resource-group $RESOURCE_GROUP --sku B1 --is-linux

# Create Web App
echo "Creating Web App..."
az webapp create --resource-group $RESOURCE_GROUP --plan $APP_SERVICE_PLAN --name $WEB_APP_NAME --runtime "PHP|8.2" --deployment-local-git

# Create PostgreSQL server
echo "Creating PostgreSQL server..."
az postgres flexible-server create \
  --resource-group $RESOURCE_GROUP \
  --name $POSTGRES_SERVER \
  --location $LOCATION \
  --admin-user $POSTGRES_ADMIN_USER \
  --admin-password $POSTGRES_ADMIN_PASSWORD \
  --sku-name Standard_B1ms \
  --tier Burstable \
  --version 15 \
  --storage-size 32 \
  --public-access 0.0.0.0

# Create Cosmos DB (MongoDB API)
echo "Creating Cosmos DB..."
az cosmosdb create \
  --resource-group $RESOURCE_GROUP \
  --name $COSMOS_ACCOUNT \
  --kind MongoDB \
  --locations regionName=$LOCATION \
  --enable-free-tier true

# Configure Web App settings
echo "Configuring Web App settings..."
az webapp config appsettings set --resource-group $RESOURCE_GROUP --name $WEB_APP_NAME --settings \
  APP_NAME="TechBuy" \
  APP_ENV="production" \
  APP_DEBUG="false" \
  APP_URL="https://$WEB_APP_NAME.azurewebsites.net" \
  DB_CONNECTION="pgsql" \
  DB_HOST="$POSTGRES_SERVER.postgres.database.azure.com" \
  DB_PORT="5432" \
  DB_DATABASE="postgres" \
  DB_USERNAME="$POSTGRES_ADMIN_USER" \
  DB_PASSWORD="$POSTGRES_ADMIN_PASSWORD" \
  SESSION_DRIVER="database" \
  CACHE_DRIVER="database" \
  QUEUE_CONNECTION="database" \
  LOG_CHANNEL="errorlog"

# Enable HTTPS only
echo "Enabling HTTPS only..."
az webapp update --resource-group $RESOURCE_GROUP --name $WEB_APP_NAME --https-only true

echo "Azure resources created successfully!"
echo "Web App URL: https://$WEB_APP_NAME.azurewebsites.net"
echo "Next steps:"
echo "1. Deploy your code using Git or GitHub Actions"
echo "2. Generate APP_KEY and update app settings"
echo "3. Run database migrations"
echo "4. Test your application"
```

## Docker Configuration (Alternative Deployment)

Create `Dockerfile` for containerized deployment:

```dockerfile
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    postgresql-dev \
    libzip-dev \
    oniguruma-dev

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_pgsql \
    pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip

# Install MongoDB extension
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js and npm
RUN apk add --no-cache nodejs npm

# Set working directory
WORKDIR /var/www/html

# Copy composer files
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy package.json files
COPY package.json package-lock.json ./

# Install Node dependencies
RUN npm ci --only=production

# Copy application code
COPY . .

# Build frontend assets
RUN npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Expose port
EXPOSE 8000

# Start application
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
```

## Health Check Script

Create `health-check.php` for monitoring:

```php
<?php
// Simple health check endpoint
header('Content-Type: application/json');

$status = [
    'status' => 'OK',
    'timestamp' => date('c'),
    'services' => []
];

try {
    // Check database connection
    $pdo = new PDO(
        'pgsql:host=' . $_ENV['DB_HOST'] . ';port=' . $_ENV['DB_PORT'] . ';dbname=' . $_ENV['DB_DATABASE'],
        $_ENV['DB_USERNAME'],
        $_ENV['DB_PASSWORD']
    );
    $status['services']['database'] = 'OK';
} catch (Exception $e) {
    $status['services']['database'] = 'ERROR';
    $status['status'] = 'ERROR';
}

// Check if storage is writable
if (is_writable(__DIR__ . '/storage')) {
    $status['services']['storage'] = 'OK';
} else {
    $status['services']['storage'] = 'ERROR';
    $status['status'] = 'ERROR';
}

http_response_code($status['status'] === 'OK' ? 200 : 500);
echo json_encode($status, JSON_PRETTY_PRINT);
?>
```

## Useful Azure CLI Commands

```bash
# Check deployment status
az webapp deployment list --name techbuy-webapp --resource-group techbuy-rg

# View application logs
az webapp log tail --name techbuy-webapp --resource-group techbuy-rg

# Scale the application
az appservice plan update --name techbuy-app-plan --resource-group techbuy-rg --sku P1V2

# Restart the web app
az webapp restart --name techbuy-webapp --resource-group techbuy-rg

# Get connection strings
az postgres flexible-server show-connection-string --server-name techbuy-postgres-server

# List all resources in resource group
az resource list --resource-group techbuy-rg --output table

# Delete everything (use with caution!)
az group delete --name techbuy-rg --yes
```

Remember to make the shell script executable:

```bash
chmod +x deploy-to-azure.sh
```
