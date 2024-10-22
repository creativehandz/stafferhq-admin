<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillingDetail extends Model
{
    protected $table = 'billing_details';

    protected $fillable = [
        'user_id',
        'full_name',
        'company_name',
        'country',
        'state',
        'address',
        'city',
        'postal_code',
        'is_citizen',
        'tax_category',
        'want_invoices',
    ];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
