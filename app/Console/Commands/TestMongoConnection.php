<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Mongo\PreOrder;
use Illuminate\Support\Facades\DB;

class TestMongoConnection extends Command
{
    protected $signature = 'test:mongodb';
    protected $description = 'Test MongoDB connection and functionality';

    public function handle()
    {
        $this->info('🔍 Testing MongoDB Connection...');

        // Check PHP extension
        if (!extension_loaded('mongodb')) {
            $this->error('❌ MongoDB PHP extension not loaded');
            return 1;
        }
        $this->info('✅ MongoDB PHP extension loaded');

        // Check configuration
        $config = config('database.connections.mongodb');
        $connectionString = $config['dsn'] ?? env('MONGODB_CONNECTION_STRING');

        if (!$connectionString) {
            $this->error('❌ MongoDB connection string not configured');
            return 1;
        }
        $this->info('✅ MongoDB connection string configured');

        // Test connection
        try {
            DB::connection('mongodb')->table('test')->get();
            $this->info('✅ MongoDB connection successful');
        } catch (\Exception $e) {
            $this->error('❌ MongoDB connection failed: ' . $e->getMessage());
            return 1;
        }

        // Test PreOrder model
        try {
            $testPreOrder = PreOrder::create([
                'user_id' => null,
                'name' => 'Test User',
                'email' => 'test@example.com',
                'mobile_number' => '1234567890',
                'preorder_item' => 'Test Item',
                'status' => 'pending',
            ]);

            $this->info('✅ Test pre-order created: ' . $testPreOrder->_id);

            // Clean up test data
            $testPreOrder->delete();
            $this->info('✅ Test pre-order deleted');
        } catch (\Exception $e) {
            $this->error('❌ PreOrder model test failed: ' . $e->getMessage());
            return 1;
        }

        $this->info('🎉 All MongoDB tests passed!');
        return 0;
    }
}
