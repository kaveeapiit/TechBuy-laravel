<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mongo\MongoProduct;
use App\Models\Mongo\MongoCategory;
use App\Models\Mongo\ProductAnalytic;
use App\Models\Mongo\ProductReview;
use App\Services\DualDatabaseService;
use Illuminate\Support\Facades\Log;

class MongoProductController extends Controller
{
    protected $dualDbService;

    public function __construct(DualDatabaseService $dualDbService)
    {
        $this->dualDbService = $dualDbService;
    }

    /**
     * Display a listing of products from MongoDB
     */
    public function index(Request $request)
    {
        try {
            $filters = [
                'category_id' => $request->get('category'),
                'is_active' => $request->get('active', true),
                'is_featured' => $request->get('featured'),
                'price_min' => $request->get('price_min'),
                'price_max' => $request->get('price_max'),
                'search' => $request->get('search'),
                'per_page' => $request->get('per_page', 15),
            ];

            $products = $this->dualDbService->getProducts($filters);
            $categories = MongoCategory::active()->get();

            return view('products.index', compact('products', 'categories'));
        } catch (\Exception $e) {
            Log::error('MongoDB product listing failed: ' . $e->getMessage());

            // Fallback to regular ProductController
            return app(\App\Http\Controllers\ProductController::class)->index($request);
        }
    }

    /**
     * Display the specified product from MongoDB
     */
    public function show($id)
    {
        try {
            // Try to get product from MongoDB first
            $mongoProduct = MongoProduct::where('postgres_id', $id)
                ->with(['category', 'reviews' => function ($query) {
                    $query->approved()->latest()->limit(10);
                }])
                ->first();

            if ($mongoProduct) {
                // Get analytics data
                $analytics = ProductAnalytic::where('product_id', $mongoProduct->_id)->first();

                // Get related products
                $relatedProducts = MongoProduct::where('category_id', $mongoProduct->category_id)
                    ->where('_id', '!=', $mongoProduct->_id)
                    ->active()
                    ->limit(4)
                    ->get();

                // Calculate average rating
                $avgRating = $mongoProduct->reviews()->approved()->avg('rating') ?? 0;
                $totalReviews = $mongoProduct->reviews()->approved()->count();

                return view('products.show', compact(
                    'mongoProduct',
                    'analytics',
                    'relatedProducts',
                    'avgRating',
                    'totalReviews'
                ));
            }

            // Fallback to PostgreSQL product
            return app(\App\Http\Controllers\ProductController::class)->show($id);
        } catch (\Exception $e) {
            Log::error('MongoDB product show failed: ' . $e->getMessage());
            return app(\App\Http\Controllers\ProductController::class)->show($id);
        }
    }

