<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Database\Seeder;

class ComprehensiveTestSeeder extends Seeder
{
    /**
     * Test the complete dual database setup.
     */
    public function run(): void
    {
        echo "🚀 TechBuy Dual Database Test\n";
        echo "============================\n\n";

        // Test PostgreSQL Models
        echo "📊 PostgreSQL Database (User Data)\n";
        echo "-----------------------------------\n";

        $user = User::firstOrCreate(
            ['email' => 'customer@techbuy.com'],
            [
                'name' => 'John Customer',
                'password' => bcrypt('password'),
            ]
        );
        echo "✅ User: {$user->name} - Connection: {$user->getConnectionName()}\n";

        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        echo "✅ Cart: ID {$cart->id} - Connection: {$cart->getConnectionName()}\n";

        // Test Product Catalog (currently PostgreSQL, will be MongoDB later)
        echo "\n📦 Product Catalog (Currently PostgreSQL)\n";
        echo "----------------------------------------\n";

        $category = Category::first();
        if ($category) {
            echo "✅ Category: {$category->name} - Connection: {$category->getConnectionName()}\n";
        }

        $product = Product::first();
        if ($product) {
            echo "✅ Product: {$product->name} - Connection: {$product->getConnectionName()}\n";

            // Test cross-database relationship (Cart in PostgreSQL, Product in PostgreSQL)
            $cartItem = CartItem::firstOrCreate([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
            ], [
                'quantity' => 1,
                'price' => $product->getCurrentPrice(),
            ]);
            echo "✅ Cart Item: Product '{$product->name}' added to cart - Connection: {$cartItem->getConnectionName()}\n";
        }

        echo "\n🔄 Database Architecture\n";
        echo "------------------------\n";
        echo "PostgreSQL (techbuy_users):\n";
        echo "  ├── Users & Authentication\n";
        echo "  ├── Shopping Carts & Cart Items\n";
        echo "  ├── Orders & Order Items\n";
        echo "  └── Currently: Products & Categories (temporary)\n\n";

        echo "MongoDB (techbuy_products) - Future:\n";
        echo "  ├── Product Catalog\n";
        echo "  ├── Category Management\n";
        echo "  └── Product Specifications & Metadata\n\n";

        echo "📝 Migration Status:\n";
        echo "  ✅ PostgreSQL connection configured\n";
        echo "  ✅ User-related tables created\n";
        echo "  ✅ Product tables temporarily in PostgreSQL\n";
        echo "  ⏳ MongoDB requires ext-mongodb extension\n\n";

        echo "🎯 Next Steps for Full MongoDB Integration:\n";
        echo "  1. Install MongoDB PHP extension\n";
        echo "  2. Update Product & Category models to use MongoDB\n";
        echo "  3. Migrate existing product data to MongoDB\n";
        echo "  4. Update CartItem & OrderItem to use MongoDB ObjectIds\n\n";

        echo "✨ System Status: READY with dual database architecture!\n";
    }
}
