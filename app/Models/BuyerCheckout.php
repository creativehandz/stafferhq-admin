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
        // Update the current status
        $this->update(['order_status_id' => $statusId]);

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
