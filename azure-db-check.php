<?php

/**
 * Quick Azure Database Diagnostic
 * Run: php azure-db-check.php
 */

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

echo "🔍 Azure Database Diagnostic\n";
echo "===========================\n\n";

// Check environment
echo "Environment: " . app()->environment() . "\n";
echo "DB Connection: " . config('database.default') . "\n";
echo "DB Host: " . config('database.connections.pgsql.host') . "\n";
echo "DB Database: " . config('database.connections.pgsql.database') . "\n\n";

// Test connection
try {
    DB::connection()->getPdo();
    echo "✅ Database connection: WORKING\n\n";
} catch (Exception $e) {
    echo "❌ Database connection: FAILED\n";
    echo "Error: " . $e->getMessage() . "\n\n";
    exit(1);
}

// Check if migrations table exists
try {
    $migrationsExist = DB::connection()->getSchemaBuilder()->hasTable('migrations');
    echo "Migrations table: " . ($migrationsExist ? "EXISTS" : "MISSING") . "\n";
} catch (Exception $e) {
    echo "❌ Cannot check migrations table: " . $e->getMessage() . "\n";
}

// Check tables
$tables = ['users', 'products', 'categories', 'orders'];
echo "\nTable Status:\n";
foreach ($tables as $table) {
    try {
        $exists = DB::connection()->getSchemaBuilder()->hasTable($table);
        if ($exists) {
            $count = DB::table($table)->count();
            echo "  {$table}: EXISTS ({$count} records)\n";
        } else {
            echo "  {$table}: MISSING\n";
        }
    } catch (Exception $e) {
        echo "  {$table}: ERROR - " . $e->getMessage() . "\n";
    }
}

echo "\n🔧 Next Steps:\n";
echo "If tables are MISSING: php artisan migrate --force\n";
echo "If tables are EMPTY: php artisan db:seed --force\n";
echo "To reset everything: php artisan migrate:fresh --seed --force\n";
