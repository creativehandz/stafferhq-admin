<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gigs extends Model
{
    use HasFactory;
    protected $table = 'gigs';
    protected $fillable = [
        'gig',
        'user_id',
        'impressions',
        'clicks',
        'orders',
        'status',
        'cancellations',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}