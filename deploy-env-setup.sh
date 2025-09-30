#!/bin/bash

echo "🔧 Updating Azure Environment Variables Setup"
echo "============================================"

echo "Changes made:"
echo "✅ Removed .env.azure file (using Azure env vars instead)"
echo "✅ Created AZURE_ENV_SETUP.md with configuration guide"
echo "✅ Updated azure-db-setup.sh to show env var status"
echo ""

git add .
git add -u  # This will stage the deleted .env.azure file

echo "📋 Files being committed:"
git status --porcelain

echo ""
echo "💾 Committing environment variables setup..."
git commit -m "Setup Azure environment variables configuration

- Remove .env.azure file (security best practice)
- Add AZURE_ENV_SETUP.md with environment variables guide
- Update database setup script to show env var status
- Environment variables should be set in Azure App Service

Required Azure env vars:
- DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD (PostgreSQL)
- MONGODB_HOST, MONGODB_DATABASE, MONGODB_USERNAME, MONGODB_PASSWORD
- APP_ENV=production, APP_DEBUG=false, etc."

echo ""
echo "🌐 Pushing to Azure..."
git push origin main

echo ""
echo "✅ ENVIRONMENT SETUP UPDATED!"
echo ""
echo "🔧 Next steps to fix empty databases:"
echo ""
echo "1. 🏗️ Configure Azure Environment Variables:"
echo "   - Go to Azure Portal → App Service → Configuration"
echo "   - Add the variables from AZURE_ENV_SETUP.md"
echo ""
echo "2. 🗄️ Set up your hosted databases:"
echo "   PostgreSQL:"
echo "   - DB_HOST=[your-azure-postgresql-host]"
echo "   - DB_DATABASE=[your-database-name]"
echo "   - DB_USERNAME=[your-username]"
echo "   - DB_PASSWORD=[your-password]"
echo ""
echo "   MongoDB:"
echo "   - MONGODB_HOST=[your-mongodb-host]"
echo "   - MONGODB_DATABASE=[your-database-name]"
echo "   - MONGODB_USERNAME=[your-username]"
echo "   - MONGODB_PASSWORD=[your-password]"
echo ""
echo "3. 🔄 Restart the App Service after setting variables"
echo ""
echo "4. 🧪 Test the site - databases should populate automatically!"
echo ""
echo "The azure-db-setup.sh script will run migrations and seeding"
echo "when the environment variables are properly configured."