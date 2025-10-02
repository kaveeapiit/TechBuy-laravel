<?php

namespace Database\Seeders;

use App\Models\Mongo\PreOrder;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class PreOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if MongoDB extension is available
        if (!extension_loaded('mongodb')) {
            echo "⚠️  MongoDB extension not loaded. Skipping Pre-order seeding.\n";
            return;
        }

        try {
            // Test MongoDB connection
            $testPreOrder = new PreOrder();
            echo "✅ MongoDB connection successful for pre-orders\n";
        } catch (\Exception $e) {
            echo "❌ MongoDB connection failed: " . $e->getMessage() . "\n";
            return;
        }

        echo "🚀 Starting Pre-order seeding...\n";

        // Clear existing pre-orders
        try {
            PreOrder::truncate();
            echo "🧹 Cleared existing pre-orders\n";
        } catch (\Exception $e) {
            echo "⚠️  Could not clear pre-orders: " . $e->getMessage() . "\n";
        }

        // Get some users to create pre-orders for
        $users = User::limit(3)->get();

        if ($users->count() === 0) {
            echo "⚠️  No users found. Please seed users first.\n";
            return;
        }

        $preOrderItems = [
            'iPhone 15 Pro Max 1TB - Natural Titanium',
            'MacBook Pro M3 Max 16-inch 64GB RAM 2TB SSD',
            'iPad Pro 12.9-inch M2 Wi-Fi + Cellular 2TB',
            'Apple Vision Pro 512GB',
            'Samsung Galaxy S24 Ultra 1TB - Titanium Black',
            'Google Pixel 8 Pro 1TB - Bay Blue',
            'Nintendo Switch OLED Model - White',
            'Sony PlayStation 5 Pro 2TB',
            'Microsoft Surface Studio 3 28-inch',
            'Dell XPS 17 9730 4K OLED Touch',
            'NVIDIA GeForce RTX 4090 24GB',
            'AMD Ryzen 9 7950X3D Processor',
            'Meta Quest 3 512GB VR Headset',
            'Apple Watch Ultra 2 49mm Titanium',
            'AirPods Pro 2nd Generation with USB-C',
        ];

        $statuses = ['pending', 'confirmed', 'processing', 'completed', 'cancelled'];

        foreach ($users as $index => $user) {
            // Create 2-4 pre-orders per user
            $preOrderCount = rand(2, 4);

            for ($i = 0; $i < $preOrderCount; $i++) {
                $createdAt = now()->subDays(rand(1, 30));
                $status = $statuses[array_rand($statuses)];

                $preOrder = PreOrder::create([
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'mobile_number' => '+1 (' . rand(100, 999) . ') ' . rand(100, 999) . '-' . rand(1000, 9999),
                    'preorder_item' => $preOrderItems[array_rand($preOrderItems)],
                    'status' => $status,
                    'notes' => $status === 'confirmed' ? 'We will notify you when the item becomes available.' : null,
                    'estimated_delivery' => $status === 'processing' ? now()->addDays(rand(7, 30)) : null,
                    'created_at' => $createdAt,
                    'updated_at' => $status === 'pending' ? $createdAt : $createdAt->addDays(rand(1, 5)),
                ]);

                echo "✅ Created pre-order for {$user->name}: {$preOrder->preorder_item} (Status: {$status})\n";
            }
        }

        echo "\n🎉 Pre-order seeding completed successfully!\n";
        echo "📊 Total pre-orders created: " . PreOrder::count() . "\n";
    }
}
