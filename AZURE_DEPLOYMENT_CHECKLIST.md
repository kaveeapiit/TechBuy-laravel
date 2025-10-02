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
