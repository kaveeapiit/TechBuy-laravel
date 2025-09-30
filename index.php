<?php

/**
 * Root Index for Azure Deployment
 *
 * This file serves the application when deployed to Azure where we can't use
 * a proper public directory setup. For local development, Laravel should
 * still use the public/index.php file.
 */

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Check if we're in Azure environment
$isAzure = isset($_SERVER['WEBSITE_SITE_NAME']) ||
    (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'azurewebsites.net') !== false);

// For local development, redirect to proper public directory
if (!$isAzure && file_exists(__DIR__ . '/public/index.php') && PHP_SAPI !== 'cli') {
    // Check if this is a request for a static asset
    $requestUri = $_SERVER['REQUEST_URI'] ?? '';
    $staticExtensions = ['css', 'js', 'png', 'jpg', 'jpeg', 'gif', 'ico', 'svg', 'woff', 'woff2', 'ttf', 'eot'];
    $extension = pathinfo(parse_url($requestUri, PHP_URL_PATH), PATHINFO_EXTENSION);

    if (in_array(strtolower($extension), $staticExtensions)) {
        // Serve static files directly
        $filePath = __DIR__ . $requestUri;
        if (file_exists($filePath)) {
            $mimeTypes = [
                'css' => 'text/css',
                'js' => 'application/javascript',
                'png' => 'image/png',
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'gif' => 'image/gif',
                'ico' => 'image/x-icon',
                'svg' => 'image/svg+xml',
                'woff' => 'font/woff',
                'woff2' => 'font/woff2',
                'ttf' => 'font/ttf',
                'eot' => 'application/vnd.ms-fontobject'
            ];

            if (isset($mimeTypes[$extension])) {
                header('Content-Type: ' . $mimeTypes[$extension]);
            }
            readfile($filePath);
            exit;
        }
    } else {
        // For non-static requests in local environment, use public/index.php
        require_once __DIR__ . '/public/index.php';
        exit;
    }
}

// Azure deployment or CLI: serve from root
if (file_exists($maintenance = __DIR__ . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__ . '/vendor/autoload.php';

/** @var Application $app */
$app = require_once __DIR__ . '/bootstrap/app.php';

$app->handleRequest(Request::capture());
