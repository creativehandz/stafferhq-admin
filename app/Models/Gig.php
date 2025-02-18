<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gig extends Model // Changed to singular
{
    use HasFactory;
    
    protected $table = 'gigs';
    
    protected $fillable = [
        'user_id', // Ensure this is first so it's more visible
        'gig', // Check if this field exists in your database
        'impressions',
        'clicks',
        'orders',
        'gig_title',
        'gig_description',
        'category_id',
        'subcategory_id',
        'positive_keywords',
        'status',
        'cancellations',
        'faqs',
        'pricing',
        'requirements',
        'file_path',
        'certificate'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
