#!/bin/bash

echo "🚀 Azure MongoDB Deployment Fix"
echo "================================"

log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1"
}

log "🔧 Deploying MongoDB extension and configuration fixes..."

# Step 1: Deploy updated files
log "📁 Deploying updated files..."

# Ensure startup script is executable
chmod +x startup.sh
chmod +x install-mongodb-extension.sh

log "✅ Files deployed and permissions set"

# Step 2: Create Azure-specific environment template
log "📋 Creating Azure environment template..."

cat > .env.azure.template << 'EOF'
# Azure App Service Environment Variables
# Copy these to Azure Portal > App Service > Configuration > Application Settings

# Database Configuration (PostgreSQL)
DB_CONNECTION=pgsql
DB_HOST=your-postgres-server.postgres.database.azure.com
DB_PORT=5432
DB_DATABASE=your-database-name
DB_USERNAME=your-username
DB_PASSWORD=your-password

# MongoDB Configuration (Cosmos DB)
MONGODB_CONNECTION_STRING=mongodb://your-cosmos-account:your-primary-key@your-cosmos-account.mongo.cosmos.azure.com:10255/your-database?ssl=true&replicaSet=globaldb&retrywrites=false&maxIdleTimeMS=120000&appName=@your-cosmos-account@
MONGODB_DATABASE=techbuy_mongodb
MONGODB_SSL=true
MONGODB_REPLICA_SET=globaldb
MONGODB_RETRY_WRITES=false
MONGODB_MAX_IDLE_TIME=120000

# App Configuration
APP_NAME="TechBuy"
APP_ENV=production
APP_KEY=base64:your-app-key-here
APP_DEBUG=false
APP_TIMEZONE=UTC
APP_URL=https://your-app-name.azurewebsites.net

# Session and Cache
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync

# File Storage
FILESYSTEM_DISK=public
AZURE_STORAGE_CONNECTION_STRING=your-storage-connection-string

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@your-domain.com
MAIL_FROM_NAME="TechBuy"
EOF

log "✅ Azure environment template created (.env.azure.template)"

# Step 3: Create deployment verification script
log "🔍 Creating deployment verification script..."

cat > verify-azure-deployment.sh << 'EOF'
#!/bin/bash

echo "🔍 Azure Deployment Verification"
echo "================================"

# Check PHP version
echo "📋 PHP Version:"
php --version

echo ""
echo "📋 PHP Extensions:"
php -m | grep -E "(mongodb|pdo|pgsql|openssl)"

echo ""
echo "📋 Environment Variables Check:"
echo "MONGODB_CONNECTION_STRING: ${MONGODB_CONNECTION_STRING:0:20}..."
echo "MONGODB_DATABASE: $MONGODB_DATABASE"
echo "DB_CONNECTION: $DB_CONNECTION"

echo ""
echo "🔌 Testing MongoDB Connection:"
php -r "
try {
    if (extension_loaded('mongodb')) {
        echo '✅ MongoDB extension loaded\n';

        if (getenv('MONGODB_CONNECTION_STRING')) {
            \$manager = new MongoDB\Driver\Manager(getenv('MONGODB_CONNECTION_STRING'));
            \$command = new MongoDB\Driver\Command(['ping' => 1]);
            \$result = \$manager->executeCommand('admin', \$command);
            echo '✅ MongoDB connection successful\n';
        } else {
            echo '❌ MONGODB_CONNECTION_STRING not set\n';
        }
    } else {
        echo '❌ MongoDB extension not loaded\n';
    }
} catch (Exception \$e) {
    echo '❌ MongoDB connection failed: ' . \$e->getMessage() . '\n';
}
"

echo ""
echo "🔌 Testing PostgreSQL Connection:"
php -r "
try {
    if (extension_loaded('pdo_pgsql')) {
        echo '✅ PostgreSQL extension loaded\n';

        \$host = getenv('DB_HOST');
        \$dbname = getenv('DB_DATABASE');
        \$username = getenv('DB_USERNAME');
        \$password = getenv('DB_PASSWORD');

        if (\$host && \$dbname && \$username) {
            \$dsn = \"pgsql:host=\$host;dbname=\$dbname\";
            \$pdo = new PDO(\$dsn, \$username, \$password);
            echo '✅ PostgreSQL connection successful\n';
        } else {
            echo '❌ PostgreSQL environment variables not complete\n';
        }
    } else {
        echo '❌ PostgreSQL extension not loaded\n';
    }
} catch (Exception \$e) {
    echo '❌ PostgreSQL connection failed: ' . \$e->getMessage() . '\n';
}
"

