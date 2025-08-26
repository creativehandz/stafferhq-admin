<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'reviewer_id',
        'reviewee_id',
        'review_type',
        'rating',
        'review_text',
        'review_criteria',
        'is_public',
        'is_featured',
        'reviewed_at'
    ];

    protected $casts = [
        'review_criteria' => 'array',
        'reviewed_at' => 'datetime',
        'is_public' => 'boolean',
        'is_featured' => 'boolean'
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(BuyerCheckout::class, 'order_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function reviewee()
    {
        return $this->belongsTo(User::class, 'reviewee_id');
    }

    // Scopes
    public function scopeBuyerToSeller($query)
    {
        return $query->where('review_type', 'buyer_to_seller');
    }

    public function scopeSellerToBuyer($query)
    {
        return $query->where('review_type', 'seller_to_buyer');
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
