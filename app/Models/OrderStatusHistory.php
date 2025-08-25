<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderStatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_checkout_id',
        'order_status_id',
        'changed_by_user_id',
        'notes',
        'metadata',
        'changed_at'
    ];

    protected $casts = [
        'metadata' => 'array',
        'changed_at' => 'datetime',
    ];

    /**
     * Get the buyer checkout that owns this status history
     */
    public function buyerCheckout(): BelongsTo
    {
        return $this->belongsTo(BuyerCheckout::class);
    }

    /**
     * Get the order status
     */
    public function orderStatus(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class);
    }

    /**
     * Get the user who changed the status
     */
    public function changedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by_user_id');
    }

    /**
     * Scope to get history for a specific order
     */
    public function scopeForOrder($query, $buyerCheckoutId)
    {
        return $query->where('buyer_checkout_id', $buyerCheckoutId);
    }

    /**
     * Scope to get recent changes
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('changed_at', '>=', now()->subDays($days));
    }
}
