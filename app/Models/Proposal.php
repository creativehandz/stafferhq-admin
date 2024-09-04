<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'job_id',
        'user_id',
        'cover_letter',
        'attachment',
        'status'
    ];

    // Define the relationship to the job
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    // Define the relationship to the user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
