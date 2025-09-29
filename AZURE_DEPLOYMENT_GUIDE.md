# Complete Azure Deployment Guide for TechBuy Laravel Application

This comprehensive guide will walk you through deploying your Laravel TechBuy application to Microsoft Azure, including both database backends (PostgreSQL and MongoDB), frontend assets, and all necessary configurations.

## Table of Contents

1. [Prerequisites](#prerequisites)
2. [Azure Account Setup](#azure-account-setup)
3. [Create Azure Resources](#create-azure-resources)
4. [Database Setup](#database-setup)
5. [Prepare Your Application](#prepare-your-application)
6. [Deploy to Azure App Service](#deploy-to-azure-app-service)
7. [Configure Environment Variables](#configure-environment-variables)
8. [Domain and SSL Setup](#domain-and-ssl-setup)
9. [Monitoring and Scaling](#monitoring-and-scaling)
10. [Troubleshooting](#troubleshooting)

## Prerequisites

Before starting, ensure you have:

-   A computer with internet connection
-   Basic understanding of using terminal/command line
-   Your Laravel TechBuy application code
-   A GitHub account (for deployment)

## Azure Account Setup

### Step 1: Create Azure Account

1. Go to [https://azure.microsoft.com/](https://azure.microsoft.com/)
2. Click "Start free" or "Create account"
3. Follow the registration process:
    - Enter your email address
    - Verify your phone number
    - Provide credit card details (won't be charged during free tier)
    - Complete identity verification

### Step 2: Access Azure Portal

1. Go to [https://portal.azure.com/](https://portal.azure.com/)
2. Sign in with your Azure account
3. You'll see the Azure dashboard

### Step 3: Create a Resource Group

1. In the Azure portal, click "Create a resource"
2. Search for "Resource group" and select it
3. Click "Create"
4. Fill in the details:
    - **Subscription**: Select your subscription
    - **Resource group name**: `techbuy-rg`
    - **Region**: Choose closest to your users (e.g., "East US", "West Europe")
5. Click "Review + Create" then "Create"

## Create Azure Resources

### Step 4: Create App Service Plan

1. In Azure portal, click "Create a resource"
2. Search for "App Service Plan" and select it
3. Click "Create"
4. Configure:
    - **Subscription**: Your subscription
    - **Resource Group**: Select `techbuy-rg`
    - **Name**: `techbuy-app-plan`
    - **Operating System**: Linux
    - **Region**: Same as your resource group
    - **Pricing Tier**: Start with "Basic B1" (can upgrade later)
5. Click "Review + Create" then "Create"

### Step 5: Create App Service (Web App)

1. Click "Create a resource"
2. Search for "Web App" and select it
3. Click "Create"
4. Configure:
    - **Subscription**: Your subscription
    - **Resource Group**: `techbuy-rg`
    - **Name**: `techbuy-webapp` (this will be your URL: techbuy-webapp.azurewebsites.net)
    - **Publish**: Code
    - **Runtime stack**: PHP 8.2
    - **Operating System**: Linux
    - **Region**: Same as resource group
    - **App Service Plan**: Select `techbuy-app-plan`
5. Click "Review + Create" then "Create"

## Database Setup

### Step 6: Create PostgreSQL Database

1. Click "Create a resource"
2. Search for "Azure Database for PostgreSQL" and select "Flexible Server"
3. Click "Create"
4. Configure:
    - **Subscription**: Your subscription
    - **Resource Group**: `techbuy-rg`
    - **Server name**: `techbuy-postgres-server`
    - **Region**: Same as resource group
    - **PostgreSQL version**: 15
    - **Workload type**: Development
    - **Compute + Storage**: Keep default (Burstable, B1ms)
    - **Administrator account**:
        - Username: `techbuyadmin`
        - Password: Create a strong password (e.g., `TechBuy2024!`)
    - **Networking**:
        - Select "Allow public access from any Azure service within Azure"
        - Check "Allow public access from the internet"
5. Click "Review + Create" then "Create"

### Step 7: Create MongoDB (Cosmos DB)

1. Click "Create a resource"
2. Search for "Azure Cosmos DB" and select it
3. Click "Create"
4. Select "MongoDB" API
5. Configure:
    - **Subscription**: Your subscription
    - **Resource Group**: `techbuy-rg`
    - **Account name**: `techbuy-cosmos-mongo`
    - **Location**: Same as resource group
    - **Capacity mode**: Provisioned throughput
    - **Apply Free Tier Discount**: Yes (if available)
    - **Limit total account throughput**: Check this
6. Click "Review + Create" then "Create"

### Step 8: Configure Database Access

#### For PostgreSQL:

1. Go to your PostgreSQL server in Azure portal
2. Click "Networking" in the left menu
3. Under "Firewall rules", add a new rule:
    - **Rule name**: `AllowAllAzure`
    - **Start IP**: `0.0.0.0`
    - **End IP**: `0.0.0.0`
4. Add another rule for your current IP:
    - **Rule name**: `MyIP`
    - **Start IP**: Your current IP (you can find this by googling "what is my ip")
    - **End IP**: Same as start IP
5. Click "Save"

#### For MongoDB (Cosmos DB):

1. Go to your Cosmos DB account
2. Click "Networking" in the left menu
3. Select "All networks" for now (you can restrict this later)
4. Click "Save"

## Prepare Your Application

### Step 9: Prepare Local Environment

1. Open Terminal (Mac/Linux) or Command Prompt (Windows)
2. Navigate to your project directory:
    ```bash
    cd /path/to/your/techbuy-laravel
    ```

### Step 10: Install Dependencies

```bash
# Install PHP dependencies
composer install --optimize-autoloader --no-dev

# Install Node.js dependencies
npm install

# Build frontend assets
npm run build
```

### Step 11: Create Production Environment File

1. Copy your `.env.example` to `.env.production`:
    ```bash
    cp .env.example .env.production
    ```
2. Edit `.env.production` with production settings (we'll fill this in later)

### Step 12: Push Code to GitHub

If your code isn't already on GitHub:

1. Initialize git repository:

    ```bash
    git init
    git add .
    git commit -m "Initial commit"
    ```

2. Create a new repository on GitHub:

    - Go to [github.com](https://github.com)
    - Click "New repository"
    - Name it "techbuy-laravel"
    - Don't initialize with README (since you already have code)
    - Click "Create repository"

3. Connect and push:
    ```bash
    git remote add origin https://github.com/yourusername/techbuy-laravel.git
    git branch -M main
    git push -u origin main
    ```

## Deploy to Azure App Service

### Step 13: Configure Deployment

1. Go to your App Service in Azure portal (`techbuy-webapp`)
2. Click "Deployment Center" in the left menu
3. Choose "GitHub" as source
4. Authorize GitHub connection
5. Select your repository and branch (main)
6. Build provider: "GitHub Actions"
7. Click "Save"

### Step 14: Configure PHP Settings

1. In your App Service, go to "Configuration" → "General settings"
2. Set:
    - **Stack**: PHP
    - **Major version**: 8
    - **Minor version**: 8.2
    - **Startup Command**: Leave empty for now
3. Click "Save"

### Step 15: Add Application Settings (Environment Variables)

1. In App Service, go to "Configuration" → "Application settings"
2. Add these settings one by one (click "New application setting" for each):

#### Basic Laravel Settings:

-   **Name**: `APP_NAME`, **Value**: `TechBuy`
-   **Name**: `APP_ENV`, **Value**: `production`
-   **Name**: `APP_DEBUG`, **Value**: `false`
-   **Name**: `APP_URL`, **Value**: `https://techbuy-webapp.azurewebsites.net`
-   **Name**: `APP_KEY`, **Value**: Generate this later

#### Database Settings (PostgreSQL):

Get these values from your PostgreSQL server:

1. Go to your PostgreSQL server in Azure portal
2. Click "Connection strings" to get the values

-   **Name**: `DB_CONNECTION`, **Value**: `pgsql`
-   **Name**: `DB_HOST`, **Value**: `techbuy-postgres-server.postgres.database.azure.com`
-   **Name**: `DB_PORT`, **Value**: `5432`
-   **Name**: `DB_DATABASE`, **Value**: `postgres`
-   **Name**: `DB_USERNAME`, **Value**: `techbuyadmin`
-   **Name**: `DB_PASSWORD`, **Value**: Your PostgreSQL password

#### MongoDB Settings:

Get these from your Cosmos DB:

1. Go to Cosmos DB account
2. Click "Connection String" to get values

-   **Name**: `MONGODB_CONNECTION`, **Value**: Your MongoDB connection string
-   **Name**: `MONGODB_DATABASE`, **Value**: `techbuy_mongo`

#### Session and Cache:

-   **Name**: `SESSION_DRIVER`, **Value**: `database`
-   **Name**: `CACHE_DRIVER`, **Value**: `database`
-   **Name**: `QUEUE_CONNECTION`, **Value**: `database`

3. Click "Save" after adding all settings

### Step 16: Generate Application Key

⚠️ **If you encounter a "Please provide a valid cache path" error, use the alternative method below.**

**Method 1: Standard Approach**
1. In App Service, go to "Console" (under Development Tools)
2. Navigate to your app directory:
    ```bash
    cd /home/site/wwwroot
    ```
3. Generate the app key:
    ```bash
    php artisan key:generate --show
    ```
4. Copy the generated key
5. Go back to "Configuration" → "Application settings"
6. Update `APP_KEY` with the generated key (including `base64:` prefix)
7. Click "Save"

**Method 2: Alternative Approach (Use if Method 1 fails)**
If you get a cache path error, use our helper script:

1. In the Azure Console, navigate to your app directory:
    ```bash
    cd /home/site/wwwroot
    ```
2. Run the Laravel setup script:
    ```bash
    php azure-laravel-setup.php
    ```
3. This script will:
   - Create necessary cache directories
   - Generate an application key automatically
   - Set up proper permissions
4. Check the generated key:
    ```bash
    grep APP_KEY .env
    ```
5. Copy the key (including `base64:` prefix)
6. Go to "Configuration" → "Application settings"
7. Update `APP_KEY` with the generated key
8. Click "Save"

**Method 3: Manual Key Generation (Last Resort)**
If both methods above fail:

1. Generate a key locally on your computer:
    ```bash
    php -r "echo 'base64:' . base64_encode(random_bytes(32)) . PHP_EOL;"
    ```
2. Copy the generated key
3. Go to Azure → "Configuration" → "Application settings"
4. Update `APP_KEY` with the generated key
5. Click "Save"

### Step 17: Run Database Migrations

1. In the Console, run:
    ```bash
    php artisan migrate --force
    ```
2. If you have seeders:
    ```bash
    php artisan db:seed --force
    ```

## Configure Web Server

### Step 18: Configure Document Root

1. Create a `.htaccess` file in your project root if it doesn't exist:

    ```bash
    # In your local project
    touch .htaccess
    ```

2. Add this content to `.htaccess`:

    ```apache
    RewriteEngine on
    RewriteCond %{REQUEST_URI} !^public
    RewriteRule ^(.*)$ public/$1 [L]
    ```

3. Commit and push the changes:
    ```bash
    git add .htaccess
    git commit -m "Add htaccess for Azure deployment"
    git push
    ```

### Step 19: Configure Startup Command

1. In App Service → Configuration → General settings
2. Set **Startup Command** to:
   ```bash
   bash /home/site/wwwroot/azure-startup.sh
   ```
   
   **Alternative (if bash doesn't work):**
   ```bash
   cd /home/site/wwwroot && php azure-laravel-setup.php && php artisan config:cache && php artisan route:cache && php artisan view:cache
   ```
   
   **Fallback (minimal setup):**
   ```bash
   cd /home/site/wwwroot && mkdir -p storage/framework/cache/data && mkdir -p storage/framework/sessions && mkdir -p storage/framework/views && mkdir -p bootstrap/cache && chmod -R 775 storage && cp .env.production .env
   ```
3. Click "Save"

## Final Configuration

### Step 20: Create Production Environment on Server

1. In App Service Console, create the production environment file:

    ```bash
    cd /home/site/wwwroot
    cp .env.example .env.production
    ```

2. The startup command will copy this to `.env` on each deployment.

### Step 21: Set Up File Storage

1. In App Service → Configuration → Application settings
2. Add:
    - **Name**: `FILESYSTEM_DISK`, **Value**: `local`

### Step 22: Configure Logging

Add these application settings:

-   **Name**: `LOG_CHANNEL`, **Value**: `errorlog`
-   **Name**: `LOG_LEVEL`, **Value**: `error`

## Domain and SSL Setup

### Step 23: Configure Custom Domain (Optional)

If you have a custom domain:

1. In App Service → Custom domains
2. Click "Add custom domain"
3. Enter your domain name
4. Follow the DNS configuration instructions
5. Azure will provide free SSL certificate

### Step 24: Force HTTPS

1. In App Service → TLS/SSL settings
2. Toggle "HTTPS Only" to "On"

## Testing Your Deployment

### Step 25: Test the Application

1. Go to your app URL: `https://techbuy-webapp.azurewebsites.net`
2. Test key functionality:
    - Homepage loads
    - User registration/login
    - Product browsing
    - Shopping cart functionality
    - Database operations work

### Step 26: Check Logs

If something doesn't work:

1. Go to App Service → Log stream
2. Watch for errors in real-time
3. Or go to "Diagnose and solve problems" for detailed analysis

## Monitoring and Scaling

### Step 27: Set Up Application Insights (Optional)

1. Create Application Insights resource
2. Connect it to your App Service
3. Monitor performance and errors

### Step 28: Configure Auto-scaling

1. In App Service Plan → Scale up (App Service plan)
2. Choose a pricing tier that supports auto-scaling
3. Go to Scale out (App Service plan)
4. Configure auto-scaling rules based on CPU, memory, or requests

## Backup and Security

### Step 29: Set Up Backups

1. In App Service → Backups
2. Configure automatic backups
3. Set backup schedule and retention

### Step 30: Security Best Practices

1. Enable Azure Security Center recommendations
2. Regular update dependencies
3. Use Azure Key Vault for sensitive configuration
4. Set up network security groups if needed

## Maintenance

### Step 31: Regular Maintenance Tasks

1. Monitor application performance
2. Update dependencies regularly
3. Review and rotate secrets
4. Monitor costs in Azure Cost Management
5. Review security recommendations

## Troubleshooting Common Issues

### Issue 1: "Please provide a valid cache path" Error

**Error Message:**
```
InvalidArgumentException: Please provide a valid cache path.
```

**Solution:**
This error occurs when Laravel can't access or create cache directories. Follow these steps:

1. **Use the Azure setup script** (Recommended):
   ```bash
   cd /home/site/wwwroot
   php azure-laravel-setup.php
   ```

2. **Manual directory creation**:
   ```bash
   cd /home/site/wwwroot
   mkdir -p storage/framework/cache/data
   mkdir -p storage/framework/sessions
   mkdir -p storage/framework/views
   mkdir -p bootstrap/cache
   chmod -R 775 storage
   chmod -R 775 bootstrap/cache
   ```

3. **Clear caches**:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

4. **Set environment variables in Azure** (not in console):
   - Go to Configuration → Application settings
   - Manually add `APP_KEY` with a generated value
   - Use: `php -r "echo 'base64:' . base64_encode(random_bytes(32)) . PHP_EOL;"`

### Issue 2: 500 Internal Server Error

**Solution:**

1. Check App Service logs
2. Verify all environment variables are set correctly
3. Ensure database migrations ran successfully
4. Check file permissions

### Issue 3: Database Connection Failed

**Solution:**

1. Verify database server is running
2. Check firewall rules allow App Service IP
3. Verify connection strings are correct
4. Test database connectivity from Console

### Issue 4: Assets Not Loading

**Solution:**

1. Ensure `npm run build` was executed
2. Check if public folder has compiled assets
3. Verify `APP_URL` is set correctly

### Issue 5: Session/Cache Issues

**Solution:**

1. Run `php artisan config:clear`
2. Verify session and cache drivers are supported
3. Check database has required tables

## Cost Optimization Tips

1. **Start Small**: Begin with Basic tier, upgrade as needed
2. **Monitor Usage**: Use Azure Cost Management
3. **Auto-shutdown**: Configure auto-shutdown for development environments
4. **Reserved Instances**: For production, consider reserved instances for savings
5. **Clean Up**: Remove unused resources regularly

## Next Steps After Deployment

1. Set up CI/CD pipeline for automated deployments
2. Configure monitoring and alerting
3. Set up staging environment
4. Implement backup and disaster recovery plan
5. Performance optimization
6. Security hardening

## Support Resources

-   [Azure Documentation](https://docs.microsoft.com/en-us/azure/)
-   [Laravel Deployment Documentation](https://laravel.com/docs/deployment)
-   [Azure App Service Documentation](https://docs.microsoft.com/en-us/azure/app-service/)
-   [Azure Database for PostgreSQL Documentation](https://docs.microsoft.com/en-us/azure/postgresql/)

## Conclusion

You have successfully deployed your TechBuy Laravel application to Azure! Your application is now running in the cloud with:

-   ✅ Web application hosted on Azure App Service
-   ✅ PostgreSQL database for relational data
-   ✅ MongoDB (Cosmos DB) for document data
-   ✅ SSL certificate and HTTPS
-   ✅ Scalable infrastructure
-   ✅ Monitoring and logging

Remember to:

-   Monitor your application regularly
-   Keep dependencies updated
-   Review costs monthly
-   Follow security best practices

Your application should now be accessible at: `https://techbuy-webapp.azurewebsites.net`

For any issues or questions, refer to the troubleshooting section or Azure support documentation.
