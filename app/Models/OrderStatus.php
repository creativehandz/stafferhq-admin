<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'color',
        'description',
        'sort_order',
        'is_active',
        'is_initial',
        'is_final'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_initial' => 'boolean',
        'is_final' => 'boolean',
    ];

    /**
     * Get all buyer checkouts with this status
     */
    public function buyerCheckouts(): HasMany
    {
        return $this->hasMany(BuyerCheckout::class);
    }

    /**
     * Get all status history entries for this status
     */
    public function statusHistory(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class);
    }

    /**
     * Scope to get only active statuses
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get initial statuses
     */
    public function scopeInitial($query)
    {
        return $query->where('is_initial', true);
    }

    /**
     * Scope to get final statuses
     */
    public function scopeFinal($query)
    {
        return $query->where('is_final', true);
    }

    /**
     * Get status by slug
     */
    public static function findBySlug($slug)
    {
        return static::where('slug', $slug)->first();
    }

    /**
     * Get status by name
     */
    public static function findByName($name)
    {
        return static::where('name', $name)->first();
    }
}
