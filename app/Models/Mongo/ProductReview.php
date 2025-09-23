<?php

namespace App\Models\Mongo;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductReview extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'product_reviews';

    protected $fillable = [
        'product_id',
        'user_id',
        'user_name',
        'user_email',
        'rating',
        'title',
        'review',
        'is_verified_purchase',
        'is_approved',
        'helpful_count',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_verified_purchase' => 'boolean',
        'is_approved' => 'boolean',
        'helpful_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the product this review belongs to
     */
    public function product()
    {
        return $this->belongsTo(MongoProduct::class, 'product_id');
    }

    /**
     * Get the user from PostgreSQL
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * Scope for approved reviews
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope for verified purchase reviews
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified_purchase', true);
    }

    /**
     * Scope by rating
     */
    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }
}
