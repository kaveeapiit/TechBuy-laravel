#!/bin/bash

echo "🚀 Azure App Service Persistent Configuration"
echo "============================================"

# Set the startup command in Azure App Service
# This ensures our initialization script runs on EVERY container restart

log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1"
}

log "Setting up persistent Azure App Service configuration..."

# Make scripts executable
chmod +x /home/site/wwwroot/init_container.sh
chmod +x /home/site/wwwroot/startup.sh

# Create Azure startup configuration
cat > /home/site/wwwroot/azure-startup-config.txt << 'EOF'
# ===== AZURE APP SERVICE STARTUP COMMAND =====
#
# To make the nginx configuration persistent across restarts,
# set this as your startup command in Azure App Service:
#
# /home/site/wwwroot/init_container.sh
#
# This can be set via:
# 1. Azure Portal: Configuration > General Settings > Startup Command
# 2. Azure CLI: az webapp config set --startup-file "/home/site/wwwroot/init_container.sh"
# 3. ARM Template: "linuxFxVersion": "PHP|8.2", "appCommandLine": "/home/site/wwwroot/init_container.sh"
#
# The init_container.sh script will:
# - Apply nginx configuration automatically on every restart
# - Configure Laravel for HTTPS
# - Set proper permissions
# - Clear caches
# - Verify services are running
#
# After setting this startup command, restart your app service.
EOF

log "✅ Created Azure startup configuration instructions"

# Create a verification script to test if configuration is working
cat > /home/site/wwwroot/test-routing.php << 'EOF'
<?php
echo "🧪 Laravel Routing Test\n";
echo "=====================\n\n";

// Test if pretty URLs are working
$tests = [
    '✅ Index page' => '/',
    '🔐 Login page' => '/login',
    '📝 Register page' => '/register',
    '📊 Dashboard' => '/dashboard',
    '🛍️ Products' => '/products',
];

echo "Testing Laravel routes:\n\n";

foreach ($tests as $name => $route) {
    $url = "https://" . $_SERVER['HTTP_HOST'] . $route;
    echo "$name: $url\n";

    // Test if route exists (simple check)
    $context = stream_context_create([
        'http' => [
            'method' => 'HEAD',
            'timeout' => 5,
            'ignore_errors' => true
        ]
    ]);

    $headers = @get_headers($url, 1, $context);
    if ($headers && strpos($headers[0], '200') !== false) {
        echo "   Status: ✅ OK\n";
    } elseif ($headers && strpos($headers[0], '302') !== false) {
        echo "   Status: 🔄 Redirect (probably OK)\n";
    } else {
        echo "   Status: ❌ Error or not accessible\n";
    }
    echo "\n";
}

echo "🌐 Current request info:\n";
echo "   Protocol: " . (isset($_SERVER['HTTPS']) ? 'HTTPS' : 'HTTP') . "\n";
echo "   Host: " . $_SERVER['HTTP_HOST'] . "\n";
echo "   URI: " . $_SERVER['REQUEST_URI'] . "\n";
echo "   User Agent: " . ($_SERVER['HTTP_USER_AGENT'] ?? 'Unknown') . "\n";

echo "\n🔍 Server variables:\n";
$important_vars = ['HTTP_X_FORWARDED_PROTO', 'HTTP_X_FORWARDED_FOR', 'HTTPS', 'SERVER_PORT'];
foreach ($important_vars as $var) {
    echo "   $var: " . ($_SERVER[$var] ?? 'Not set') . "\n";
}
?>
EOF

log "✅ Created routing test script at /test-routing.php"

# Create deployment script for Azure
cat > /home/site/wwwroot/deploy-persistent-config.sh << 'EOF'
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

EOF

chmod +x /home/site/wwwroot/deploy-persistent-config.sh

log "✅ Created deployment script"

echo ""
echo "🎯 READY TO DEPLOY PERSISTENT CONFIGURATION!"
echo "==========================================="
echo ""
echo "📋 What this solves:"
echo "   ❌ Problem: App restart breaks URL routing (/login shows 404)"
echo "   ✅ Solution: Automatic nginx config on every container start"
echo "   ✅ Result: Both HTTPS AND routing work after restart"
echo ""
echo "🚀 To deploy, run:"
echo "   ./deploy-persistent-config.sh"
echo ""
echo "⚙️  Then set Azure startup command to:"
echo "   /home/site/wwwroot/init_container.sh"
echo ""
echo "🧪 Test after restart with:"
echo "   https://your-app.azurewebsites.net/test-routing.php"
