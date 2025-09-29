<?php
// Quick Laravel test for Azure deployment
echo "Laravel Azure Test\n";
echo "==================\n\n";

// Test 1: Check if we're in the right directory
echo "1. Current directory: " . getcwd() . "\n";

// Test 2: Check if key Laravel files exist
$files = ['index.php', '.env', 'vendor/autoload.php', 'bootstrap/app.php'];
foreach ($files as $file) {
    echo "2. File '$file': " . (file_exists($file) ? "✅ EXISTS" : "❌ MISSING") . "\n";
}

// Test 3: Check .env content
if (file_exists('.env')) {
    echo "\n3. .env file contents:\n";
    echo "---------------------\n";
    echo file_get_contents('.env');
    echo "---------------------\n";
} else {
    echo "\n3. ❌ .env file is missing!\n";
}

// Test 4: Try to load Laravel
echo "\n4. Testing Laravel bootstrap:\n";
try {
    if (file_exists('vendor/autoload.php')) {
        require 'vendor/autoload.php';
        echo "✅ Autoloader loaded successfully\n";

        if (file_exists('bootstrap/app.php')) {
            $app = require_once 'bootstrap/app.php';
            echo "✅ Laravel app bootstrapped successfully\n";
            echo "App environment: " . (defined('APP_ENV') ? APP_ENV : 'unknown') . "\n";
        } else {
            echo "❌ bootstrap/app.php not found\n";
        }
    } else {
        echo "❌ vendor/autoload.php not found\n";
    }
} catch (Exception $e) {
    echo "❌ Laravel bootstrap failed: " . $e->getMessage() . "\n";
}

echo "\n5. Test completed!\n";
