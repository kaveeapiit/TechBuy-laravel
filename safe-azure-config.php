<?php

// SAFE Azure CSRF Configuration Script
// This script ONLY updates .env file without risky operations

echo "🛡️ SAFE Azure CSRF Configuration...\n";

// Set working directory to Laravel root
$laravelRoot = '/home/site/wwwroot';
if (file_exists('./artisan')) {
    $laravelRoot = getcwd();
}

chdir($laravelRoot);

// ONLY update .env file - no risky operations
$envFile = $laravelRoot . '/.env';
if (file_exists($envFile)) {
    echo "📝 Updating .env file (SAFE MODE)...\n";
    
    $envContent = file_get_contents($envFile);
    
    // Update APP_URL
    if (preg_match('/^APP_URL=(.*)$/m', $envContent)) {
        $envContent = preg_replace('/^APP_URL=(.*)$/m', 'APP_URL=https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net', $envContent);
        echo "   ✅ Updated APP_URL\n";
    } else {
        $envContent .= "\nAPP_URL=https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net\n";
        echo "   ✅ Added APP_URL\n";
    }
    
    // Add SESSION_DOMAIN
    if (!preg_match('/^SESSION_DOMAIN=/m', $envContent)) {
        $envContent .= "SESSION_DOMAIN=techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net\n";
        echo "   ✅ Added SESSION_DOMAIN\n";
    }
    
    // Add SESSION_SECURE_COOKIE
    if (!preg_match('/^SESSION_SECURE_COOKIE=/m', $envContent)) {
        $envContent .= "SESSION_SECURE_COOKIE=true\n";
        echo "   ✅ Added SESSION_SECURE_COOKIE\n";
    }
    
    file_put_contents($envFile, $envContent);
    echo "   ✅ .env updated safely\n";
} else {
    echo "   ⚠️  .env file not found\n";
}

echo "\n✅ SAFE configuration complete!\n";
echo "   - No risky exec() commands\n";
echo "   - No bootstrap file modifications\n"; 
echo "   - Only essential .env updates\n";

?>