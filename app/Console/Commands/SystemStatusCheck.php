<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Category;

class SystemStatusCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:status {--mongodb : Check MongoDB status specifically}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check system status and MongoDB requirements for dual database setup';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 TechBuy System Status Check');
        $this->line('================================');
        $this->newLine();

        // Check PHP version
        $this->checkPHPVersion();

        // Check Laravel installation
        $this->checkLaravelStatus();

        // Check PostgreSQL status
        $this->checkPostgreSQLStatus();

        // Check MongoDB status
        $this->checkMongoDBStatus();

        // Show summary
        $this->showSummary();
    }

    protected function checkPHPVersion()
    {
        $phpVersion = PHP_VERSION;
        $this->info("📋 PHP Version: {$phpVersion}");

        if (version_compare($phpVersion, '8.0', '>=')) {
            $this->line('   ✅ PHP version is compatible');
        } else {
            $this->error('   ❌ PHP 8.0+ required for optimal performance');
        }
        $this->newLine();
    }

    protected function checkLaravelStatus()
    {
        $laravelVersion = app()->version();
        $this->info("🚀 Laravel Version: {$laravelVersion}");
        $this->line('   ✅ Laravel is running properly');
        $this->newLine();
    }

    protected function checkPostgreSQLStatus()
    {
        $this->info('🐘 PostgreSQL Database Status:');

        try {
            $productCount = Product::count();
            $categoryCount = Category::count();

            $this->line("   ✅ PostgreSQL connection: Active");
            $this->line("   📊 Products: {$productCount}");
            $this->line("   📂 Categories: {$categoryCount}");
            $this->line("   💡 Status: Ready for MongoDB migration");
        } catch (\Exception $e) {
            $this->error('   ❌ PostgreSQL connection failed: ' . $e->getMessage());
        }
        $this->newLine();
    }

    protected function checkMongoDBStatus()
    {
        $this->info('🍃 MongoDB Status:');

        // Check PHP extension
        if (extension_loaded('mongodb')) {
            $this->line('   ✅ MongoDB PHP extension: Installed');

            // Check connection
            try {
                $mongoConfig = config('database.connections.mongodb');
                if ($mongoConfig) {
                    $this->line('   ✅ MongoDB configuration: Found');

                    // Try to connect
                    try {
                        $client = new \MongoDB\Client(
                            "mongodb://" . ($mongoConfig['host'] ?? 'localhost') .
                                ":" . ($mongoConfig['port'] ?? 27017)
                        );
                        $client->selectDatabase('admin')->command(['ping' => 1]);
                        $this->line('   ✅ MongoDB server: Connected');
                        $this->line('   🎉 Ready for migration!');
                    } catch (\Exception $e) {
                        $this->line('   ❌ MongoDB server: Not running');
                        $this->line('   💡 Run: brew services start mongodb/brew/mongodb-community');
                    }
                } else {
                    $this->line('   ❌ MongoDB configuration: Missing');
                }
            } catch (\Exception $e) {
                $this->line('   ❌ MongoDB setup error: ' . $e->getMessage());
            }
        } else {
            $this->line('   ❌ MongoDB PHP extension: Not installed');
            $this->newLine();
            $this->warn('   📋 Installation Required:');
            $this->line('   🍎 macOS: brew install mongodb/brew/mongodb-community && pecl install mongodb');
            $this->line('   🐧 Ubuntu: sudo apt-get install php-mongodb');
            $this->line('   🐳 Docker: docker run -d --name mongodb -p 27017:27017 mongo:7');
        }
        $this->newLine();
    }

    protected function showSummary()
    {
        $this->info('📊 System Summary:');
        $this->line('================');

        $postgresWorking = false;
        $mongodbReady = false;

        try {
            Product::count();
            $postgresWorking = true;
        } catch (\Exception $e) {
            // PostgreSQL not working
        }

        if (extension_loaded('mongodb')) {
            try {
                $mongoConfig = config('database.connections.mongodb');
                $client = new \MongoDB\Client(
                    "mongodb://" . ($mongoConfig['host'] ?? 'localhost') .
                        ":" . ($mongoConfig['port'] ?? 27017)
                );
                $client->selectDatabase('admin')->command(['ping' => 1]);
                $mongodbReady = true;
            } catch (\Exception $e) {
                // MongoDB not ready
            }
        }

        if ($postgresWorking && $mongodbReady) {
            $this->info('🎉 Status: Ready for full dual database operation!');
            $this->line('   Run: php artisan products:migrate-to-mongodb');
        } elseif ($postgresWorking && !$mongodbReady) {
            $this->warn('⚠️  Status: PostgreSQL ready, MongoDB setup needed');
            $this->line('   Current: Single database mode (PostgreSQL)');
            $this->line('   Next: Install MongoDB for enhanced features');
        } else {
            $this->error('❌ Status: Database configuration issues detected');
        }

        $this->newLine();
        $this->info('📚 Documentation:');
        $this->line('   • MONGODB_SETUP.md - Complete setup guide');
        $this->line('   • MONGODB_IMPLEMENTATION_SUMMARY.md - What\'s implemented');
    }
}
