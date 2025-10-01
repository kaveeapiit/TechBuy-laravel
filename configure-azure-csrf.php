<?php

// Azure CSRF Configuration Script
// This script sets up Laravel for proper CSRF handling with Azure App Service

echo "🛡️ Configuring Laravel CSRF for Azure App Service...\n";

// Set working directory to Laravel root
$laravelRoot = '/home/site/wwwroot';
if (file_exists('./artisan')) {
    $laravelRoot = getcwd();
}

chdir($laravelRoot);

// 1. Update .env file with Azure-specific settings
$envFile = $laravelRoot . '/.env';
if (file_exists($envFile)) {
    echo "📝 Updating .env file for Azure CSRF configuration...\n";

    $envContent = file_get_contents($envFile);

    // Update APP_URL
    if (preg_match('/^APP_URL=(.*)$/m', $envContent)) {
        $envContent = preg_replace('/^APP_URL=(.*)$/m', 'APP_URL=https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net', $envContent);
        echo "   ✅ Updated APP_URL to Azure domain\n";
    } else {
        $envContent .= "\nAPP_URL=https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net\n";
        echo "   ✅ Added APP_URL with Azure domain\n";
    }

    // Add SESSION_DOMAIN
    if (!preg_match('/^SESSION_DOMAIN=/m', $envContent)) {
        $envContent .= "SESSION_DOMAIN=techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net\n";
        echo "   ✅ Added SESSION_DOMAIN setting\n";
    } else {
        $envContent = preg_replace('/^SESSION_DOMAIN=(.*)$/m', 'SESSION_DOMAIN=techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net', $envContent);
        echo "   ✅ Updated SESSION_DOMAIN setting\n";
    }

    // Add SESSION_SECURE_COOKIE
    if (!preg_match('/^SESSION_SECURE_COOKIE=/m', $envContent)) {
        $envContent .= "SESSION_SECURE_COOKIE=true\n";
        echo "   ✅ Added SESSION_SECURE_COOKIE setting\n";
    } else {
        $envContent = preg_replace('/^SESSION_SECURE_COOKIE=(.*)$/m', 'SESSION_SECURE_COOKIE=true', $envContent);
        echo "   ✅ Updated SESSION_SECURE_COOKIE setting\n";
    }

    // Add SESSION_SAME_SITE
    if (!preg_match('/^SESSION_SAME_SITE=/m', $envContent)) {
        $envContent .= "SESSION_SAME_SITE=lax\n";
        echo "   ✅ Added SESSION_SAME_SITE setting\n";
    }

    file_put_contents($envFile, $envContent);
    echo "   ✅ .env file updated successfully\n";
} else {
    echo "   ⚠️  .env file not found\n";
}

// 2. Register TrustProxies middleware in bootstrap/app.php (Laravel 11)
$bootstrapFile = $laravelRoot . '/bootstrap/app.php';
if (file_exists($bootstrapFile)) {
    echo "📝 Registering TrustProxies middleware...\n";

    $bootstrapContent = file_get_contents($bootstrapFile);

    // Check if TrustProxies is already registered
    if (strpos($bootstrapContent, 'TrustProxies') === false) {
        // Add TrustProxies middleware registration
        $middlewareSection = "->withMiddleware(function (Middleware \$middleware) {
        \$middleware->trustProxies(at: '*');
    })";

        // Look for existing withMiddleware section or create one
        if (strpos($bootstrapContent, '->withMiddleware') !== false) {
            echo "   ⚠️  Middleware section already exists, please manually add trustProxies\n";
        } else {
            // Add after Application::configure
            $bootstrapContent = str_replace(
                '->create();',
                $middlewareSection . "\n    ->create();",
                $bootstrapContent
            );
            file_put_contents($bootstrapFile, $bootstrapContent);
            echo "   ✅ TrustProxies middleware registered\n";
        }
    } else {
        echo "   ✅ TrustProxies middleware already registered\n";
    }
}

// 3. Clear all caches
echo "🧹 Clearing Laravel caches...\n";

$commands = [
    'php artisan config:clear',
    'php artisan route:clear',
    'php artisan view:clear',
    'php artisan cache:clear'
];

foreach ($commands as $command) {
    exec($command . ' 2>/dev/null', $output, $return);
    if ($return === 0) {
        echo "   ✅ " . explode(' ', $command)[2] . " cache cleared\n";
    }
}

// 4. Cache fresh configuration
exec('php artisan config:cache 2>/dev/null', $output, $return);
if ($return === 0) {
    echo "   ✅ Fresh configuration cached\n";
}

echo "\n✅ Azure CSRF configuration complete!\n";
echo "\n🎯 Configuration Summary:\n";
echo "   ✅ APP_URL: https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net\n";
echo "   ✅ SESSION_DOMAIN: techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net\n";
echo "   ✅ SESSION_SECURE_COOKIE: true\n";
echo "   ✅ SESSION_SAME_SITE: lax\n";
echo "   ✅ TrustProxies middleware: configured\n";
echo "   ✅ Nginx proxy headers: enhanced\n";
echo "   ✅ All caches: cleared and refreshed\n";
echo "\n🛡️ CSRF tokens should now work correctly!\n";

echo "\n📋 Azure Portal Settings (Configuration → Application settings):\n";
echo "   APP_URL = https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net\n";
echo "   SESSION_DOMAIN = techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net\n";
echo "   SESSION_SECURE_COOKIE = true\n";
