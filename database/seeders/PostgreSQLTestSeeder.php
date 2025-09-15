<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Cart;
use Illuminate\Database\Seeder;

class PostgreSQLTestSeeder extends Seeder
{
    /**
     * Test PostgreSQL connection with user-related models.
     */
    public function run(): void
    {
        echo "🔍 Testing PostgreSQL Database Connection...\n\n";

        // Test User model (PostgreSQL)
        $user = User::firstOrCreate(
            ['email' => 'admin@techbuy.com'],
            [
                'name' => 'TechBuy Admin',
                'password' => bcrypt('password'),
            ]
        );
        echo "✅ User: {$user->name} (ID: {$user->id}) - PostgreSQL Connection: {$user->getConnectionName()}\n";

        // Test Cart model (PostgreSQL)
        $cart = Cart::firstOrCreate([
            'user_id' => $user->id,
        ]);
        echo "✅ Cart created for user (ID: {$cart->id}) - PostgreSQL Connection: {$cart->getConnectionName()}\n";

        echo "\n🎉 PostgreSQL connection working successfully!\n";
        echo "📊 Database: techbuy_users\n";
        echo "📋 Tables: users, carts, cart_items, orders, order_items\n\n";

        // Show database info
        echo "🔗 Database Connections Configured:\n";
        echo "- PostgreSQL (Default): User management, Shopping carts, Orders\n";
        echo "- MongoDB: Product catalog, Categories (requires ext-mongodb)\n\n";

        echo "📝 Next Steps:\n";
        echo "1. Install PHP MongoDB extension: pecl install mongodb\n";
        echo "2. Add extension=mongodb to php.ini\n";
        echo "3. Restart web server\n";
        echo "4. Products and Categories will use MongoDB\n";
    }
}
