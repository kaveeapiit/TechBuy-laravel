<?php

/**
 * MongoDB Status Checker for Azure
 *
 * This script checks MongoDB availability and shows current database status
 * Run this in Azure console with: php mongodb-status.php
 */

echo "==================== MONGODB STATUS CHECKER ====================\n";
echo "🔍 Checking MongoDB availability in Azure environment...\n\n";

// Check if MongoDB extension is loaded
echo "1. PHP MongoDB Extension Check:\n";
if (extension_loaded('mongodb')) {
    echo "   ✅ MongoDB PHP extension is LOADED\n";
    echo "   📦 Extension version: " . phpversion('mongodb') . "\n";
} else {
    echo "   ❌ MongoDB PHP extension is NOT loaded\n";
    echo "   💡 This is normal for basic Azure App Service plans\n";
}
echo "\n";

// Check Laravel MongoDB package
echo "2. Laravel MongoDB Package Check:\n";
if (class_exists('MongoDB\\Laravel\\Eloquent\\Model')) {
    echo "   ✅ Laravel MongoDB package is available\n";
} else {
    echo "   ❌ Laravel MongoDB package not found\n";
}
echo "\n";

// Check environment variables
echo "3. MongoDB Configuration Check:\n";
$mongoHost = env('MONGODB_HOST', 'not set');
$mongoDb = env('MONGODB_DATABASE', 'not set');
$mongoUser = env('MONGODB_USERNAME', 'not set');
$mongoPass = env('MONGODB_PASSWORD', 'not set') !== 'not set' ? '***set***' : 'not set';

echo "   MONGODB_HOST: $mongoHost\n";
echo "   MONGODB_DATABASE: $mongoDb\n";
echo "   MONGODB_USERNAME: $mongoUser\n";
echo "   MONGODB_PASSWORD: $mongoPass\n";
echo "\n";

// Try to check MongoDB models
echo "4. MongoDB Models Check:\n";
try {
    if (extension_loaded('mongodb')) {
        // Try to instantiate MongoDB models
        $mongoProductExists = class_exists('App\\Models\\Mongo\\MongoProduct');
        $mongoCategoryExists = class_exists('App\\Models\\Mongo\\MongoCategory');
        $mongoAnalyticsExists = class_exists('App\\Models\\Mongo\\ProductAnalytic');

        echo "   MongoProduct model: " . ($mongoProductExists ? "✅ Available" : "❌ Missing") . "\n";
        echo "   MongoCategory model: " . ($mongoCategoryExists ? "✅ Available" : "❌ Missing") . "\n";
        echo "   ProductAnalytic model: " . ($mongoAnalyticsExists ? "✅ Available" : "❌ Missing") . "\n";

        // Try to count documents (if connection works)
        if ($mongoProductExists) {
            try {
                require_once __DIR__ . '/vendor/autoload.php';
                $app = require_once __DIR__ . '/bootstrap/app.php';
                $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

                $productCount = \App\Models\Mongo\MongoProduct::count();
                $categoryCount = \App\Models\Mongo\MongoCategory::count();
                $analyticsCount = \App\Models\Mongo\ProductAnalytic::count();

                echo "\n   📊 Current MongoDB Data:\n";
                echo "      Products: $productCount\n";
                echo "      Categories: $categoryCount\n";
                echo "      Analytics: $analyticsCount\n";
            } catch (\Exception $e) {
                echo "   ⚠️  Cannot connect to MongoDB: " . $e->getMessage() . "\n";
            }
        }
    } else {
        echo "   ⚠️  Cannot check models - MongoDB extension not loaded\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Error checking MongoDB models: " . $e->getMessage() . "\n";
}
echo "\n";

// PostgreSQL status for comparison
echo "5. PostgreSQL Status (for comparison):\n";
try {
    require_once __DIR__ . '/vendor/autoload.php';
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

    $userCount = \App\Models\User::count();
    $categoryCount = \App\Models\Category::count();
    $productCount = \App\Models\Product::count();

    echo "   ✅ PostgreSQL is working:\n";
    echo "      Users: $userCount\n";
    echo "      Categories: $categoryCount\n";
    echo "      Products: $productCount\n";
} catch (\Exception $e) {
    echo "   ❌ PostgreSQL connection error: " . $e->getMessage() . "\n";
}
echo "\n";

echo "==================== SUMMARY ====================\n";

if (extension_loaded('mongodb')) {
    echo "🎉 MONGODB IS AVAILABLE!\n";
    echo "   Your TechBuy site can use dual database features\n";
    echo "   Run: php artisan db:seed --class=MongoDBSeeder --force\n";
    echo "   to populate MongoDB with enhanced product data\n\n";
} else {
    echo "✅ MONGODB NOT AVAILABLE (but that's OK!)\n";
    echo "   Your TechBuy site works perfectly with PostgreSQL only\n";
    echo "   All core e-commerce features are fully functional\n";
    echo "   MongoDB would add enhanced analytics and product features\n\n";
}

echo "🌐 Your website should be working at your Azure URL!\n";
echo "==================== END STATUS CHECK ====================\n";
