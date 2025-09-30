#!/bin/bash

echo "🔧 COMPREHENSIVE FIX: All Remaining Issues"
echo "=========================================="

echo "Issues to fix:"
echo "1. ❌ fake() function not available in production"
echo "2. ❌ Seeding errors due to factory issues"
echo "3. ❌ Missing proper data seeding"
echo ""

echo "✅ Fixed UserFactory to use \$this->faker instead of fake()"
echo "✅ Will create production-safe seeders"
echo "✅ Will add manual seeding as backup"
echo ""

# Create a simple production seeder that doesn't rely on factories
cat > database/seeders/ProductionSeeder.php << 'EOF'
<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductionSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@techbuy.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        // Create test user
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        // Create categories
        $categories = [
            ['name' => 'iPhones', 'slug' => 'iphones', 'description' => 'Latest iPhone models'],
            ['name' => 'MacBooks', 'slug' => 'macbooks', 'description' => 'MacBook Pro and Air'],
            ['name' => 'Android Phones', 'slug' => 'android-phones', 'description' => 'Android smartphones'],
            ['name' => 'Laptops', 'slug' => 'laptops', 'description' => 'Windows and Linux laptops'],
            ['name' => 'Tablets', 'slug' => 'tablets', 'description' => 'iPads and Android tablets'],
            ['name' => 'Accessories', 'slug' => 'accessories', 'description' => 'Tech accessories'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create sample products
        $products = [
            [
                'name' => 'iPhone 15 Pro',
                'slug' => 'iphone-15-pro',
                'description' => 'Latest iPhone with Pro features',
                'price' => 999.00,
                'sale_price' => 899.00,
                'category_id' => 1,
                'stock_quantity' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'MacBook Pro M3',
                'slug' => 'macbook-pro-m3',
                'description' => 'Powerful MacBook Pro with M3 chip',
                'price' => 1999.00,
                'category_id' => 2,
                'stock_quantity' => 25,
                'is_active' => true,
            ],
            [
                'name' => 'Samsung Galaxy S24',
                'slug' => 'samsung-galaxy-s24',
                'description' => 'Latest Samsung flagship phone',
                'price' => 799.00,
                'sale_price' => 699.00,
                'category_id' => 3,
                'stock_quantity' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Dell XPS 13',
                'slug' => 'dell-xps-13',
                'description' => 'Premium ultrabook laptop',
                'price' => 1299.00,
                'category_id' => 4,
                'stock_quantity' => 20,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
EOF

echo "📝 Created ProductionSeeder with manual data"
echo ""
echo "🚀 Ready to deploy final fix!"
