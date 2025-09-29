<?php
// Azure Laravel setup script
// This script handles Laravel setup tasks that might fail in Azure App Service

echo "Laravel Azure Setup Script\n";
echo "==========================\n";

// Set up necessary directories
$dirs = [
    '/home/site/wwwroot/storage/framework/cache/data',
    '/home/site/wwwroot/storage/framework/sessions', 
    '/home/site/wwwroot/storage/framework/views',
    '/home/site/wwwroot/storage/logs',
    '/home/site/wwwroot/bootstrap/cache'
];

echo "Creating Laravel directories...\n";
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
        echo "Created: $dir\n";
    }
}

// Change to Laravel directory
chdir('/home/site/wwwroot');

echo "Setting up environment...\n";

// Copy production env file if it exists
if (file_exists('.env.production') && !file_exists('.env')) {
    copy('.env.production', '.env');
    echo "Copied .env.production to .env\n";
}

// Load environment variables
if (file_exists('.env')) {
    $env = file_get_contents('.env');
    
    // Check if APP_KEY is empty or not set
    if (strpos($env, 'APP_KEY=') === false || strpos($env, 'APP_KEY=base64:') === false || preg_match('/APP_KEY=\s*$/', $env)) {
        echo "Generating application key...\n";
        
        // Generate a random 32-character key
        $key = 'base64:' . base64_encode(random_bytes(32));
        
        // Update the .env file
        if (strpos($env, 'APP_KEY=') !== false) {
            $env = preg_replace('/APP_KEY=.*/', "APP_KEY=$key", $env);
        } else {
            $env = "APP_KEY=$key\n" . $env;
        }
        
        file_put_contents('.env', $env);
        echo "Application key generated: $key\n";
    } else {
        echo "Application key already set\n";
    }
}

// Clear caches safely
echo "Clearing caches...\n";
if (is_dir('bootstrap/cache')) {
    $files = glob('bootstrap/cache/*.php');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
}

echo "Laravel Azure setup completed!\n";
?>