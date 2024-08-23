<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    use HasFactory;

        // Specify the table associated with the model if it's not the plural form of the model name
        protected $table = 'resumes';

        // Specify the attributes that are mass assignable
        protected $fillable = [
            'user_id',
            'name',
            'occupation',
            'about',
            'phone',
            'email',
            'social_links',
            'age',
            'citizen',
            'address',
            'favorate_quote',
            'expertise',
            'what_i_do',
            'skills',
            'educations',
            'experiences',
            'projects',
        ];
    
        // Specify the attributes that should be cast to native types
        protected $casts = [
            'social_links' => 'array',
            'what_i_do' => 'array',
            'skills' => 'array',
            'educations' => 'array',
            'experiences' => 'array',
            'projects' => 'array',
        ];
    
        // Define the relationship with the User model
        public function user()
        {
            return $this->belongsTo(User::class);
        }
}
