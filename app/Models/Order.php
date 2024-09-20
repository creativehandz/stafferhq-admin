<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
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

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
