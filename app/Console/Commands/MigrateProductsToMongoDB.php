<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DualDatabaseService;

class MigrateProductsToMongoDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:migrate-to-mongodb {--force : Force migration even if products exist}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate products from PostgreSQL to MongoDB for dual database architecture';

    protected $dualDbService;

    public function __construct(DualDatabaseService $dualDbService)
    {
        parent::__construct();
        $this->dualDbService = $dualDbService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting product migration from PostgreSQL to MongoDB...');

        // Check if MongoDB extension is available
        if (!$this->checkMongoDBAvailability()) {
            return 1;
        }

        if ($this->option('force')) {
            $this->warn('Force migration enabled - existing MongoDB products may be overwritten');
        }

        try {
            $result = $this->dualDbService->migrateProductsToMongoDB();

            if ($result['success']) {
                $this->info('✅ ' . $result['message']);
                $this->info('Products have been successfully migrated to MongoDB!');

                // Show some statistics
                $this->newLine();
                $this->info('Migration Statistics:');
                $mongoProductCount = \App\Models\Mongo\MongoProduct::count();
                $postgresProductCount = \App\Models\Product::count();

                $this->table(
                    ['Database', 'Product Count'],
                    [
                        ['PostgreSQL', $postgresProductCount],
                        ['MongoDB', $mongoProductCount],
                    ]
                );
            } else {
                $this->error('❌ Migration failed: ' . $result['message']);
                return 1;
            }
        } catch (\Exception $e) {
            $this->error('❌ Migration failed with exception: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }

    /**
     * Check if MongoDB is available and properly configured
     */
    protected function checkMongoDBAvailability()
    {
        // Check if MongoDB extension is loaded
        if (!extension_loaded('mongodb')) {
            $this->error('❌ MongoDB PHP extension is not installed!');
            $this->newLine();

            $this->warn('The MongoDB PHP extension (ext-mongodb) is required for dual database functionality.');
            $this->newLine();

            $this->info('📋 Installation Instructions:');
            $this->line('');

            // macOS instructions
            $this->comment('🍎 For macOS (using Homebrew):');
            $this->line('   brew install mongodb/brew/mongodb-community');
            $this->line('   pecl install mongodb');
            $this->line('   echo "extension=mongodb.so" >> $(php --ini | grep "Loaded Configuration File" | cut -d: -f2 | xargs)');
            $this->line('');

            // Ubuntu/Debian instructions
            $this->comment('🐧 For Ubuntu/Debian:');
            $this->line('   sudo apt-get update');
            $this->line('   sudo apt-get install php-mongodb');
            $this->line('');

            // Docker alternative
            $this->comment('🐳 Alternative - Use Docker for MongoDB:');
            $this->line('   docker run -d --name mongodb -p 27017:27017 mongo:7');
            $this->line('   # Then install the PHP extension as above');
            $this->line('');

            $this->info('📖 For detailed setup instructions, see: MONGODB_SETUP.md');
            $this->newLine();

            // Show current PostgreSQL data
            $postgresProductCount = \App\Models\Product::count();
            $this->info("📊 Current PostgreSQL Data Ready for Migration:");
            $this->line("   Products: {$postgresProductCount}");
            $this->line("   Categories: " . \App\Models\Category::count());

            return false;
        }

        // Check if MongoDB connection is configured
        try {
            $mongoConfig = config('database.connections.mongodb');
            if (!$mongoConfig) {
                $this->error('❌ MongoDB connection not configured in database.php');
                return false;
            }
        } catch (\Exception $e) {
            $this->error('❌ MongoDB configuration error: ' . $e->getMessage());
            return false;
        }

        // Try to connect to MongoDB
        try {
            $testConnection = new \MongoDB\Client(
                "mongodb://" . config('database.connections.mongodb.host', 'localhost') .
                    ":" . config('database.connections.mongodb.port', 27017)
            );

            // Simple ping test
            $testConnection->selectDatabase('admin')->command(['ping' => 1]);
            $this->info('✅ MongoDB connection successful!');
        } catch (\Exception $e) {
            $this->error('❌ Cannot connect to MongoDB server: ' . $e->getMessage());
            $this->newLine();
            $this->warn('Make sure MongoDB server is running:');
            $this->line('   brew services start mongodb/brew/mongodb-community  # macOS');
            $this->line('   sudo systemctl start mongod                        # Linux');
            $this->line('   docker start mongodb                               # Docker');

            return false;
        }

        return true;
    }
}
