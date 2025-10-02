# Azure App Service Configuration for MongoDB Support

## Environment Variables (set in Azure Portal)

```
MONGODB_CONNECTION_STRING=mongodb://[username]:[password]@[host]:[port]/[database]
MONGODB_DATABASE=techbuy_mongodb
DB_CONNECTION_MONGODB=mongodb
```

## App Service Settings (Configuration > General Settings)

### Startup Command

```
/home/site/wwwroot/startup.sh
```

### Application Settings (Key-Value pairs)

-   `MONGODB_CONNECTION_STRING`: Your Azure Cosmos DB MongoDB connection string
-   `MONGODB_DATABASE`: techbuy_mongodb
-   `DB_CONNECTION_MONGODB`: mongodb
-   `WEBSITES_ENABLE_APP_SERVICE_STORAGE`: true
-   `SCM_DO_BUILD_DURING_DEPLOYMENT`: true

## Azure Cosmos DB MongoDB API Setup

1. **Create Cosmos DB Account**

    - API: Azure Cosmos DB for MongoDB
    - Consistency Level: Session (default)
    - Enable multi-region writes: No (for cost optimization)

2. **Get Connection String**

    - Go to Cosmos DB > Settings > Connection String
    - Copy the "Primary Connection String"
    - Format: `mongodb://accountname:password@accountname.mongo.cosmos.azure.com:10255/databasename?ssl=true&replicaSet=globaldb&retrywrites=false&maxIdleTimeMS=120000&appName=@accountname@`

3. **Database Configuration**
    - Database Name: `techbuy_mongodb`
    - Collection: `pre_orders` (auto-created by Laravel)

## Troubleshooting Commands

### Check PHP Extensions on Azure

```bash
# SSH into App Service and run:
php -m | grep mongodb
```

### Test MongoDB Connection

```bash
# Create test script in wwwroot:
php -r "
try {
    \$manager = new MongoDB\Driver\Manager(getenv('MONGODB_CONNECTION_STRING'));
    \$command = new MongoDB\Driver\Command(['ping' => 1]);
    \$result = \$manager->executeCommand('admin', \$command);
    echo 'MongoDB Connection: SUCCESS\n';
} catch (Exception \$e) {
    echo 'MongoDB Connection: FAILED - ' . \$e->getMessage() . '\n';
}
"
```

### Alternative: Force Restart App Service

After deploying startup script:

1. Go to Azure Portal > App Service
2. Click "Restart"
3. Monitor "Log stream" for startup script execution

## Laravel MongoDB Configuration Check

Ensure your `config/database.php` has:

```php
'mongodb' => [
    'driver' => 'mongodb',
    'host' => env('DB_HOST_MONGODB', '127.0.0.1'),
    'port' => env('DB_PORT_MONGODB', 27017),
    'database' => env('DB_DATABASE_MONGODB', 'techbuy_mongodb'),
    'username' => env('DB_USERNAME_MONGODB', ''),
    'password' => env('DB_PASSWORD_MONGODB', ''),
    'options' => [
        'database' => env('DB_AUTHENTICATION_DATABASE_MONGODB', 'admin'),
        'ssl' => env('MONGODB_SSL', true),
    ],
    'dsn' => env('MONGODB_CONNECTION_STRING'),
],
```
