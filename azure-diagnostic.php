<?php

/**
 * Azure Database Diagnostic Tool
 * Run this via: php azure-diagnostic.php
 */

echo "🔍 Azure Database Connection Diagnostics\n";
echo "=======================================\n\n";

// Check environment variables
echo "1. 📋 Environment Variables:\n";
echo "   APP_ENV: " . (env('APP_ENV') ?: 'Not set') . "\n";
echo "   DB_HOST: " . (env('DB_HOST') ?: 'Not set') . "\n";
echo "   DB_DATABASE: " . (env('DB_DATABASE') ?: 'Not set') . "\n";
echo "   DB_USERNAME: " . (env('DB_USERNAME') ?: 'Not set') . "\n";
echo "   DB_PASSWORD: " . (env('DB_PASSWORD') ? '***SET***' : 'Not set') . "\n";
echo "   MONGODB_HOST: " . (env('MONGODB_HOST') ?: 'Not set') . "\n";
echo "   MONGODB_DATABASE: " . (env('MONGODB_DATABASE') ?: 'Not set') . "\n\n";

// Test PostgreSQL connection
echo "2. 🗄️ PostgreSQL Connection Test:\n";
try {
    $pdo = new PDO(
        'pgsql:host=' . env('DB_HOST') . ';port=' . (env('DB_PORT') ?: 5432) . ';dbname=' . env('DB_DATABASE'),
        env('DB_USERNAME'),
        env('DB_PASSWORD'),
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo "   ✅ PostgreSQL: Connected successfully!\n";

    $stmt = $pdo->query('SELECT version()');
    $version = $stmt->fetchColumn();
    echo "   📋 Version: " . $version . "\n";

    // Test if tables exist
    $stmt = $pdo->query("SELECT count(*) FROM information_schema.tables WHERE table_schema = 'public'");
    $tableCount = $stmt->fetchColumn();
    echo "   📊 Tables: " . $tableCount . " tables found\n";
} catch (Exception $e) {
    echo "   ❌ PostgreSQL Error: " . $e->getMessage() . "\n";
}
echo "\n";

// Test MongoDB connection
echo "3. 🍃 MongoDB Connection Test:\n";
try {
    if (class_exists('MongoDB\Driver\Manager')) {
        $mongoHost = env('MONGODB_HOST');
        $mongoPort = env('MONGODB_PORT', 27017);
        $mongoDb = env('MONGODB_DATABASE');

        $uri = "mongodb://{$mongoHost}:{$mongoPort}";
        if (env('MONGODB_USERNAME') && env('MONGODB_PASSWORD')) {
            $uri = "mongodb://" . env('MONGODB_USERNAME') . ":" . env('MONGODB_PASSWORD') . "@{$mongoHost}:{$mongoPort}";
        }

        $manager = new MongoDB\Driver\Manager($uri);
        $command = new MongoDB\Driver\Command(['ping' => 1]);
        $result = $manager->executeCommand($mongoDb, $command);
        echo "   ✅ MongoDB: Connected successfully!\n";

        // List collections
        $command = new MongoDB\Driver\Command(['listCollections' => 1]);
        $result = $manager->executeCommand($mongoDb, $command);
        $collections = $result->toArray();
        echo "   📊 Collections: " . count($collections) . " collections found\n";
    } else {
        echo "   ⚠️ MongoDB PHP driver not installed\n";
    }
} catch (Exception $e) {
    echo "   ❌ MongoDB Error: " . $e->getMessage() . "\n";
}
echo "\n";

// Test Laravel database
echo "4. 🔧 Laravel Database Test:\n";
try {
    // Load Laravel
    require_once __DIR__ . '/vendor/autoload.php';
    $app = require_once __DIR__ . '/bootstrap/app.php';

    // Test database
    $userCount = App\Models\User::count();
    echo "   ✅ Laravel DB: Connected successfully!\n";
    echo "   👥 Users: " . $userCount . "\n";

    $productCount = App\Models\Product::count();
    echo "   📦 Products: " . $productCount . "\n";

    $categoryCount = App\Models\Category::count();
    echo "   📁 Categories: " . $categoryCount . "\n";
} catch (Exception $e) {
    echo "   ❌ Laravel DB Error: " . $e->getMessage() . "\n";
}
echo "\n";

// Check file permissions
echo "5. 📁 File System Check:\n";
$paths = [
    '/home/site/wwwroot/storage' => 'Storage directory',
    '/home/site/wwwroot/bootstrap/cache' => 'Bootstrap cache',
    '/home/site/wwwroot/database' => 'Database directory'
];

foreach ($paths as $path => $description) {
    if (file_exists($path)) {
        $permissions = substr(sprintf('%o', fileperms($path)), -4);
        echo "   ✅ {$description}: {$permissions}\n";
    } else {
        echo "   ❌ {$description}: Not found\n";
    }
}

echo "\n🏁 Diagnostic Complete!\n";
echo "Run this script in Azure Console: php azure-diagnostic.php\n";
