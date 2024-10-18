<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyerCheckout extends Model
{
    use HasFactory;

    protected $table = 'buyer_checkout';

    protected $fillable = [
        'user_id',
        'order_details',
        'package_selected',
        'total_price',
        'gig_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    // If you want Laravel to automatically handle JSON casting
    // protected $casts = [
    //     'order_details' => 'array',
    // ];
}
