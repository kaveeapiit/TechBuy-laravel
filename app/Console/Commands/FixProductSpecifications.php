<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class FixProductSpecifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:fix-specifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix product specifications that are stored as JSON strings instead of arrays';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔧 Fixing product specifications data...');

        $products = Product::whereNotNull('specifications')->get();
        $fixedCount = 0;
        $errorCount = 0;

        foreach ($products as $product) {
            try {
                $specifications = $product->getAttributes()['specifications']; // Get raw attribute

                // Check if it's a JSON string
                if (is_string($specifications)) {
                    $decoded = json_decode($specifications, true);

                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        // Update the product with properly decoded specifications
                        DB::table('products')
                            ->where('id', $product->id)
                            ->update(['specifications' => json_encode($decoded)]);

                        $this->line("✅ Fixed: {$product->name}");
                        $fixedCount++;
                    } else {
                        $this->warn("⚠️  Invalid JSON in: {$product->name}");
                        $errorCount++;
                    }
                } else {
                    $this->line("ℹ️  Already correct: {$product->name}");
                }
            } catch (\Exception $e) {
                $this->error("❌ Error fixing {$product->name}: " . $e->getMessage());
                $errorCount++;
            }
        }

        $this->newLine();
        $this->info("🎉 Specifications fix completed!");
        $this->table(
            ['Status', 'Count'],
            [
                ['Fixed', $fixedCount],
                ['Errors', $errorCount],
                ['Total Processed', $products->count()],
            ]
        );

        if ($fixedCount > 0) {
            $this->info('✅ All product specifications should now work correctly in the frontend!');
        }

        return 0;
    }
}
