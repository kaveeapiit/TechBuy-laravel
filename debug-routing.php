<?php

/**
 * Azure Route Debug Tool
 * This script helps debug routing issues in Azure App Service
 */

echo "==================== AZURE ROUTING DEBUG ====================\n";

// Check environment
echo "🔍 Environment Check:\n";
echo "   WEBSITE_SITE_NAME: " . ($_SERVER['WEBSITE_SITE_NAME'] ?? 'not set') . "\n";
echo "   HTTP_HOST: " . ($_SERVER['HTTP_HOST'] ?? 'not set') . "\n";
echo "   REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'not set') . "\n";
echo "   REQUEST_METHOD: " . ($_SERVER['REQUEST_METHOD'] ?? 'not set') . "\n";
echo "   SCRIPT_NAME: " . ($_SERVER['SCRIPT_NAME'] ?? 'not set') . "\n";
echo "   PATH_INFO: " . ($_SERVER['PATH_INFO'] ?? 'not set') . "\n";
echo "   QUERY_STRING: " . ($_SERVER['QUERY_STRING'] ?? 'not set') . "\n";

// Check file existence
echo "\n📂 File System Check:\n";
echo "   index.php exists: " . (file_exists(__DIR__ . '/index.php') ? '✅' : '❌') . "\n";
echo "   web.config exists: " . (file_exists(__DIR__ . '/web.config') ? '✅' : '❌') . "\n";
echo "   .htaccess exists: " . (file_exists(__DIR__ . '/.htaccess') ? '✅' : '❌') . "\n";
echo "   public/index.php exists: " . (file_exists(__DIR__ . '/public/index.php') ? '✅' : '❌') . "\n";

// Check Laravel bootstrap
echo "\n⚙️  Laravel Bootstrap Check:\n";
try {
    require_once __DIR__ . '/vendor/autoload.php';
    echo "   Autoloader: ✅ Loaded\n";

    $app = require_once __DIR__ . '/bootstrap/app.php';
    echo "   App Bootstrap: ✅ Loaded\n";

    $kernel = $app->make('Illuminate\Contracts\Console\Kernel');
    $kernel->bootstrap();
    echo "   Kernel Bootstrap: ✅ Loaded\n";

    // Test route resolution
    $router = app('router');
    $routes = $router->getRoutes();
    echo "   Routes Loaded: ✅ " . count($routes) . " routes\n";

    // Check specific routes
    $testRoutes = ['/login', '/register', '/dashboard', '/products'];
    foreach ($testRoutes as $route) {
        try {
            $routeMatch = $router->getRoutes()->match(
                \Illuminate\Http\Request::create($route, 'GET')
            );
            echo "   Route '$route': ✅ Found\n";
        } catch (\Exception $e) {
            echo "   Route '$route': ❌ " . $e->getMessage() . "\n";
        }
    }
} catch (\Exception $e) {
    echo "   ❌ Laravel Bootstrap Error: " . $e->getMessage() . "\n";
}

// Check URL rewriting
echo "\n🔄 URL Rewrite Test:\n";
$testUrls = [
    '/login',
    '/register',
    '/dashboard',
    '/products'
];

foreach ($testUrls as $url) {
    echo "   Testing: $url\n";

    // Simulate what should happen
    if (!file_exists(__DIR__ . $url) && !is_dir(__DIR__ . $url)) {
        echo "     → Should rewrite to index.php\n";
    } else {
        echo "     → File/directory exists\n";
    }
}

echo "\n🛠️  Recommended Fixes:\n";
echo "1. Ensure web.config is properly configured for Azure\n";
echo "2. Check if IIS URL Rewrite module is enabled\n";
echo "3. Verify Laravel routes are properly defined\n";
echo "4. Test with direct index.php access\n";

echo "\n🔗 Direct Test Links (add these to your Azure URL):\n";
echo "   /debug-routing.php - This script\n";
echo "   /index.php/login - Direct Laravel routing test\n";
echo "   /index.php/register - Direct Laravel routing test\n";

echo "\n==================== DEBUG COMPLETE ====================\n";
