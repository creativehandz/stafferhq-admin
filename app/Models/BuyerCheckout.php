<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BuyerCheckout extends Model
{
    use HasFactory;

    protected $table = 'buyer_checkout';

    protected $fillable = [
        'user_id',
        'order_details',
        'package_selected',
        'total_price',
        'gig_id',
        'status',
        'billing_details',
        'order_status_id',
        // Individual billing fields
        'billing_full_name',
        'billing_company_name',
        'billing_country',
        'billing_state',
        'billing_address',
        'billing_city',
        'billing_postal_code',
        'billing_citizen_resident',
        'billing_tax_category',
        'billing_want_invoices',
        'billing_phone',
        'billing_email',
    ];

    protected $casts = [
        'order_details' => 'array',
        'billing_details' => 'array', // Keep for backward compatibility
        'billing_citizen_resident' => 'boolean',
        'billing_want_invoices' => 'boolean',
    ];

    /**
     * Get the user that owns this checkout
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the current order status
     */
    public function orderStatus(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class);
    }

    /**
     * Get the status history for this order
     */
    public function statusHistory(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class)->orderBy('changed_at', 'desc');
    }

    /**
     * Get the gig associated with this order
     */
    public function gig(): BelongsTo
    {
        return $this->belongsTo(Gig::class);
    }

    /**
     * Update the order status and create history entry
     */
    public function updateStatus($statusId, $changedByUserId, $notes = null, $metadata = null)
    {
        // Get the new status
        $newStatus = OrderStatus::find($statusId);
        
        if (!$newStatus) {
            throw new \Exception("Invalid status ID: {$statusId}");
        }
        
        // Update both the status string and foreign key to keep them in sync
        $this->update([
            'status' => $newStatus->name, // Keep string field in sync
            'order_status_id' => $statusId
        ]);

        // Create history entry
        $this->statusHistory()->create([
            'order_status_id' => $statusId,
            'changed_by_user_id' => $changedByUserId,
            'notes' => $notes,
            'metadata' => $metadata,
            'changed_at' => now(),
        ]);

        return $this;
    }

    /**
     * Get the current status name (fallback to old status column)
     */
    public function getCurrentStatusName()
    {
        if ($this->orderStatus) {
            return $this->orderStatus->name;
        }
        
        // Fallback to old status column during migration
        return $this->status;
    }

    /**
     * Get buyer reviews for this order (buyer reviewing the seller)
     */
    public function buyerReviews(): HasMany
    {
        return $this->hasMany(Review::class, 'order_id')->where('review_type', 'buyer_to_seller');
    }

    /**
     * Get first buyer review for this order (singular)
     * This provides backward compatibility for code expecting buyerReview (singular)
     */
    public function buyerReview()
    {
        return $this->hasOne(Review::class, 'order_id')->where('review_type', 'buyer_to_seller');
    }

    /**
     * Get seller reviews for this order (seller reviewing the buyer)
     */
    public function sellerReviews(): HasMany
    {
        return $this->hasMany(Review::class, 'order_id')->where('review_type', 'seller_to_buyer');
    }

    /**
     * Get first seller review for this order (singular)
     * This provides backward compatibility for code expecting sellerReview (singular)
     */
    public function sellerReview()
    {
        return $this->hasOne(Review::class, 'order_id')->where('review_type', 'seller_to_buyer');
    }

    /**
     * Get all reviews for this order
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'order_id');
    }

    /**
     * Check if buyer has reviewed the seller for this order
     */
    public function hasBuyerReview(): bool
    {
        return $this->buyerReviews()->exists();
    }

    /**
     * Check if seller has reviewed the buyer for this order
     */
    public function hasSellerReview(): bool
    {
        return $this->sellerReviews()->exists();
    }

    /**
     * Scope to filter by status
     */
    public function scopeWithStatus($query, $statusName)
    {
        return $query->whereHas('orderStatus', function ($q) use ($statusName) {
            $q->where('name', $statusName);
        });
    }

    /**
     * Scope to filter by status slug
     */
    public function scopeWithStatusSlug($query, $statusSlug)
    {
        return $query->whereHas('orderStatus', function ($q) use ($statusSlug) {
            $q->where('slug', $statusSlug);
        });
    }
}
