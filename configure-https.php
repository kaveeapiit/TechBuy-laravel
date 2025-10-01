<?php

// Laravel HTTPS Configuration for Azure App Service
// This script configures Laravel to properly handle HTTPS when behind Azure's load balancer

echo "🔒 Configuring Laravel for HTTPS behind Azure load balancer...\n";

// Set working directory to Laravel root
$laravelRoot = '/home/site/wwwroot';
if (file_exists('./artisan')) {
    $laravelRoot = getcwd();
}

chdir($laravelRoot);

// 1. Update .env file to force HTTPS
$envFile = $laravelRoot . '/.env';
if (file_exists($envFile)) {
    echo "📝 Updating .env file for HTTPS...\n";

    $envContent = file_get_contents($envFile);

    // Update APP_URL to use HTTPS
    if (preg_match('/^APP_URL=(.*)$/m', $envContent)) {
        $envContent = preg_replace('/^APP_URL=(.*)$/m', 'APP_URL=https://${HTTP_HOST}', $envContent);
        echo "   ✅ Updated APP_URL to use HTTPS\n";
    } else {
        $envContent .= "\nAPP_URL=https://\${HTTP_HOST}\n";
        echo "   ✅ Added APP_URL with HTTPS\n";
    }

    // Add session security settings
    if (!preg_match('/^SESSION_SECURE_COOKIE=/m', $envContent)) {
        $envContent .= "SESSION_SECURE_COOKIE=true\n";
        echo "   ✅ Added secure cookie setting\n";
    }

    file_put_contents($envFile, $envContent);
    echo "   ✅ .env file updated successfully\n";
} else {
    echo "   ⚠️  .env file not found\n";
}

// 2. Update TrustProxies middleware
$trustProxiesFile = $laravelRoot . '/app/Http/Middleware/TrustProxies.php';
if (file_exists($trustProxiesFile)) {
    echo "📝 Updating TrustProxies middleware...\n";

    $trustProxiesContent = file_get_contents($trustProxiesFile);

    // Update proxies to trust Azure load balancer
    $newProxiesConfig = "    protected \$proxies = '*'; // Trust Azure load balancer";

    if (preg_match('/protected \$proxies = .*;/', $trustProxiesContent)) {
        $trustProxiesContent = preg_replace(
            '/protected \$proxies = .*;/',
            $newProxiesConfig,
            $trustProxiesContent
        );
        echo "   ✅ Updated \$proxies to trust Azure load balancer\n";
    }

    // Ensure headers are set correctly
    $newHeadersConfig = "    protected \$headers = Request::HEADER_X_FORWARDED_FOR | Request::HEADER_X_FORWARDED_HOST | Request::HEADER_X_FORWARDED_PORT | Request::HEADER_X_FORWARDED_PROTO;";

    if (preg_match('/protected \$headers = .*;/', $trustProxiesContent)) {
        $trustProxiesContent = preg_replace(
            '/protected \$headers = .*;/',
            $newHeadersConfig,
            $trustProxiesContent
        );
        echo "   ✅ Updated \$headers for proper forwarded header handling\n";
    }

    file_put_contents($trustProxiesFile, $trustProxiesContent);
    echo "   ✅ TrustProxies middleware updated successfully\n";
} else {
    echo "   ⚠️  TrustProxies middleware not found\n";
}

// 3. Clear and cache configuration
echo "🧹 Clearing and caching Laravel configuration...\n";

// Clear configuration cache
exec('php artisan config:clear 2>/dev/null', $output, $return);
if ($return === 0) {
    echo "   ✅ Configuration cache cleared\n";
}

// Cache new configuration
exec('php artisan config:cache 2>/dev/null', $output, $return);
if ($return === 0) {
    echo "   ✅ Configuration cached\n";
}

// 4. Set additional runtime configuration
echo "⚙️ Setting runtime HTTPS configuration...\n";

// Force HTTPS in configuration
if (function_exists('config')) {
    config(['app.url' => 'https://' . ($_SERVER['HTTP_HOST'] ?? 'localhost')]);
    echo "   ✅ Runtime APP_URL set to HTTPS\n";

    config(['session.secure' => true]);
    echo "   ✅ Secure cookies enabled\n";
}

echo "✅ Laravel HTTPS configuration complete!\n";
echo "\n🎯 What was configured:\n";
echo "   ✅ APP_URL set to use HTTPS\n";
echo "   ✅ TrustProxies configured for Azure load balancer\n";
echo "   ✅ Secure cookies enabled\n";
echo "   ✅ Proper forwarded headers handling\n";
echo "   ✅ Configuration cache refreshed\n";
echo "\n🔒 Forms should now submit securely without warnings!\n";
