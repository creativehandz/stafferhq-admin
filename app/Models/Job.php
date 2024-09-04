<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

     // Explicitly specify the table name
     protected $table = 'jobs_table';

    protected $fillable = [
        'user_id',
        'title',
        'project_type',
        'category',
        'skills',
        'experience_level',
        'budget_type',
        'budget',
        'description',
        'location',
        'attachment'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }
}
