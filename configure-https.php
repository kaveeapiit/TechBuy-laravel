<?php

/**
 * Laravel HTTPS Configuration for Azure
 * This script ensures Laravel recognizes HTTPS properly in Azure environment
 */

// Set environment variables for Laravel HTTPS detection
$httpsEnvVars = [
    'FORCE_HTTPS=true',
    'APP_FORCE_HTTPS=true',
    'TRUSTED_PROXIES=*',
    'TRUSTED_HEADERS=X-Forwarded-Proto,X-Forwarded-For,X-Forwarded-Host,X-Forwarded-Port',
];

echo "🔒 Configuring Laravel for HTTPS in Azure...\n";

// Check if .env file exists
if (!file_exists('.env')) {
    echo "❌ .env file not found!\n";
    exit(1);
}

// Read current .env content
$envContent = file_get_contents('.env');

foreach ($httpsEnvVars as $envVar) {
    list($key, $value) = explode('=', $envVar, 2);
    
    // Check if the key already exists
    if (preg_match("/^{$key}=/m", $envContent)) {
        // Update existing value
        $envContent = preg_replace("/^{$key}=.*/m", $envVar, $envContent);
        echo "✅ Updated {$key}\n";
    } else {
        // Add new value
        $envContent .= "\n{$envVar}";
        echo "✅ Added {$key}\n";
    }
}

// Write back to .env file
file_put_contents('.env', $envContent);

echo "\n🎯 Laravel HTTPS configuration completed!\n";
echo "\nConfiguration added:\n";
foreach ($httpsEnvVars as $envVar) {
    echo "  - {$envVar}\n";
}

echo "\n🔄 Please restart your app service for changes to take effect.\n";