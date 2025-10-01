<?php
// Simple environment configuration for Azure
// This only sets essential variables without risky operations

$envFile = '/home/site/wwwroot/.env';
if (file_exists($envFile)) {
    $envContent = file_get_contents($envFile);

    // Ensure APP_URL is set for Azure
    if (!preg_match('/^APP_URL=/m', $envContent)) {
        $envContent .= "\nAPP_URL=https://techbuy-webapp-agbgf2gbgud8apaw.centralindia-01.azurewebsites.net\n";
        file_put_contents($envFile, $envContent);
        echo "✅ APP_URL configured for Azure\n";
    }

    // Ensure session security
    if (!preg_match('/^SESSION_SECURE_COOKIE=/m', $envContent)) {
        $envContent .= "SESSION_SECURE_COOKIE=true\n";
        file_put_contents($envFile, $envContent);
        echo "✅ Secure cookies enabled\n";
    }
}
?>
