<?php

namespace App\Models\Mongo;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductAnalytic extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'product_analytics';

    protected $fillable = [
        'product_id',
        'views_count',
        'views_today',
        'views_this_week',
        'views_this_month',
        'clicks_count',
        'clicks_today',
        'clicks_this_week',
        'clicks_this_month',
        'cart_additions',
        'cart_additions_today',
        'cart_additions_this_week',
        'cart_additions_this_month',
        'purchases',
        'purchases_today',
        'purchases_this_week',
        'purchases_this_month',
        'revenue_total',
        'revenue_today',
        'revenue_this_week',
        'revenue_this_month',
        'conversion_rate',
        'bounce_rate',
        'last_viewed_at',
        'last_purchased_at',
        'popular_search_terms',
        'referrer_data',
        'device_analytics',
        'geographic_data',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'views_count' => 'integer',
        'views_today' => 'integer',
        'views_this_week' => 'integer',
        'views_this_month' => 'integer',
        'clicks_count' => 'integer',
        'clicks_today' => 'integer',
        'clicks_this_week' => 'integer',
        'clicks_this_month' => 'integer',
        'cart_additions' => 'integer',
        'cart_additions_today' => 'integer',
        'cart_additions_this_week' => 'integer',
        'cart_additions_this_month' => 'integer',
        'purchases' => 'integer',
        'purchases_today' => 'integer',
        'purchases_this_week' => 'integer',
        'purchases_this_month' => 'integer',
        'revenue_total' => 'decimal:2',
        'revenue_today' => 'decimal:2',
        'revenue_this_week' => 'decimal:2',
        'revenue_this_month' => 'decimal:2',
        'conversion_rate' => 'decimal:4',
        'bounce_rate' => 'decimal:4',
        'last_viewed_at' => 'datetime',
        'last_purchased_at' => 'datetime',
        'popular_search_terms' => 'array',
        'referrer_data' => 'array',
        'device_analytics' => 'array',
        'geographic_data' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the product this analytics data belongs to
     */
    public function product()
    {
        return $this->belongsTo(MongoProduct::class, 'product_id');
    }

    /**
     * Record a product view
     */
    public function recordView()
    {
        $this->increment('views_count');
        $this->increment('views_today');
        $this->increment('views_this_week');
        $this->increment('views_this_month');
        $this->last_viewed_at = now();
        $this->save();
    }

    /**
     * Record a product click
     */
    public function recordClick()
    {
        $this->increment('clicks_count');
        $this->increment('clicks_today');
        $this->increment('clicks_this_week');
        $this->increment('clicks_this_month');
        $this->save();
    }

    /**
     * Record a cart addition
     */
    public function recordCartAddition()
    {
        $this->increment('cart_additions');
        $this->increment('cart_additions_today');
        $this->increment('cart_additions_this_week');
        $this->increment('cart_additions_this_month');
        $this->save();
    }

    /**
     * Record a purchase
     */
    public function recordPurchase($amount)
    {
        $this->increment('purchases');
        $this->increment('purchases_today');
        $this->increment('purchases_this_week');
        $this->increment('purchases_this_month');

        $this->increment('revenue_total', $amount);
        $this->increment('revenue_today', $amount);
        $this->increment('revenue_this_week', $amount);
        $this->increment('revenue_this_month', $amount);

        $this->last_purchased_at = now();
        $this->updateConversionRate();
        $this->save();
    }

    /**
     * Update conversion rate
     */
    public function updateConversionRate()
    {
        if ($this->views_count > 0) {
            $this->conversion_rate = ($this->purchases / $this->views_count) * 100;
        }
    }

    /**
     * Reset daily analytics (called via scheduled job)
     */
    public function resetDailyAnalytics()
    {
        $this->update([
            'views_today' => 0,
            'clicks_today' => 0,
            'cart_additions_today' => 0,
            'purchases_today' => 0,
            'revenue_today' => 0,
        ]);
    }

    /**
     * Reset weekly analytics (called via scheduled job)
     */
    public function resetWeeklyAnalytics()
    {
        $this->update([
            'views_this_week' => 0,
            'clicks_this_week' => 0,
            'cart_additions_this_week' => 0,
            'purchases_this_week' => 0,
            'revenue_this_week' => 0,
        ]);
    }

    /**
     * Reset monthly analytics (called via scheduled job)
     */
    public function resetMonthlyAnalytics()
    {
        $this->update([
            'views_this_month' => 0,
            'clicks_this_month' => 0,
            'cart_additions_this_month' => 0,
            'purchases_this_month' => 0,
            'revenue_this_month' => 0,
        ]);
    }

    /**
     * Scope for high performing products
     */
    public function scopeHighPerforming($query)
    {
        return $query->where('conversion_rate', '>', 5);
    }

    /**
     * Scope for trending products (high recent activity)
     */
    public function scopeTrending($query)
    {
        return $query->where('views_today', '>', 10)
            ->orWhere('purchases_today', '>', 0);
    }
}