    /**
     * Get product analytics data
     */
    public function analytics($id)
    {
        try {
            $mongoProduct = MongoProduct::where('postgres_id', $id)->first();

            if (!$mongoProduct) {
                return response()->json(['error' => 'Product not found in MongoDB'], 404);
            }

            $analytics = ProductAnalytic::where('product_id', $mongoProduct->_id)->first();

            if (!$analytics) {
                return response()->json(['error' => 'Analytics not found'], 404);
            }

            return response()->json([
                'product' => [
                    'id' => $mongoProduct->postgres_id,
                    'name' => $mongoProduct->name,
                    'sku' => $mongoProduct->sku,
                ],
                'analytics' => [
                    'views' => [
                        'total' => $analytics->views_count,
                        'today' => $analytics->views_today,
                        'this_week' => $analytics->views_this_week,
                        'this_month' => $analytics->views_this_month,
                    ],
                    'clicks' => [
                        'total' => $analytics->clicks_count,
                        'today' => $analytics->clicks_today,
                        'this_week' => $analytics->clicks_this_week,
                        'this_month' => $analytics->clicks_this_month,
                    ],
                    'cart_additions' => [
                        'total' => $analytics->cart_additions,
                        'today' => $analytics->cart_additions_today,
                        'this_week' => $analytics->cart_additions_this_week,
                        'this_month' => $analytics->cart_additions_this_month,
                    ],
                    'purchases' => [
                        'total' => $analytics->purchases,
                        'today' => $analytics->purchases_today,
                        'this_week' => $analytics->purchases_this_week,
                        'this_month' => $analytics->purchases_this_month,
                    ],
                    'revenue' => [
                        'total' => $analytics->revenue_total,
                        'today' => $analytics->revenue_today,
                        'this_week' => $analytics->revenue_this_week,
                        'this_month' => $analytics->revenue_this_month,
                    ],
                    'conversion_rate' => $analytics->conversion_rate,
                    'bounce_rate' => $analytics->bounce_rate,
                    'device_analytics' => $analytics->device_analytics,
                    'referrer_data' => $analytics->referrer_data,
                    'geographic_data' => $analytics->geographic_data,
                    'last_viewed_at' => $analytics->last_viewed_at,
                    'last_purchased_at' => $analytics->last_purchased_at,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Analytics retrieval failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to retrieve analytics'], 500);
        }
    }

    /**
     * Get trending products based on MongoDB analytics
     */
    public function trending()
    {
        try {
            $trendingAnalytics = ProductAnalytic::trending()
                ->with('product')
                ->orderBy('views_today', 'desc')
                ->orderBy('purchases_today', 'desc')
                ->limit(10)
                ->get();

            $trendingProducts = $trendingAnalytics->map(function ($analytics) {
                return [
                    'product' => $analytics->product,
                    'views_today' => $analytics->views_today,
                    'purchases_today' => $analytics->purchases_today,
                    'conversion_rate' => $analytics->conversion_rate,
                ];
            });

            return response()->json($trendingProducts);
        } catch (\Exception $e) {
            Log::error('Trending products retrieval failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to retrieve trending products'], 500);
        }
    }

    /**
     * Search products using MongoDB text search
     */
    public function search(Request $request)
    {
        try {
            $query = $request->get('q');

            if (empty($query)) {
                return response()->json(['products' => []]);
            }

            $products = MongoProduct::where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                    ->orWhere('description', 'like', '%' . $query . '%')
                    ->orWhere('sku', 'like', '%' . $query . '%')
                    ->orWhere('tags', 'like', '%' . $query . '%');
            })
                ->active()
                ->with('category')
                ->limit(20)
                ->get();

            return response()->json([
                'products' => $products->map(function ($product) {
                    return [
                        'id' => $product->postgres_id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'sku' => $product->sku,
                        'category' => $product->category->name ?? '',
                        'image' => $product->images[0] ?? null,
                        'url' => route('products.show', $product->postgres_id),
                    ];
                })
            ]);
        } catch (\Exception $e) {
            Log::error('MongoDB product search failed: ' . $e->getMessage());
            return response()->json(['error' => 'Search failed'], 500);
        }
    }

    /**
     * Record cart addition analytics
     */
    public function recordCartAddition(Request $request, $id)
    {
        try {
            $mongoProduct = MongoProduct::where('postgres_id', $id)->first();

            if ($mongoProduct) {
                $analytics = ProductAnalytic::where('product_id', $mongoProduct->_id)->first();

                if ($analytics) {
                    $analytics->recordCartAddition();
                    return response()->json(['success' => true]);
                }
            }

            return response()->json(['success' => false], 404);
        } catch (\Exception $e) {
            Log::error('Cart addition tracking failed: ' . $e->getMessage());
            return response()->json(['error' => 'Tracking failed'], 500);
        }
    }

    /**
     * Record purchase analytics
     */
    public function recordPurchase(Request $request, $id)
    {
        try {
            $mongoProduct = MongoProduct::where('postgres_id', $id)->first();
            $amount = $request->get('amount', 0);

            if ($mongoProduct) {
                $analytics = ProductAnalytic::where('product_id', $mongoProduct->_id)->first();

                if ($analytics) {
                    $analytics->recordPurchase($amount);
                    return response()->json(['success' => true]);
                }
            }

            return response()->json(['success' => false], 404);
        } catch (\Exception $e) {
            Log::error('Purchase tracking failed: ' . $e->getMessage());
            return response()->json(['error' => 'Tracking failed'], 500);
        }
    }
}
