#!/bin/bash

echo "🔧 FIXING AZURE ADMIN TABLE SCHEMA"
echo "=================================="

echo "Issue found: Azure admin table missing 'is_active' column"
echo "Running database schema fix..."

# Add the missing is_active column to admin table
php artisan tinker --execute="
try {
    // Check if is_active column exists
    if (!Schema::hasColumn('admins', 'is_active')) {
        Schema::table('admins', function (\$table) {
            \$table->boolean('is_active')->default(true)->after('role');
        });
        echo 'Added is_active column to admins table';
    } else {
        echo 'is_active column already exists';
    }
} catch (Exception \$e) {
    echo 'Schema error: ' . \$e->getMessage();
}
"

echo ""
echo "Now creating admin accounts..."

# Create admin accounts without specifying is_active (will use default)
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
            'email_verified_at' => now(),
        ]);
        echo 'Regular admin created: admin2@techbuy.com';
    } else {
        echo 'Regular admin already exists';
    }
} catch (Exception \$e) {
    echo 'Admin creation error: ' . \$e->getMessage();
}
"

echo ""
echo "✅ Admin table schema fix completed!"
echo ""
echo "📧 Admin Accounts:"
echo "   Super Admin: admin@techbuy.com | Password: password123"
echo "   Admin User:  admin2@techbuy.com | Password: password123"
