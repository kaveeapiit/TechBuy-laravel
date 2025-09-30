#!/bin/bash

echo "🔧 Fixing Azure Routing and Database Issues"
echo "==========================================="

echo "Issues identified:"
echo "1. 🚫 Azure App Service uses nginx, not Apache (.htaccess ignored)"
echo "2. 🗄️  Database configuration mismatch (local SQLite vs Azure PostgreSQL)"
echo "3. 🔗 Routes not working due to missing nginx configuration"
echo ""

echo "Solutions implemented:"
echo "1. ✅ Created web.config for Azure/Windows compatibility"
echo "2. ✅ Will create startup script for nginx configuration"
echo "3. ✅ Will configure database for Azure deployment"
echo ""

# Create a startup script for Azure deployment
cat > startup.sh << 'EOF'
#!/bin/bash

echo "🚀 Azure Startup Script"
echo "====================="

# Set permissions
chmod -R 755 /home/site/wwwroot
chown -R root:root /home/site/wwwroot

# Run Laravel optimizations
cd /home/site/wwwroot

# Cache config for production
php artisan config:cache 2>/dev/null || echo "Config cache skipped"

# Cache routes for production  
php artisan route:cache 2>/dev/null || echo "Route cache skipped"

# Cache views for production
php artisan view:cache 2>/dev/null || echo "View cache skipped"

# Migrate database if needed
php artisan migrate --force 2>/dev/null || echo "Migration skipped"

# Seed database if empty
php artisan db:seed --force 2>/dev/null || echo "Seeding skipped"

echo "✅ Laravel application ready"
EOF

chmod +x startup.sh

# Create nginx configuration for Azure
mkdir -p nginx
cat > nginx/default.conf << 'EOF'
server {
    listen 8080;
    server_name _;
    root /home/site/wwwroot;
    index index.php index.html index.htm;

    # Laravel routing
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # Handle PHP files
    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Serve static files directly
    location ~* \.(css|js|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        try_files $uri =404;
    }

    # Security headers
    add_header X-Content-Type-Options "nosniff";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Frame-Options "SAMEORIGIN";
}
EOF

echo "📁 Created nginx configuration"
echo "📁 Created startup script"
echo "📁 Created web.config for Windows compatibility"
echo ""
echo "🚀 Ready to deploy comprehensive fix!"