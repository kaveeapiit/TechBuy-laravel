#!/bin/bash

echo "🚀 Deploying Persistent Azure Configuration"
echo "=========================================="

# Function to log with timestamp
log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1"
}

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    echo "❌ Error: Not in Laravel project directory"
    echo "Please run this from your Laravel project root"
    exit 1
fi

# Make sure all scripts are executable
log "🔧 Setting script permissions..."
chmod +x init_container.sh
chmod +x startup.sh
chmod +x deploy-persistent-config.sh

# Git commit and deploy to Azure
log "📝 Committing changes to Git..."

git add .
git commit -m "feat: Add persistent Azure container initialization

- Add init_container.sh for automatic nginx configuration on restart
- Create test-routing.php for debugging routes
- Add Azure startup configuration instructions
- Ensure HTTPS and routing work after every app restart

This fixes the issue where restarting the web app breaks URL routing
but keeps HTTPS working. Now both will persist across restarts."

log "🚀 Pushing to Azure..."
git push azure main

log "✅ Deployment complete!"
log ""
log "🎯 NEXT STEPS:"
log "=============="
log "1. Go to Azure Portal"
log "2. Navigate to your App Service"
log "3. Go to Configuration > General Settings"
log "4. Set Startup Command to: /home/site/wwwroot/init_container.sh"
log "5. Save and restart your app"
log ""
log "📝 Or use Azure CLI:"
log "az webapp config set --name YOUR_APP_NAME --resource-group YOUR_RG --startup-file \"/home/site/wwwroot/init_container.sh\""
log ""
log "🧪 After restart, test with:"
log "https://your-app.azurewebsites.net/test-routing.php"
log ""
log "This will ensure nginx configuration persists across ALL restarts!"
