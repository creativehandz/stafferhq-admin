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
        return $this->belongsTo(User::class,'user_id');
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class,'job_id');
    }


    // Method to get skill names based on stored skill IDs
    public function getSkillNames()
    {
        // Check if 'skills' field is not empty
        if (!$this->skills) {
            return [];
        }

        // Convert comma-separated string of IDs into an array
        $skillIds = explode(',', $this->skills);

        // Fetch skill names using the skill IDs
        return Skill::whereIn('id', $skillIds)->pluck('name')->toArray();
    }
}
