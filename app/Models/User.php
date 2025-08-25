<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'website',
        'company_size',
        'location',
        'social_links',
        'categories',
        'profile_image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => 'integer', 
        ];
    }

    public function jobs()
    {
        return $this->hasMany(Job::class, 'user_id');
    }

    /**
     * Get the gigs for the user (seller/freelancer).
     */
    public function gigs()
    {
        return $this->hasMany(Gig::class, 'user_id');
    }

    /**
     * Get orders where this user is the seller.
     */
    public function sellerOrders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    /**
     * Get orders where this user is the buyer.
     */
    public function buyerOrders()
    {
        return $this->hasMany(Order::class, 'buyer');
    }

    /**
     * Get the skills for the user.
     */
    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }

    /**
     * Get the categories for the user.
     * Assumes categories field stores JSON array of IDs
     */
    public function getUserCategoriesAttribute()
    {
        if (!$this->categories) {
            return collect();
        }

        // Parse category IDs from the categories field (JSON format)
        $categoryIds = collect(json_decode($this->categories, true))
            ->map(function ($id) {
                return is_numeric($id) ? (int) $id : null;
            })
            ->filter();

        if ($categoryIds->isEmpty()) {
            return collect();
        }

        // Fetch category names from the database
        return \App\Models\Category::whereIn('id', $categoryIds)->pluck('name');
    }

}
