<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Mongo\MongoProduct;
use App\Models\Mongo\ProductAnalytic;
use Illuminate\Support\Facades\Log;

class TrackProductAnalytics
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Track product views
        $this->trackProductView($request);

        return $response;
    }

    /**
     * Track product view analytics
     */
    protected function trackProductView(Request $request)
    {
        try {
            // Check if this is a product view request
            if ($request->route() && $request->route()->getName() === 'products.show') {
                $productId = $request->route('product');

                // Find MongoDB product by PostgreSQL ID
                $mongoProduct = MongoProduct::where('postgres_id', $productId)->first();

                if ($mongoProduct) {
                    // Get or create analytics record
                    $analytics = ProductAnalytic::where('product_id', $mongoProduct->_id)->first();

                    if (!$analytics) {
                        $analytics = ProductAnalytic::create([
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
                    }

                    // Record the view
                    $analytics->recordView();

                    // Track additional data
                    $this->trackDeviceData($analytics, $request);
                    $this->trackReferrerData($analytics, $request);
                    $this->trackGeographicData($analytics, $request);
                }
            }

            // Track search terms
            if ($request->has('search') && !empty($request->get('search'))) {
                $this->trackSearchTerm($request->get('search'));
            }
        } catch (\Exception $e) {
            // Don't let analytics tracking break the application
            Log::error('Product analytics tracking failed: ' . $e->getMessage());
        }
    }

    /**
     * Track device analytics
     */
    protected function trackDeviceData(ProductAnalytic $analytics, Request $request)
    {
        $userAgent = $request->userAgent();
        $isMobile = $request->header('User-Agent') && preg_match('/Mobile|Android|iPhone|iPad/', $request->header('User-Agent'));

        $deviceData = $analytics->device_analytics ?? [];
        $today = now()->format('Y-m-d');

        if (!isset($deviceData[$today])) {
            $deviceData[$today] = ['mobile' => 0, 'desktop' => 0];
        }

        if ($isMobile) {
            $deviceData[$today]['mobile']++;
        } else {
            $deviceData[$today]['desktop']++;
        }

        $analytics->device_analytics = $deviceData;
        $analytics->save();
    }

    /**
     * Track referrer data
     */
    protected function trackReferrerData(ProductAnalytic $analytics, Request $request)
    {
        $referrer = $request->headers->get('referer');

        if ($referrer) {
            $referrerData = $analytics->referrer_data ?? [];
            $domain = parse_url($referrer, PHP_URL_HOST) ?? 'direct';

            if (!isset($referrerData[$domain])) {
                $referrerData[$domain] = 0;
            }

            $referrerData[$domain]++;
            $analytics->referrer_data = $referrerData;
            $analytics->save();
        }
    }

    /**
     * Track geographic data (basic IP-based detection)
     */
    protected function trackGeographicData(ProductAnalytic $analytics, Request $request)
    {
        $ip = $request->ip();

        // Basic geographic tracking (you might want to integrate with a proper IP geolocation service)
        $country = 'Unknown';

        $geoData = $analytics->geographic_data ?? [];

        if (!isset($geoData[$country])) {
            $geoData[$country] = 0;
        }

        $geoData[$country]++;
        $analytics->geographic_data = $geoData;
        $analytics->save();
    }

    /**
     * Track popular search terms across all products
     */
    protected function trackSearchTerm($searchTerm)
    {
        try {
            // You might want to create a separate collection for global search analytics
            // For now, we'll track it in each product's analytics when they're viewed after a search
            Log::info("Search term tracked: {$searchTerm}");
        } catch (\Exception $e) {
            Log::error('Search term tracking failed: ' . $e->getMessage());
        }
    }
}
