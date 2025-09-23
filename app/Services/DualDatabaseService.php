<?php

namespace App\Services;

use App\Models\Product as PostgresProduct;
use App\Models\Category as PostgresCategory;
use App\Models\Mongo\MongoProduct;
use App\Models\Mongo\MongoCategory;
use App\Models\Mongo\ProductAnalytic;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DualDatabaseService
{
    /**
     * Check if MongoDB is available
     */
    protected function isMongoDBAvailable()
    {
        // Check if MongoDB extension is loaded
        if (!extension_loaded('mongodb')) {
            Log::warning('MongoDB extension not loaded');
            return false;
        }

        // Check if MongoDB models can be instantiated
        try {
            // Try to create a MongoDB connection
            $testModel = new MongoProduct();
            return true;
        } catch (\Exception $e) {
            Log::warning('MongoDB not available: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Migrate products from PostgreSQL to MongoDB
     */
    public function migrateProductsToMongoDB()
    {
        // Check if MongoDB is available
        if (!$this->isMongoDBAvailable()) {
            return [
                'success' => false,
                'message' => 'MongoDB is not available. Please install the MongoDB PHP extension.'
            ];
        }

        try {
            DB::transaction(function () {
                $postgresProducts = PostgresProduct::with('category')->get();

                foreach ($postgresProducts as $product) {
                    // Check if product already exists in MongoDB
                    $existingMongo = MongoProduct::where('postgres_id', $product->id)->first();

                    if (!$existingMongo) {
                        // Migrate category first
                        $mongoCategory = $this->migrateCategory($product->category);

                        // Create MongoDB product
                        $mongoProduct = MongoProduct::create([
                            'postgres_id' => $product->id,
                            'name' => $product->name,
                            'description' => $product->description,
                            'price' => $product->price,
                            'cost_price' => $product->cost_price ?? 0,
                            'sku' => $product->sku,
                            'barcode' => $product->barcode,
                            'stock_quantity' => $product->stock_quantity,
                            'low_stock_threshold' => $product->low_stock_threshold ?? 10,
                            'weight' => $product->weight,
                            'dimensions' => [
                                'length' => $product->length ?? 0,
                                'width' => $product->width ?? 0,
                                'height' => $product->height ?? 0,
                            ],
                            'category_id' => $mongoCategory->_id,
                            'category_name' => $mongoCategory->name,
                            'is_active' => $product->is_active ?? true,
                            'is_featured' => $product->is_featured ?? false,
                            'is_digital' => $product->is_digital ?? false,
                            'requires_shipping' => $product->requires_shipping ?? true,
                            'meta_title' => $product->meta_title,
                            'meta_description' => $product->meta_description,
                            'slug' => $product->slug,
                            'images' => is_string($product->images) ? json_decode($product->images, true) : $product->images,
                            'attributes' => is_string($product->attributes) ? json_decode($product->attributes, true) : $product->attributes,
                            'variants' => is_string($product->variants) ? json_decode($product->variants, true) : $product->variants,
                            'tags' => is_string($product->tags) ? json_decode($product->tags, true) : $product->tags,
                            'created_at' => $product->created_at,
                            'updated_at' => $product->updated_at,
                        ]);

                        // Initialize analytics
                        ProductAnalytic::create([
                            'product_id' => $mongoProduct->_id,
                            'views_count' => 0,
                            'views_today' => 0,
                            'views_this_week' => 0,
                            'views_this_month' => 0,
                            'clicks_count' => 0,
                            'clicks_today' => 0,
                            'clicks_this_week' => 0,
                            'clicks_this_month' => 0,
                            'cart_additions' => 0,
                            'cart_additions_today' => 0,
                            'cart_additions_this_week' => 0,
                            'cart_additions_this_month' => 0,
                            'purchases' => 0,
                            'purchases_today' => 0,
                            'purchases_this_week' => 0,
                            'purchases_this_month' => 0,
                            'revenue_total' => 0,
                            'revenue_today' => 0,
                            'revenue_this_week' => 0,
                            'revenue_this_month' => 0,
                            'conversion_rate' => 0,
                            'bounce_rate' => 0,
                            'popular_search_terms' => [],
                            'referrer_data' => [],
                            'device_analytics' => [],
                            'geographic_data' => [],
                        ]);

                        Log::info("Migrated product: {$product->name} (ID: {$product->id})");
                    }
                }
            });

            return ['success' => true, 'message' => 'Products migrated successfully'];
        } catch (\Exception $e) {
            Log::error("Migration failed: " . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Migrate a category from PostgreSQL to MongoDB
     */
    protected function migrateCategory($category)
    {
        if (!$category) {
            return null;
        }

        // Check if category already exists in MongoDB
        $mongoCategory = MongoCategory::where('postgres_id', $category->id)->first();

        if (!$mongoCategory) {
            $mongoCategory = MongoCategory::create([
                'postgres_id' => $category->id,
                'name' => $category->name,
                'description' => $category->description,
                'slug' => $category->slug,
                'is_active' => $category->is_active ?? true,
                'sort_order' => $category->sort_order ?? 0,
                'image' => $category->image,
                'meta_title' => $category->meta_title,
                'meta_description' => $category->meta_description,
                'created_at' => $category->created_at,
                'updated_at' => $category->updated_at,
            ]);
        }

        return $mongoCategory;
    }

    /**
     * Sync product updates between databases
     */
    public function syncProductUpdate($postgresProduct)
    {
        try {
            $mongoProduct = MongoProduct::where('postgres_id', $postgresProduct->id)->first();

            if ($mongoProduct) {
                $mongoProduct->update([
                    'name' => $postgresProduct->name,
                    'description' => $postgresProduct->description,
                    'price' => $postgresProduct->price,
                    'cost_price' => $postgresProduct->cost_price ?? 0,
                    'sku' => $postgresProduct->sku,
                    'barcode' => $postgresProduct->barcode,
                    'stock_quantity' => $postgresProduct->stock_quantity,
                    'low_stock_threshold' => $postgresProduct->low_stock_threshold ?? 10,
                    'weight' => $postgresProduct->weight,
                    'is_active' => $postgresProduct->is_active ?? true,
                    'is_featured' => $postgresProduct->is_featured ?? false,
                    'meta_title' => $postgresProduct->meta_title,
                    'meta_description' => $postgresProduct->meta_description,
                    'slug' => $postgresProduct->slug,
                    'images' => is_string($postgresProduct->images) ? json_decode($postgresProduct->images, true) : $postgresProduct->images,
                    'attributes' => is_string($postgresProduct->attributes) ? json_decode($postgresProduct->attributes, true) : $postgresProduct->attributes,
                    'variants' => is_string($postgresProduct->variants) ? json_decode($postgresProduct->variants, true) : $postgresProduct->variants,
                    'tags' => is_string($postgresProduct->tags) ? json_decode($postgresProduct->tags, true) : $postgresProduct->tags,
                    'updated_at' => $postgresProduct->updated_at,
                ]);

                Log::info("Synced product update: {$postgresProduct->name}");
            }

            return true;
        } catch (\Exception $e) {
            Log::error("Sync failed for product {$postgresProduct->id}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get products from MongoDB with fallback to PostgreSQL
     */
    public function getProducts($filters = [])
    {
        // Check if MongoDB is available, otherwise use PostgreSQL
        if (!$this->isMongoDBAvailable()) {
            Log::info('MongoDB not available, using PostgreSQL fallback for products');
            return $this->getProductsFromPostgreSQL($filters);
        }

        try {
            $query = MongoProduct::with('category');

            // Apply filters
            if (isset($filters['category_id'])) {
                $query->where('category_id', $filters['category_id']);
            }

            if (isset($filters['is_active'])) {
                $query->where('is_active', $filters['is_active']);
            }

            if (isset($filters['is_featured'])) {
                $query->where('is_featured', $filters['is_featured']);
            }

            if (isset($filters['price_min'])) {
                $query->where('price', '>=', $filters['price_min']);
            }

            if (isset($filters['price_max'])) {
                $query->where('price', '<=', $filters['price_max']);
            }

            if (isset($filters['search'])) {
                $query->where(function ($q) use ($filters) {
                    $q->where('name', 'like', '%' . $filters['search'] . '%')
                        ->orWhere('description', 'like', '%' . $filters['search'] . '%')
                        ->orWhere('sku', 'like', '%' . $filters['search'] . '%');
                });
            }

            return $query->paginate($filters['per_page'] ?? 15);
        } catch (\Exception $e) {
            Log::warning("MongoDB query failed, falling back to PostgreSQL: " . $e->getMessage());
            return $this->getProductsFromPostgreSQL($filters);
        }
    }

    /**
     * Get products from PostgreSQL (fallback method)
     */
    protected function getProductsFromPostgreSQL($filters = [])
    {
        $query = PostgresProduct::with('category');

        // Apply filters for PostgreSQL
        if (isset($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (isset($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('description', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('sku', 'like', '%' . $filters['search'] . '%');
            });
        }

        return $query->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Get product statistics from MongoDB
     */
    public function getProductStatistics($productId = null)
    {
        try {
            if ($productId) {
                $mongoProduct = MongoProduct::where('postgres_id', $productId)->first();
                if ($mongoProduct) {
                    return ProductAnalytic::where('product_id', $mongoProduct->_id)->first();
                }
            } else {
                return ProductAnalytic::selectRaw([
                    'SUM(views_count) as total_views',
                    'SUM(purchases) as total_purchases',
                    'AVG(conversion_rate) as avg_conversion_rate',
                    'SUM(revenue_total) as total_revenue'
                ])->first();
            }
        } catch (\Exception $e) {
            Log::error("Failed to get product statistics: " . $e->getMessage());
            return null;
        }
    }
}
