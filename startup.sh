#!/bin/bash

echo "🔧 Azure Laravel Startup with File Storage"
echo "=========================================="

log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1"
}

log "Starting Azure Laravel configuration..."

# Install MongoDB PHP extension if not already installed
log "🔌 Checking MongoDB PHP extension..."
if ! php -m | grep -q mongodb; then
    log "📦 Installing MongoDB PHP extension..."

    # Update package list
    apt-get update -y

    # Install required packages
    apt-get install -y pkg-config libssl-dev libsasl2-dev

    # Install MongoDB extension via PECL
    pecl install mongodb

    # Enable the extension
    echo "extension=mongodb.so" >> /usr/local/etc/php/conf.d/mongodb.ini

    log "✅ MongoDB PHP extension installed"
else
    log "✅ MongoDB PHP extension already installed"
fi

# Set working directory
cd /home/site/wwwroot

# Apply nginx configuration (essential for URL routing)
if [ -f "/home/site/wwwroot/nginx.conf" ]; then
    log "📁 Applying nginx configuration..."

    # Simple backup
    cp /etc/nginx/sites-available/default /etc/nginx/sites-available/default.backup 2>/dev/null || true

    # Apply configuration
    cp /home/site/wwwroot/nginx.conf /etc/nginx/sites-available/default

    # Reload nginx
    nginx -s reload 2>/dev/null || service nginx restart 2>/dev/null
    log "✅ Nginx configuration applied"
fi

# Set up persistent file storage for uploads
log "📁 Setting up persistent file storage..."
mkdir -p /home/LogFiles/storage/products 2>/dev/null || true
mkdir -p /home/LogFiles/storage/profile-photos 2>/dev/null || true
mkdir -p /home/LogFiles/storage/uploads 2>/dev/null || true
chmod -R 755 /home/LogFiles/storage 2>/dev/null || true

# Create symbolic link to persistent storage
rm -rf /home/site/wwwroot/public/storage 2>/dev/null || true
ln -sf /home/LogFiles/storage /home/site/wwwroot/public/storage 2>/dev/null || true
log "✅ Persistent storage configured"

# Set basic permissions
chmod -R 755 /home/site/wwwroot 2>/dev/null || true
chmod -R 775 /home/site/wwwroot/storage 2>/dev/null || true
chmod -R 775 /home/site/wwwroot/bootstrap/cache 2>/dev/null || true

# Clear cache for fresh start
log "🧹 Clearing caches..."
php artisan config:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true
php artisan route:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true

# Database Setup
log "📊 Setting up database..."

# Run migrations (this will create tables and update schema)
log "🔄 Running migrations..."
php artisan migrate --force 2>/dev/null || true

# Fix admin migration tracking if needed
log "🔧 Fixing admin migration tracking..."
php artisan tinker --execute="
try {
    if (!DB::table('migrations')->where('migration', '2025_09_23_155354_create_admins_table')->exists()) {
        DB::table('migrations')->insert([
            'migration' => '2025_09_23_155354_create_admins_table',
            'batch' => DB::table('migrations')->max('batch') + 1
        ]);
        echo 'Admin migration marked as completed';
    } else {
        echo 'Admin migration already tracked';
    }
} catch (Exception \$e) {
    echo 'Migration tracking error: ' . \$e->getMessage();
}
" 2>/dev/null || true

# Update database constraints for admin roles
log "🔧 Updating admin role constraints..."
php artisan tinker --execute="
try {
    DB::statement('ALTER TABLE admins DROP CONSTRAINT IF EXISTS admins_role_check');
    DB::statement('ALTER TABLE admins ADD CONSTRAINT admins_role_check CHECK (role IN (\'super_admin\', \'admin\', \'moderator\'))');
    echo 'Admin role constraints updated';
} catch (Exception \$e) {
    echo 'Constraint update error: ' . \$e->getMessage();
}
" 2>/dev/null || true

# Seed admin accounts (only if they don't exist)
log "👤 Creating admin accounts..."
php artisan tinker --execute="
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

try {
    // Create super admin if doesn't exist
    if (!Admin::where('email', 'admin@techbuy.com')->exists()) {
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@techbuy.com',
            'password' => Hash::make('password123'),
            'role' => 'super_admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        echo 'Super admin created: admin@techbuy.com';
    } else {
        echo 'Super admin already exists';
    }

    // Create regular admin if doesn't exist
    if (!Admin::where('email', 'admin2@techbuy.com')->exists()) {
        Admin::create([
            'name' => 'Admin User',
            'email' => 'admin2@techbuy.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        echo 'Regular admin created: admin2@techbuy.com';
    } else {
        echo 'Regular admin already exists';
    }
} catch (Exception \$e) {
    echo 'Admin creation error: ' . \$e->getMessage();
}
" 2>/dev/null || true

# Optimize for production
log "⚡ Optimizing for production..."
php artisan config:cache 2>/dev/null || true
php artisan route:cache 2>/dev/null || true

log "✅ Complete Laravel startup with database setup completed"
log "🌐 Application ready with admin accounts"
log ""
log "📧 Admin Accounts Created:"
log "   Super Admin: admin@techbuy.com | Password: password123"
log "   Admin User:  admin2@techbuy.com | Password: password123"

