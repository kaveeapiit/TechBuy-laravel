#!/bin/bash

echo "==================== AZURE NGINX ROUTING FIX ===================="
echo "🔧 Creating nginx-compatible solution for Azure App Service..."

# Create nginx configuration for Azure
cat > nginx-default.conf << 'EOF'
server {
    listen 8080;
    listen [::]:8080;
    root /home/site/wwwroot;
    index index.php index.html index.htm;
    server_name _;

    # Security headers
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;

    # Handle static files
    location ~* \.(css|js|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot|pdf)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        try_files $uri =404;
    }

    # Handle special debug files
    location ~ ^/(debug-routing\.php|mongodb-status\.php|check-mongodb\.php)$ {
        try_files $uri =404;
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Handle Laravel routes - this is the key fix
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # Handle PHP files
    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;

        # Laravel-specific parameters
        fastcgi_param PATH_INFO $fastcgi_path_info;
        fastcgi_param PATH_TRANSLATED $document_root$fastcgi_path_info;
    }

    # Deny access to sensitive files
    location ~ /\. {
        deny all;
    }

    location ~ /\.env {
        deny all;
    }
}
EOF

# Create Azure startup script
cat > startup.sh << 'EOF'
#!/bin/bash

echo "🚀 Azure Startup Script - Configuring nginx for Laravel"

# Copy custom nginx config if it exists
if [ -f "/home/site/wwwroot/nginx-default.conf" ]; then
    echo "📁 Copying custom nginx configuration..."
    cp /home/site/wwwroot/nginx-default.conf /etc/nginx/sites-available/default
    nginx -t && nginx -s reload
    echo "✅ Nginx configuration updated"
fi

# Set proper permissions
chmod -R 755 /home/site/wwwroot
chown -R www-data:www-data /home/site/wwwroot/storage
chown -R www-data:www-data /home/site/wwwroot/bootstrap/cache

# Run Laravel optimizations
cd /home/site/wwwroot
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Azure startup completed"
EOF

# Create application settings for Azure
cat > azure-app-settings.json << 'EOF'
{
    "WEBSITES_ENABLE_APP_SERVICE_STORAGE": "false",
    "WEBSITES_CONTAINER_START_TIME_LIMIT": "1800",
    "WEBSITES_PORT": "8080",
    "PHP_INI_SCAN_DIR": "/usr/local/etc/php/conf.d:/home/site",
    "STARTUP_COMMAND": "/home/site/wwwroot/startup.sh"
}
EOF

# Create a simpler .htaccess that works better with Azure
cat > .htaccess-azure << 'EOF'
<IfModule mod_rewrite.c>
    Options -MultiViews
    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Force HTTPS on Azure
    RewriteCond %{HTTP:X-Forwarded-Proto} =http
    RewriteRule .* https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

    # Laravel Front Controller
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
EOF

echo "📝 Created nginx configuration files"

# Commit the nginx routing fix
git add .
git commit -m "fix: Azure nginx routing configuration

🎯 Azure App Service nginx fixes:
- Custom nginx configuration for Laravel routing
- Azure startup script for automatic configuration
- Simplified .htaccess for better Azure compatibility
- Application settings for proper Azure deployment

🔧 Key changes:
- nginx try_files directive for Laravel routes
- Proper fastcgi configuration for PHP
- Static file handling optimization
- Security headers and file protection"

# Push to Azure
echo "📤 Deploying nginx configuration to Azure..."
git push origin main

echo ""
echo "==================== AZURE CONFIGURATION STEPS ===================="
echo ""
echo "🔧 MANUAL STEPS NEEDED IN AZURE PORTAL:"
echo ""
echo "1. Go to Azure Portal → Your App Service → Configuration"
echo ""
echo "2. Add these Application Settings:"
echo "   WEBSITES_ENABLE_APP_SERVICE_STORAGE = false"
echo "   WEBSITES_CONTAINER_START_TIME_LIMIT = 1800"
echo "   STARTUP_COMMAND = /home/site/wwwroot/startup.sh"
echo ""
echo "3. Go to App Service → Development Tools → SSH"
echo ""
echo "4. In SSH console, run:"
echo "   cd /home/site/wwwroot"
echo "   chmod +x startup.sh"
echo "   ./startup.sh"
echo ""
echo "5. Restart your App Service"
echo ""
echo "==================== ALTERNATIVE SIMPLE FIX ===================="
echo ""
echo "If the above is complex, try this simpler approach:"
echo ""
echo "1. Replace your current .htaccess with:"
echo "   cp .htaccess-azure .htaccess"
echo ""
echo "2. Update web.config with the correct rewrite rule:"
echo "   <action type=\"Rewrite\" url=\"index.php\" appendQueryString=\"true\" />"
echo ""
echo "3. Restart your App Service"
echo ""
echo "🎯 After these changes, /login should work properly!"
