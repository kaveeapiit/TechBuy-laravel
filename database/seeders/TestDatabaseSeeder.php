<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class TestDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "Testing PostgreSQL connection (Users)...\n";

        // Test PostgreSQL with User model
        $user = User::firstOrCreate(
            ['email' => 'test@techbuy.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );
        echo "✅ User found/created in PostgreSQL: {$user->name} (ID: {$user->id})\n";

        echo "\nTesting MongoDB connection (Categories & Products)...\n";

        // Test MongoDB with Category model
        $category = Category::firstOrCreate(
            ['slug' => 'test-category'],
            [
                'name' => 'Test Category',
                'description' => 'A test category for MongoDB',
                'is_active' => true,
            ]
        );
        echo "✅ Category found/created in MongoDB: {$category->name} (ID: {$category->_id})\n";

        // Test MongoDB with Product model
        $product = Product::firstOrCreate(
            ['sku' => 'TEST-001'],
            [
                'name' => 'Test Product',
                'slug' => 'test-product',
                'description' => 'A test product for MongoDB',
                'short_description' => 'Test product',
                'price' => 99.99,
                'stock_quantity' => 10,
                'manage_stock' => true,
                'in_stock' => true,
                'is_active' => true,
                'category_id' => $category->_id,
                'brand' => 'Test Brand',
                'model' => 'Test Model',
            ]
        );
        echo "✅ Product found/created in MongoDB: {$product->name} (ID: {$product->_id})\n";

        echo "\n🎉 All database connections working successfully!\n";
        echo "- PostgreSQL: Users, Carts, Orders\n";
        echo "- MongoDB: Products, Categories\n";
    }
}
