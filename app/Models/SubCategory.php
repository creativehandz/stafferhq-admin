<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $table = 'sub_categories';
    protected $fillable = [
        'id',
        'name',
        'user_id',
        'category_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function category() {
        return $this->belongsTo(Category::class);
    }
    
}
