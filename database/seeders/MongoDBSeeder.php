<?php

namespace Database\Seeders;

use App\Models\Mongo\MongoProduct;
use App\Models\Mongo\MongoCategory;
use App\Models\Mongo\ProductAnalytic;
use App\Models\Mongo\ProductReview;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class MongoDBSeeder extends Seeder
{
    public function run(): void
    {
        // Check if MongoDB extension is available
        if (!extension_loaded('mongodb')) {
            echo "⚠️  MongoDB extension not loaded. Skipping MongoDB seeding.\n";
            echo "📦 To enable MongoDB support:\n";
            echo "   1. Install: pecl install mongodb\n";
            echo "   2. Add extension=mongodb to php.ini\n";
            echo "   3. Restart web server\n\n";
            return;
        }

        try {
            // Test MongoDB connection
            $testConnection = new MongoCategory();
            echo "✅ MongoDB connection successful\n";
        } catch (\Exception $e) {
            echo "❌ MongoDB connection failed: " . $e->getMessage() . "\n";
            echo "🔧 Check your MongoDB connection settings in .env file\n\n";
            return;
        }

        echo "🚀 Starting MongoDB seeding...\n";

        // Clear existing MongoDB data
        try {
            MongoCategory::truncate();
            MongoProduct::truncate();
            ProductAnalytic::truncate();
            ProductReview::truncate();
            echo "🧹 Cleared existing MongoDB collections\n";
        } catch (\Exception $e) {
            echo "⚠️  Could not clear collections: " . $e->getMessage() . "\n";
        }

        // Create MongoDB categories
        $mongoCategories = [
            [
                'name' => 'iPhones',
                'slug' => 'iphones',
                'description' => 'Latest iPhone models with cutting-edge technology',
                'is_active' => true,
                'image' => 'categories/iphones.jpg',
                'meta_title' => 'iPhones - Latest Apple Smartphones',
                'meta_description' => 'Shop the latest iPhone models with advanced features and technology',
                'seo_keywords' => ['iphone', 'apple', 'smartphone', 'ios'],
                'category_order' => 1,
            ],
            [
                'name' => 'MacBooks',
                'slug' => 'macbooks',
                'description' => 'MacBook Pro and Air with M-series chips',
                'is_active' => true,
                'image' => 'categories/macbooks.jpg',
                'meta_title' => 'MacBooks - Apple Laptops',
                'meta_description' => 'Professional MacBook Pro and lightweight MacBook Air models',
                'seo_keywords' => ['macbook', 'apple', 'laptop', 'macos'],
                'category_order' => 2,
            ],
            [
                'name' => 'Android Phones',
                'slug' => 'android-phones',
                'description' => 'Premium Android smartphones from top brands',
                'is_active' => true,
                'image' => 'categories/android.jpg',
                'meta_title' => 'Android Phones - Premium Smartphones',
                'meta_description' => 'Latest Android smartphones from Samsung, Google, and other top brands',
                'seo_keywords' => ['android', 'smartphone', 'samsung', 'google'],
                'category_order' => 3,
            ],
            [
                'name' => 'Laptops',
                'slug' => 'laptops',
                'description' => 'Windows and Linux laptops for work and gaming',
                'is_active' => true,
                'image' => 'categories/laptops.jpg',
                'meta_title' => 'Laptops - Windows & Linux Computers',
                'meta_description' => 'High-performance laptops for business, gaming, and everyday use',
                'seo_keywords' => ['laptop', 'windows', 'gaming', 'business'],
                'category_order' => 4,
            ],
            [
                'name' => 'Tablets',
                'slug' => 'tablets',
                'description' => 'iPads and Android tablets for productivity and entertainment',
                'is_active' => true,
                'image' => 'categories/tablets.jpg',
                'meta_title' => 'Tablets - iPads & Android Tablets',
                'meta_description' => 'Tablets for productivity, creativity, and entertainment',
                'seo_keywords' => ['tablet', 'ipad', 'android', 'productivity'],
                'category_order' => 5,
            ],
            [
                'name' => 'Accessories',
                'slug' => 'accessories',
                'description' => 'Tech accessories and peripherals',
                'is_active' => true,
                'image' => 'categories/accessories.jpg',
                'meta_title' => 'Tech Accessories - Cases, Chargers & More',
                'meta_description' => 'Essential tech accessories for your devices',
                'seo_keywords' => ['accessories', 'cases', 'chargers', 'peripherals'],
                'category_order' => 6,
            ],
        ];

        $createdCategories = [];
        foreach ($mongoCategories as $categoryData) {
            $category = MongoCategory::create($categoryData);
            $createdCategories[] = $category;
            echo "✅ Created MongoDB category: {$category->name} (ID: {$category->_id})\n";
        }

        // Create MongoDB products with enhanced data
        $mongoProducts = [
            [
                'name' => 'iPhone 15 Pro',
                'slug' => 'iphone-15-pro',
                'description' => 'The iPhone 15 Pro features a titanium design, A17 Pro chip, and advanced camera system with 5x telephoto zoom.',
                'short_description' => 'Latest iPhone with Pro features and titanium design',
                'price' => 999.00,
                'sale_price' => 899.00,
                'sku' => 'IPH-15-PRO-001',
                'category_id' => $createdCategories[0]->_id,
                'category_slug' => 'iphones',
                'category_name' => 'iPhones',
                'stock_quantity' => 50,
                'manage_stock' => true,
                'in_stock' => true,
                'is_active' => true,
                'is_featured' => true,
                'brand' => 'Apple',
                'model' => 'iPhone 15 Pro',
                'weight' => 187.0,
                'dimensions' => [
                    'length' => 146.6,
                    'width' => 70.6,
                    'height' => 8.25,
                ],
                'images' => [
                    'products/iphone-15-pro-1.jpg',
                    'products/iphone-15-pro-2.jpg',
                    'products/iphone-15-pro-3.jpg',
                ],
                'specifications' => [
                    'Display' => '6.1-inch Super Retina XDR',
                    'Chip' => 'A17 Pro',
                    'Camera' => '48MP Main, 12MP Ultra Wide, 12MP Telephoto',
                    'Storage' => '128GB, 256GB, 512GB, 1TB',
                    'Battery' => 'Up to 23 hours video playback',
                ],
                'features' => [
                    'Titanium Design',
                    'Action Button',
                    'USB-C',
                    '5G Connectivity',
                    'Face ID',
                    'Wireless Charging',
                ],
                'tags' => ['smartphone', 'apple', 'premium', 'photography'],
                'meta_title' => 'iPhone 15 Pro - Titanium Design, A17 Pro Chip',
                'meta_description' => 'Experience the iPhone 15 Pro with titanium design, A17 Pro chip, and professional camera system.',
                'seo_keywords' => ['iphone 15 pro', 'apple', 'titanium', 'a17 pro'],
                'view_count' => 1250,
                'rating_average' => 4.8,
                'rating_count' => 47,
            ],
            [
                'name' => 'MacBook Pro M3',
                'slug' => 'macbook-pro-m3',
                'description' => 'The MacBook Pro with M3 chip delivers exceptional performance for professionals with up to 22 hours of battery life.',
                'short_description' => 'Professional laptop with M3 chip and all-day battery',
                'price' => 1999.00,
                'sku' => 'MBP-M3-14-001',
                'category_id' => $createdCategories[1]->_id,
                'category_slug' => 'macbooks',
                'category_name' => 'MacBooks',
                'stock_quantity' => 25,
                'manage_stock' => true,
                'in_stock' => true,
                'is_active' => true,
                'is_featured' => true,
                'brand' => 'Apple',
                'model' => 'MacBook Pro M3 14-inch',
                'weight' => 1620.0,
                'dimensions' => [
                    'length' => 312.6,
                    'width' => 221.2,
                    'height' => 15.5,
                ],
                'images' => [
                    'products/macbook-pro-m3-1.jpg',
                    'products/macbook-pro-m3-2.jpg',
                ],
                'specifications' => [
                    'Display' => '14-inch Liquid Retina XDR',
                    'Chip' => 'Apple M3',
                    'Memory' => '8GB, 16GB, 32GB unified memory',
                    'Storage' => '512GB, 1TB, 2TB, 4TB SSD',
                    'Battery' => 'Up to 22 hours',
                ],
                'features' => [
                    'M3 Chip',
                    'Liquid Retina XDR Display',
                    'MagSafe 3',
                    'Thunderbolt 4',
                    'Touch ID',
                    'Backlit Keyboard',
                ],
                'tags' => ['laptop', 'apple', 'professional', 'creative'],
                'meta_title' => 'MacBook Pro M3 - Professional Performance',
                'meta_description' => 'MacBook Pro with M3 chip offers exceptional performance for creative professionals.',
                'seo_keywords' => ['macbook pro', 'm3 chip', 'apple laptop', 'professional'],
                'view_count' => 890,
                'rating_average' => 4.9,
                'rating_count' => 23,
            ],
            [
                'name' => 'Samsung Galaxy S24',
                'slug' => 'samsung-galaxy-s24',
                'description' => 'Samsung Galaxy S24 with AI-powered features, advanced camera system, and premium design.',
                'short_description' => 'AI-powered flagship with advanced camera system',
                'price' => 799.00,
                'sale_price' => 699.00,
                'sku' => 'SAM-S24-128-001',
                'category_id' => $createdCategories[2]->_id,
                'category_slug' => 'android-phones',
                'category_name' => 'Android Phones',
                'stock_quantity' => 30,
                'manage_stock' => true,
                'in_stock' => true,
                'is_active' => true,
                'is_featured' => true,
                'brand' => 'Samsung',
                'model' => 'Galaxy S24',
                'weight' => 167.0,
                'dimensions' => [
                    'length' => 147.0,
                    'width' => 70.6,
                    'height' => 7.6,
                ],
                'images' => [
                    'products/galaxy-s24-1.jpg',
                    'products/galaxy-s24-2.jpg',
                ],
                'specifications' => [
                    'Display' => '6.2-inch Dynamic AMOLED 2X',
                    'Processor' => 'Snapdragon 8 Gen 3',
                    'Camera' => '50MP Main, 12MP Ultra Wide, 10MP Telephoto',
                    'Storage' => '128GB, 256GB',
                    'Battery' => '4000mAh with fast charging',
                ],
                'features' => [
                    'AI Photography',
                    '5G Connectivity',
                    'Wireless Charging',
                    'Water Resistant',
                    'Samsung DeX',
                ],
                'tags' => ['android', 'samsung', 'ai', 'photography'],
                'meta_title' => 'Samsung Galaxy S24 - AI Photography & Performance',
                'meta_description' => 'Galaxy S24 with AI-powered camera and flagship performance.',
                'seo_keywords' => ['galaxy s24', 'samsung', 'android', 'ai camera'],
                'view_count' => 750,
                'rating_average' => 4.6,
                'rating_count' => 35,
            ],
            [
                'name' => 'Dell XPS 13',
                'slug' => 'dell-xps-13',
                'description' => 'Dell XPS 13 ultrabook with Intel processors, premium build quality, and excellent portability.',
                'short_description' => 'Premium ultrabook with excellent portability',
                'price' => 1299.00,
                'sku' => 'DEL-XPS13-I7-001',
                'category_id' => $createdCategories[3]->_id,
                'category_slug' => 'laptops',
                'category_name' => 'Laptops',
                'stock_quantity' => 20,
                'manage_stock' => true,
                'in_stock' => true,
                'is_active' => true,
                'brand' => 'Dell',
                'model' => 'XPS 13',
                'weight' => 1270.0,
                'dimensions' => [
                    'length' => 295.7,
                    'width' => 199.04,
                    'height' => 15.8,
                ],
                'images' => [
                    'products/dell-xps-13-1.jpg',
                    'products/dell-xps-13-2.jpg',
                ],
                'specifications' => [
                    'Display' => '13.4-inch FHD+ InfinityEdge',
                    'Processor' => 'Intel Core i7-1355U',
                    'Memory' => '16GB LPDDR5',
                    'Storage' => '512GB PCIe SSD',
                    'Battery' => 'Up to 12 hours',
                ],
                'features' => [
                    'InfinityEdge Display',
                    'Premium Materials',
                    'Fast Charging',
                    'Thunderbolt 4',
                    'Windows Hello',
                ],
                'tags' => ['laptop', 'ultrabook', 'business', 'portable'],
                'meta_title' => 'Dell XPS 13 - Premium Ultrabook',
                'meta_description' => 'Dell XPS 13 combines performance and portability in a premium design.',
                'seo_keywords' => ['dell xps 13', 'ultrabook', 'business laptop', 'portable'],
                'view_count' => 425,
                'rating_average' => 4.5,
                'rating_count' => 18,
            ],
        ];

        foreach ($mongoProducts as $productData) {
            $product = MongoProduct::create($productData);
            echo "✅ Created MongoDB product: {$product->name} (ID: {$product->_id})\n";

            // Create analytics for each product
            ProductAnalytic::create([
                'product_id' => $product->_id,
                'views_count' => $product->view_count ?? 0,
                'views_today' => rand(5, 25),
                'views_this_week' => rand(50, 150),
                'views_this_month' => rand(200, 500),
                'clicks_count' => rand(20, 100),
                'clicks_today' => rand(1, 10),
                'clicks_this_week' => rand(10, 50),
                'clicks_this_month' => rand(50, 200),
                'cart_additions' => rand(5, 30),
                'cart_additions_today' => rand(0, 3),
                'cart_additions_this_week' => rand(5, 15),
                'cart_additions_this_month' => rand(20, 60),
                'purchases' => rand(2, 15),
                'purchases_today' => rand(0, 2),
                'purchases_this_week' => rand(1, 8),
                'purchases_this_month' => rand(5, 25),
                'revenue_total' => $product->price * rand(5, 20),
                'revenue_today' => $product->price * rand(0, 2),
                'revenue_this_week' => $product->price * rand(2, 8),
                'revenue_this_month' => $product->price * rand(10, 30),
                'conversion_rate' => round(rand(15, 45) / 10, 1), // 1.5% to 4.5%
                'bounce_rate' => round(rand(300, 700) / 10, 1), // 30% to 70%
                'last_viewed_at' => now()->subHours(rand(1, 24)),
                'last_purchased_at' => now()->subDays(rand(1, 7)),
                'popular_search_terms' => [
                    strtolower($product->brand),
                    strtolower($product->name),
                    strtolower($product->category_name),
                ],
                'device_analytics' => [
                    'mobile' => rand(40, 60),
                    'desktop' => rand(30, 50),
                    'tablet' => rand(5, 15),
                ],
                'geographic_data' => [
                    'US' => rand(30, 50),
                    'CA' => rand(10, 20),
                    'UK' => rand(5, 15),
                    'AU' => rand(5, 10),
                ],
            ]);
        }

        echo "\n🎉 MongoDB seeding completed successfully!\n";
        echo "📊 Created:\n";
        echo "   - " . count($mongoCategories) . " categories\n";
        echo "   - " . count($mongoProducts) . " products\n";
        echo "   - " . count($mongoProducts) . " analytics records\n\n";
    }
}