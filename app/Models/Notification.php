<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'is_read',
        'route'
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the user that owns the notification
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for unread notifications
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope for recent notifications
     */
    public function scopeRecent($query, $limit = 10)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }

    /**
     * Create a new order notification
     */
    public static function createOrderNotification($sellerId, $order)
    {
        return self::create([
            'user_id' => $sellerId,
            'type' => 'new_order',
            'title' => 'New Order Received!',
            'message' => "You have a new order for {$order->package_selected} package worth $" . $order->total_price,
            'data' => [
                'order_id' => $order->id,
                'gig_id' => $order->gig_id,
                'buyer_id' => $order->user_id,
                'package' => $order->package_selected,
                'amount' => $order->total_price
            ],
            'route' => "/orders/{$order->id}",
            'is_read' => false
        ]);
    }
}
