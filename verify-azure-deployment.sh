#!/bin/bash

echo "🔍 Azure Deployment Verification"
echo "================================"

# Check PHP version
echo "📋 PHP Version:"
php --version

echo ""
echo "📋 PHP Extensions:"
php -m | grep -E "(mongodb|pdo|pgsql|openssl)"

echo ""
echo "📋 Environment Variables Check:"
echo "MONGODB_CONNECTION_STRING: ${MONGODB_CONNECTION_STRING:0:20}..."
echo "MONGODB_DATABASE: $MONGODB_DATABASE"
echo "DB_CONNECTION: $DB_CONNECTION"

echo ""
echo "🔌 Testing MongoDB Connection:"
php -r "
try {
    if (extension_loaded('mongodb')) {
        echo '✅ MongoDB extension loaded\n';

        \$connectionString = getenv('MONGODB_CONNECTION_STRING');
        if (\$connectionString) {
            \$manager = new MongoDB\Driver\Manager(\$connectionString);
            \$command = new MongoDB\Driver\Command(['ping' => 1]);
            \$result = \$manager->executeCommand('admin', \$command);
            echo '✅ MongoDB connection successful\n';

            // Test Laravel MongoDB connection
            echo '🔍 Testing Laravel MongoDB integration...\n';
            exec('php artisan test:mongodb 2>&1', \$output, \$returnCode);
            if (\$returnCode === 0) {
                echo '✅ Laravel MongoDB integration working\n';
            } else {
                echo '❌ Laravel MongoDB integration failed\n';
                echo implode('\n', \$output) . '\n';
            }
        } else {
            echo '❌ MONGODB_CONNECTION_STRING not set\n';
        }
    } else {
        echo '❌ MongoDB extension not loaded\n';
    }
} catch (Exception \$e) {
    echo '❌ MongoDB connection failed: ' . \$e->getMessage() . '\n';
}
"echo ""
echo "🔌 Testing PostgreSQL Connection:"
php -r "
try {
    if (extension_loaded('pdo_pgsql')) {
        echo '✅ PostgreSQL extension loaded\n';

        \$host = getenv('DB_HOST');
        \$dbname = getenv('DB_DATABASE');
        \$username = getenv('DB_USERNAME');
        \$password = getenv('DB_PASSWORD');

        if (\$host && \$dbname && \$username) {
            \$dsn = \"pgsql:host=\$host;dbname=\$dbname\";
            \$pdo = new PDO(\$dsn, \$username, \$password);
            echo '✅ PostgreSQL connection successful\n';
        } else {
            echo '❌ PostgreSQL environment variables not complete\n';
        }
    } else {
        echo '❌ PostgreSQL extension not loaded\n';
    }
} catch (Exception \$e) {
    echo '❌ PostgreSQL connection failed: ' . \$e->getMessage() . '\n';
}
"

echo ""
echo "📁 Laravel Configuration:"
cd /home/site/wwwroot
php artisan config:show database.connections.mongodb 2>/dev/null || echo "❌ MongoDB config not accessible"
php artisan config:show database.connections.pgsql 2>/dev/null || echo "❌ PostgreSQL config not accessible"

echo ""
echo "🎯 Verification Complete!"
