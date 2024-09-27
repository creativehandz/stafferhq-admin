<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = [
        'id',
        'name',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function subcategories() {
        return $this->hasMany(Subcategory::class, 'category_id');
    }
    public function category() {
        return $this->belongsTo(Category::class);
    }
}
