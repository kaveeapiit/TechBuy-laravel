# Azure Environment Variables Configuration

Since you're using Azure environment variables instead of .env files (which is the correct approach for security), here are the environment variables you need to configure in your Azure App Service:

## 🔧 Required Azure Environment Variables

### **Core Application Settings**
```
APP_NAME=TechBuy
APP_ENV=production
APP_DEBUG=false
APP_URL=https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net
APP_KEY=base64:fkv9/ejk+0sy83+cXjimjCDVluBCh8f2QhLwySsb7CE=
```

### **PostgreSQL Database (Primary)**
```
DB_CONNECTION=pgsql
DB_HOST=[Your Azure PostgreSQL Server Host]
DB_PORT=5432
DB_DATABASE=[Your PostgreSQL Database Name]
DB_USERNAME=[Your PostgreSQL Username]
DB_PASSWORD=[Your PostgreSQL Password]
```

### **MongoDB Configuration**
```
MONGODB_HOST=[Your Azure MongoDB Host]
MONGODB_PORT=27017
MONGODB_DATABASE=[Your MongoDB Database Name]
MONGODB_USERNAME=[Your MongoDB Username]
MONGODB_PASSWORD=[Your MongoDB Password]
```

### **Session & Cache**
```
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_DOMAIN=.azurewebsites.net
CACHE_STORE=database
QUEUE_CONNECTION=database
```

### **Other Settings**
```
LOG_CHANNEL=stack
LOG_LEVEL=error
FILESYSTEM_DISK=public
MAIL_MAILER=log
BCRYPT_ROUNDS=12
```

## 🚀 How to Set These in Azure

1. **Azure Portal Method:**
   - Go to your App Service
   - Settings → Configuration
   - Application settings
   - Add each variable

2. **Azure CLI Method:**
   ```bash
   az webapp config appsettings set --resource-group [your-resource-group] --name techbuy-webapp-agbgf2gbgud8apaw --settings \
   APP_NAME="TechBuy" \
   APP_ENV="production" \
   APP_DEBUG="false" \
   DB_CONNECTION="pgsql" \
   DB_HOST="[your-postgresql-host]" \
   # ... add all other variables
   ```

## 🗄️ Database Connection Strings

For Azure, you might also want to use connection string format:

**PostgreSQL Connection String:**
```
postgresql://username:password@host:5432/database?sslmode=require
```

**MongoDB Connection String:**
```
mongodb://username:password@host:27017/database
```

## ⚠️ Important Notes

1. **Never commit .env files** - You're doing this correctly!
2. **Use Azure Key Vault** for sensitive data in production
3. **SSL/TLS** should be enabled for database connections
4. **Restart** the App Service after changing environment variables

## 🧪 Testing Database Connections

Once configured, the startup script will:
1. Run migrations: `php artisan migrate:fresh --force`
2. Seed data: `php artisan db:seed --force`
3. Test connections and show counts

If databases are still empty after deployment, check the Azure logs for connection errors.