# Azure Deployment Checklist for TechBuy Laravel App

Use this checklist to ensure you don't miss any steps during deployment.

## Pre-Deployment Checklist ✅

### Azure Account Setup

-   [ ] Create Azure account and verify
-   [ ] Access Azure Portal successfully
-   [ ] Create Resource Group (`techbuy-rg`)

### Azure Resources Creation

-   [ ] Create App Service Plan (`techbuy-app-plan`)
-   [ ] Create Web App (`techbuy-webapp`)
-   [ ] Create PostgreSQL Flexible Server (`techbuy-postgres-server`)
-   [ ] Create Cosmos DB with MongoDB API (`techbuy-cosmos-mongo`)

### Database Configuration

-   [ ] Configure PostgreSQL firewall rules
-   [ ] Configure Cosmos DB networking
-   [ ] Test database connections

### Code Preparation

-   [ ] Run `composer install --no-dev --optimize-autoloader`
-   [ ] Run `npm install && npm run build`
-   [ ] Push code to GitHub repository
-   [ ] Verify all files are committed

## Deployment Checklist ✅

### App Service Configuration

-   [ ] Set PHP version to 8.2
-   [ ] Configure deployment from GitHub
-   [ ] Set up GitHub Actions workflow
-   [ ] Add all environment variables:
    -   [ ] `APP_NAME` = TechBuy
    -   [ ] `APP_ENV` = production
    -   [ ] `APP_DEBUG` = false
    -   [ ] `APP_URL` = https://techbuy-webapp.azurewebsites.net
    -   [ ] `APP_KEY` = (generate using `php artisan key:generate --show`)
    -   [ ] `DB_CONNECTION` = pgsql
    -   [ ] `DB_HOST` = techbuy-postgres-server.postgres.database.azure.com
    -   [ ] `DB_PORT` = 5432
    -   [ ] `DB_DATABASE` = postgres
    -   [ ] `DB_USERNAME` = techbuyadmin
    -   [ ] `DB_PASSWORD` = (your PostgreSQL password)
    -   [ ] `MONGODB_CONNECTION` = (Cosmos DB connection string)
    -   [ ] `MONGODB_DATABASE` = techbuy_mongo
    -   [ ] `SESSION_DRIVER` = database
    -   [ ] `CACHE_DRIVER` = database
    -   [ ] `QUEUE_CONNECTION` = database
    -   [ ] `LOG_CHANNEL` = errorlog
    -   [ ] `LOG_LEVEL` = error

### Web Server Configuration

-   [ ] Create `.htaccess` file for URL rewriting
-   [ ] Set startup command
-   [ ] Configure document root

### Database Setup

-   [ ] Run migrations: `php artisan migrate --force`
-   [ ] Run seeders: `php artisan db:seed --force`
-   [ ] Verify database tables created

## Post-Deployment Checklist ✅

### Testing

-   [ ] Website loads successfully
-   [ ] Test user registration
-   [ ] Test user login
-   [ ] Test product browsing
-   [ ] Test shopping cart functionality
-   [ ] Test checkout process
-   [ ] Verify both databases working (PostgreSQL & MongoDB)

### Security Configuration

-   [ ] Enable HTTPS Only
-   [ ] Configure custom domain (if applicable)
-   [ ] Set up SSL certificate
-   [ ] Review firewall rules
-   [ ] Update SANCTUM_STATEFUL_DOMAINS

### Performance & Monitoring

-   [ ] Set up Application Insights (optional)
-   [ ] Configure auto-scaling rules
-   [ ] Set up log monitoring
-   [ ] Test application performance

### Backup & Maintenance

-   [ ] Configure automatic backups
-   [ ] Set up cost monitoring alerts
-   [ ] Document admin credentials securely
-   [ ] Create maintenance schedule

## Troubleshooting Quick Fixes ⚠️

### Common Issues and Solutions

**500 Internal Server Error:**

-   [ ] Check application logs in Azure Portal
-   [ ] Verify APP_KEY is set and valid
-   [ ] Ensure all required environment variables are set
-   [ ] Run `php artisan config:clear` in Console

**Database Connection Error:**

-   [ ] Verify database server is running
-   [ ] Check firewall rules allow App Service
-   [ ] Validate connection string format
-   [ ] Test connection from App Service Console

**Assets Not Loading:**

-   [ ] Ensure `npm run build` completed successfully
-   [ ] Check if `public/build` folder exists
-   [ ] Verify APP_URL matches actual domain

**Permission Errors:**

-   [ ] Check storage folder permissions
-   [ ] Verify bootstrap/cache folder permissions
-   [ ] Run storage:link if needed

## Environment Variables Reference Card 📋

Keep this handy during deployment:

```
APP_NAME=TechBuy
APP_ENV=production
APP_DEBUG=false
APP_URL=https://YOUR_APP_NAME.azurewebsites.net
APP_KEY=base64:GENERATED_KEY_HERE

DB_CONNECTION=pgsql
DB_HOST=YOUR_POSTGRES_SERVER.postgres.database.azure.com
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=YOUR_ADMIN_USERNAME
DB_PASSWORD=YOUR_STRONG_PASSWORD

MONGODB_CONNECTION=YOUR_COSMOS_CONNECTION_STRING
MONGODB_DATABASE=techbuy_mongo

SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database
LOG_CHANNEL=errorlog
```

## Important URLs to Bookmark 🔗

-   Azure Portal: https://portal.azure.com/
-   Your Web App: https://techbuy-webapp.azurewebsites.net
-   GitHub Repository: https://github.com/yourusername/techbuy-laravel
-   Azure Documentation: https://docs.microsoft.com/en-us/azure/

## Cost Management 💰

-   [ ] Monitor monthly costs in Azure Cost Management
-   [ ] Set up budget alerts
-   [ ] Review resource utilization regularly
-   [ ] Consider Reserved Instances for production

## Security Best Practices 🔒

-   [ ] Use strong passwords for all services
-   [ ] Enable two-factor authentication on Azure account
-   [ ] Regularly rotate database passwords
-   [ ] Keep Laravel and dependencies updated
-   [ ] Monitor security recommendations in Security Center

## Success Indicators ✨

Your deployment is successful when:

-   [ ] Application loads without errors
-   [ ] Users can register and login
-   [ ] Database operations work correctly
-   [ ] SSL certificate is active
-   [ ] Performance is acceptable
-   [ ] Logs show no critical errors

## Emergency Contacts & Resources 📞

-   Azure Support: Available in Azure Portal
-   Laravel Documentation: https://laravel.com/docs
-   Your GitHub Repository: (your-repo-url)
-   Database Admin Credentials: (store securely)

---

**🎉 Congratulations!**
Once all items are checked, your TechBuy Laravel application is successfully deployed on Azure!

**Next Steps:**

1. Share the URL with stakeholders
2. Set up monitoring and alerts
3. Plan for regular maintenance
4. Consider implementing CI/CD improvements
5. Monitor performance and optimize as needed
