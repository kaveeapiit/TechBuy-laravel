<?php
// CSRF Debug Script for Laravel HTTPS issues
// Access via: https://your-app.azurewebsites.net/csrf-debug.php

echo "🛡️ CSRF Token Debug Information\n";
echo "===============================\n\n";

// Check if we're in Laravel environment
if (file_exists('bootstrap/app.php')) {
    require_once 'bootstrap/app.php';
    $app = $app ?? null;

    if ($app) {
        echo "✅ Laravel application loaded\n\n";

        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Display session information
        echo "📋 Session Information:\n";
        echo "   Session ID: " . session_id() . "\n";
        echo "   Session Status: " . (session_status() === PHP_SESSION_ACTIVE ? "Active" : "Inactive") . "\n";
        echo "   Session Name: " . session_name() . "\n";
        echo "   Session Cookie Params:\n";
        $params = session_get_cookie_params();
        foreach ($params as $key => $value) {
            echo "      $key: " . (is_bool($value) ? ($value ? 'true' : 'false') : $value) . "\n";
        }
        echo "\n";

        // Display environment information
        echo "🌐 Environment Information:\n";
        echo "   APP_URL: " . env('APP_URL', 'Not set') . "\n";
        echo "   APP_ENV: " . env('APP_ENV', 'Not set') . "\n";
        echo "   SESSION_DRIVER: " . env('SESSION_DRIVER', 'Not set') . "\n";
        echo "   SESSION_SECURE_COOKIE: " . env('SESSION_SECURE_COOKIE', 'Not set') . "\n";
        echo "   SESSION_DOMAIN: " . env('SESSION_DOMAIN', 'Not set') . "\n";
        echo "   SESSION_SAME_SITE: " . env('SESSION_SAME_SITE', 'Not set') . "\n";
        echo "\n";

        // Display server variables
        echo "🔍 Server Variables:\n";
        $important_vars = [
            'HTTPS',
            'HTTP_X_FORWARDED_PROTO',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED_HOST',
            'HTTP_X_FORWARDED_PORT',
            'SERVER_PORT',
            'HTTP_HOST',
            'REQUEST_URI',
            'REQUEST_METHOD'
        ];

        foreach ($important_vars as $var) {
            echo "   $var: " . ($_SERVER[$var] ?? 'Not set') . "\n";
        }
        echo "\n";

        // Check CSRF token generation
        echo "🛡️ CSRF Token Information:\n";
        try {
            // Try to generate CSRF token
            if (function_exists('csrf_token')) {
                $token = csrf_token();
                echo "   CSRF Token: " . substr($token, 0, 20) . "... (truncated)\n";
                echo "   Token Length: " . strlen($token) . " characters\n";
            } else {
                echo "   ❌ csrf_token() function not available\n";
            }
        } catch (Exception $e) {
            echo "   ❌ Error generating CSRF token: " . $e->getMessage() . "\n";
        }

        // Check session storage
        echo "\n📁 Session Storage:\n";
        $sessionPath = storage_path('framework/sessions');
        if (is_dir($sessionPath)) {
            echo "   Session Path: $sessionPath\n";
            echo "   Directory Writable: " . (is_writable($sessionPath) ? "Yes" : "No") . "\n";
            $sessionFiles = glob($sessionPath . '/*');
            echo "   Session Files Count: " . count($sessionFiles) . "\n";
        } else {
            echo "   ❌ Session directory not found: $sessionPath\n";
        }
    } else {
        echo "❌ Failed to load Laravel application\n";
    }
} else {
    echo "❌ Not in Laravel directory\n";
}

echo "\n🧪 Quick Test Form:\n";
echo "===================\n";
echo '<form method="POST" action="/login" style="margin: 20px 0;">';
echo '<input type="hidden" name="_token" value="' . (function_exists('csrf_token') ? csrf_token() : 'NOT_AVAILABLE') . '">';
echo '<input type="email" name="email" placeholder="test@example.com" required>';
echo '<input type="password" name="password" placeholder="password" required>';
echo '<button type="submit">Test Login Form</button>';
echo '</form>';

echo "\n💡 Troubleshooting Tips:\n";
echo "========================\n";
echo "1. If CSRF token is 'NOT_AVAILABLE', Laravel may not be properly loaded\n";
echo "2. If session directory is not writable, check file permissions\n";
echo "3. If HTTPS is not detected, check nginx FastCGI parameters\n";
echo "4. If session cookies aren't secure, check .env configuration\n";
echo "5. Clear all caches after making changes: php artisan cache:clear\n";