echo ""
echo "📁 Laravel Configuration:"
cd /home/site/wwwroot
php artisan config:show database.connections.mongodb 2>/dev/null || echo "❌ MongoDB config not accessible"
php artisan config:show database.connections.pgsql 2>/dev/null || echo "❌ PostgreSQL config not accessible"

echo ""
echo "🎯 Verification Complete!"
EOF

chmod +x verify-azure-deployment.sh

log "✅ Verification script created"

# Step 4: Update composer.json to ensure MongoDB package is included
log "📦 Ensuring MongoDB composer package..."

if ! grep -q "mongodb/laravel-mongodb" composer.json; then
    log "📦 Adding MongoDB Laravel package to composer.json..."
    composer require mongodb/laravel-mongodb --no-update
fi

log "✅ Composer dependencies verified"

# Step 5: Create deployment summary
log "📄 Creating deployment summary..."

cat > AZURE_DEPLOYMENT_CHECKLIST.md << 'EOF'
# Azure Deployment Checklist for MongoDB Support

## ✅ Files Updated
- [x] `startup.sh` - MongoDB extension installation
- [x] `config/database.php` - Azure Cosmos DB configuration
- [x] `install-mongodb-extension.sh` - Alternative extension installer
- [x] `verify-azure-deployment.sh` - Deployment verification

## 🔧 Azure Portal Configuration Required

### 1. App Service Settings
**Configuration > General Settings > Startup Command:**
```
/home/site/wwwroot/startup.sh
```

### 2. Environment Variables
**Configuration > Application Settings - Add these:**

| Key | Value | Description |
|-----|-------|-------------|
| `MONGODB_CONNECTION_STRING` | `mongodb://[account]:[key]@[account].mongo.cosmos.azure.com:10255/[db]?ssl=true&replicaSet=globaldb&retrywrites=false&maxIdleTimeMS=120000&appName=@[account]@` | Cosmos DB connection string |
| `MONGODB_DATABASE` | `techbuy_mongodb` | Database name |
| `MONGODB_SSL` | `true` | Enable SSL |
| `MONGODB_REPLICA_SET` | `globaldb` | Cosmos DB replica set |
| `MONGODB_RETRY_WRITES` | `false` | Disable retry writes for Cosmos DB |
| `SCM_DO_BUILD_DURING_DEPLOYMENT` | `true` | Enable build during deployment |
| `WEBSITES_ENABLE_APP_SERVICE_STORAGE` | `true` | Enable storage |

### 3. Cosmos DB MongoDB API Setup
1. Create Azure Cosmos DB account with MongoDB API
2. Create database: `techbuy_mongodb`
3. Copy connection string from Settings > Connection String
4. Add connection string to App Service environment variables

## 🚀 Deployment Steps

1. **Deploy code with updated files**
2. **Set environment variables in Azure Portal**
3. **Restart App Service**
4. **SSH into App Service and run verification:**
   ```bash
   cd /home/site/wwwroot
   ./verify-azure-deployment.sh
   ```

## 🔍 Troubleshooting

### If MongoDB extension fails to install:
```bash
# SSH into App Service
./install-mongodb-extension.sh
```

### If connection still fails:
1. Check Cosmos DB firewall settings (allow Azure services)
2. Verify connection string format
3. Check App Service logs: **Monitoring > Log stream**

### Test preorder functionality:
1. Visit: `https://your-app.azurewebsites.net/contact`
2. Submit a preorder
3. Check for success message

## 📞 Support Resources
- Azure App Service SSH: Portal > Development Tools > SSH
- Cosmos DB Metrics: Portal > Monitoring > Metrics
- App Service Logs: Portal > Monitoring > Log stream
EOF

log "✅ Deployment checklist created"

echo ""
echo "🎉 Azure MongoDB deployment fix complete!"
echo ""
echo "📋 Next Steps:"
echo "1. Deploy these updated files to Azure"
echo "2. Set environment variables in Azure Portal (see .env.azure.template)"
echo "3. Set startup command: /home/site/wwwroot/startup.sh"
echo "4. Restart your App Service"
echo "5. SSH into Azure and run: ./verify-azure-deployment.sh"
echo ""
echo "📁 Files created:"
echo "  - startup.sh (updated)"
echo "  - install-mongodb-extension.sh"
echo "  - verify-azure-deployment.sh"
echo "  - .env.azure.template"
echo "  - AZURE_DEPLOYMENT_CHECKLIST.md"
echo ""
echo "🔗 See AZURE_DEPLOYMENT_CHECKLIST.md for detailed instructions"
