<?php
// Simple test file to verify Laravel is working
echo "=== TechBuy Laravel Test ===\n";
echo "Current Directory: " . getcwd() . "\n";
echo "PHP Version: " . phpversion() . "\n";

// Test if Laravel autoloader works
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo "Autoloader: Found\n";
    require __DIR__ . '/vendor/autoload.php';
    
    // Test if Laravel app can be created
    try {
        $app = require_once __DIR__ . '/bootstrap/app.php';
        echo "Laravel App: Created\n";
        
        // Test database connection
        try {
            $pdo = $app->make('db')->connection()->getPdo();
            echo "Database: Connected\n";
        } catch (Exception $e) {
            echo "Database Error: " . $e->getMessage() . "\n";
        }
        
        // Test if routes are loaded
        $routes = $app->make('router')->getRoutes();
        echo "Routes Count: " . count($routes) . "\n";
        
        // Test home route specifically
        try {
            $request = Illuminate\Http\Request::create('/');
            $response = $app->handle($request);
            echo "Home Route Status: " . $response->getStatusCode() . "\n";
        } catch (Exception $e) {
            echo "Home Route Error: " . $e->getMessage() . "\n";
        }
        
    } catch (Exception $e) {
        echo "Laravel Error: " . $e->getMessage() . "\n";
    }
} else {
    echo "Autoloader: NOT FOUND\n";
}

echo "=== Test Complete ===\n";
?>