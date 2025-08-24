<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageOrder extends Model
{
    use HasFactory;

    protected $table = 'manage_orders';

    protected $fillable = [
        'user_id',
        'buyer',
        'gig',
        'due_on',
        'total',
        'note',
        'status'
    ];

    protected $casts = [
        'due_on' => 'date',
        'total' => 'decimal:2'
    ];

    /**
     * Get the user that owns the order
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the buyer information (if stored as user relationship)
     */
    public function buyerUser()
    {
        return $this->belongsTo(User::class, 'buyer', 'name');
    }

    /**
     * Scope for filtering by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for filtering by user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Get orders due soon (within next 3 days)
     */
    public function scopeDueSoon($query)
    {
        return $query->where('due_on', '<=', now()->addDays(3))
                    ->where('due_on', '>=', now())
                    ->where('status', '!=', 'completed');
    }

    /**
     * Get overdue orders
     */
    public function scopeOverdue($query)
    {
        return $query->where('due_on', '<', now())
                    ->where('status', '!=', 'completed');
    }
}
