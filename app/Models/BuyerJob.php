<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyerJob extends Model
{
    use HasFactory;

    protected $table = 'buyer_jobs';

    protected $fillable = [
        'job_title',
        'job_description',
        'location',
        'category_id',
        'sub_category_id',
        'budget',
        'image'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
