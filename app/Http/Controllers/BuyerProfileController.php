<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class BuyerProfileController extends Controller
{
    /**
     * Display the buyer's profile view page.
     */
    public function show(): Response
    {
        $user = Auth::user();
        
        // Get user's selected categories with their names
        $userCategoryIds = $user->categories ? (is_string($user->categories) ? json_decode($user->categories, true) : $user->categories) : [];
        $userCategories = [];
        
        if (!empty($userCategoryIds)) {
            $userCategories = Category::whereIn('id', $userCategoryIds)->get(['id', 'name']);
        }
        
        return Inertia::render('BuyerProfile/ProfileHome', [
            'user' => $user,
            'userCategories' => $userCategories
        ]);
    }

    /**
     * Show the form for editing the buyer's profile.
     */
    public function edit(): Response
    {
        $user = Auth::user();
        
        // Get all categories from database
        $categories = Category::orderBy('name')->get();
        
        // Get user's current categories (assuming it's stored as JSON array of IDs)
        $userCategoryIds = $user->categories ? (is_string($user->categories) ? json_decode($user->categories, true) : $user->categories) : [];
        
        // Parse social links
        $socialLinks = $user->social_links ? json_decode($user->social_links, true) : [];
        $parsedSocialLinks = [
            'twitter' => '',
            'linkedin' => '',
            'facebook' => '',
            'instagram' => '',
            'github' => '',
            'youtube' => ''
        ];
        
        // Parse social links array to individual fields
        if (is_array($socialLinks)) {
            foreach ($socialLinks as $link) {
                if (isset($link['platform']) && isset($link['url'])) {
                    $platform = strtolower($link['platform']);
                    $parsedSocialLinks[$platform] = $link['url'];
                }
            }
        }
        
        return Inertia::render('BuyerProfile/Edit', [
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'website' => $user->website,
                'company_size' => $user->company_size,
                'location' => $user->location,
                'categories' => $userCategoryIds,
                'social_links' => $parsedSocialLinks,
                'profile_image' => $user->profile_image,
            ],
            'categories' => $categories,
        ]);
    }

    /**
     * Update the buyer's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Validate the request
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'website' => ['nullable', 'string', 'max:255', 'url'],
            'company_size' => ['nullable', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:255'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['integer', 'exists:categories,id'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'twitter' => ['nullable', 'string', 'max:255', 'url'],
            'linkedin' => ['nullable', 'string', 'max:255', 'url'],
            'facebook' => ['nullable', 'string', 'max:255', 'url'],
            'instagram' => ['nullable', 'string', 'max:255', 'url'],
            'github' => ['nullable', 'string', 'max:255', 'url'],
            'youtube' => ['nullable', 'string', 'max:255', 'url'],
        ]);
        
        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            \Log::info('Profile image file detected');
            
            // Delete old profile image if it exists
            if ($user->profile_image && file_exists(public_path($user->profile_image))) {
                unlink(public_path($user->profile_image));
                \Log::info('Old profile image deleted: ' . $user->profile_image);
            }
            
            $image = $request->file('profile_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = 'storage/profile-images/' . $imageName;
            
            // Move the file
            $image->move(public_path('storage/profile-images'), $imageName);
            \Log::info('New profile image saved: ' . $imagePath);
            
            $validated['profile_image'] = $imagePath;
        } else {
            \Log::info('No profile image file in request');
        }
        
        // Handle categories - convert to JSON array of integers
        if (isset($validated['categories'])) {
            $categoryIds = array_map('intval', $validated['categories']);
            $validated['categories'] = json_encode($categoryIds);
        }
        
        // Handle social links - convert individual fields to JSON array
        $socialLinksArray = [];
        $socialPlatforms = ['twitter', 'linkedin', 'facebook', 'instagram', 'github', 'youtube'];
        
        foreach ($socialPlatforms as $platform) {
            if (!empty($validated[$platform])) {
                $socialLinksArray[] = [
                    'platform' => ucfirst($platform),
                    'url' => $validated[$platform]
                ];
            }
            // Remove individual social platform fields from validated data
            unset($validated[$platform]);
        }
        
        // Store social links as JSON or null if empty
        $validated['social_links'] = !empty($socialLinksArray) ? json_encode($socialLinksArray) : null;
        
        \Log::info('Validated data before save:', $validated);
        \Log::info('User before fill:', ['id' => $user->id, 'profile_image' => $user->profile_image]);
        
        // Update the user
        $user->fill($validated);
        
        \Log::info('User after fill:', ['id' => $user->id, 'profile_image' => $user->profile_image]);
        
        $user->save();
        
        \Log::info('User after save:', ['id' => $user->id, 'profile_image' => $user->profile_image]);
        
        return Redirect::route('buyer-profile')->with('status', 'Profile updated successfully!');
    }

    /**
     * Display the buyer dashboard with relevant services grouped by categories.
     */
    public function dashboard(): Response
    {
        $user = Auth::user();
        
        // Get user's interested categories
        $userCategoryIds = [];
        if ($user->categories) {
            $categoryIds = json_decode($user->categories, true);
            if (is_array($categoryIds) && !empty($categoryIds)) {
                $userCategoryIds = $categoryIds;
            }
        }
        
        // Get user's categories with names for display
        $userCategories = collect();
        $categoriesWithServices = collect();
        
        if (!empty($userCategoryIds)) {
            $userCategories = Category::whereIn('id', $userCategoryIds)->get(['id', 'name']);
            
            // Group services by categories
            foreach ($userCategories as $category) {
                $gigs = \App\Models\Gig::where('category_id', $category->id)
                    ->where('status', 'active')
                    ->with('user')
                    ->orderBy('created_at', 'desc')
                    ->take(6) // Limit to 6 services per category
                    ->get()
                    ->map(function ($gig) {
                        // Parse pricing if it exists
                        $pricing = null;
                        if ($gig->pricing) {
                            $pricing = json_decode($gig->pricing, true);
                        }
                        
                        return [
                            'id' => $gig->id,
                            'title' => $gig->gig_title,
                            'description' => $gig->gig_description,
                            'seller_name' => $gig->user ? $gig->user->name : 'Unknown',
                            'seller_email' => $gig->user ? $gig->user->email : '',
                            'category_id' => $gig->category_id,
                            'pricing' => $pricing,
                            'keywords' => $gig->positive_keywords,
                            'status' => $gig->status,
                            'clicks' => $gig->clicks ?: 0,
                            'orders' => $gig->orders ?: 0,
                        ];
                    });
                
                if ($gigs->isNotEmpty()) {
                    $categoriesWithServices->push([
                        'category' => $category,
                        'services' => $gigs,
                        'service_count' => $gigs->count()
                    ]);
                }
            }
        }
        
        // Also get all recommended gigs for backward compatibility
        $allRecommendedGigs = collect();
        if (!empty($userCategoryIds)) {
            $allRecommendedGigs = \App\Models\Gig::whereIn('category_id', $userCategoryIds)
                ->where('status', 'active')
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->take(12)
                ->get()
                ->map(function ($gig) {
                    $pricing = null;
                    if ($gig->pricing) {
                        $pricing = json_decode($gig->pricing, true);
                    }
                    
                    return [
                        'id' => $gig->id,
                        'title' => $gig->gig_title,
                        'description' => $gig->gig_description,
                        'seller_name' => $gig->user ? $gig->user->name : 'Unknown',
                        'seller_email' => $gig->user ? $gig->user->email : '',
                        'category_id' => $gig->category_id,
                        'pricing' => $pricing,
                        'keywords' => $gig->positive_keywords,
                        'status' => $gig->status,
                        'clicks' => $gig->clicks ?: 0,
                        'orders' => $gig->orders ?: 0,
                    ];
                });
        }
        
        return Inertia::render('BuyerDashboard/BuyerDashboard', [
            'user' => $user,
            'recommendedGigs' => $allRecommendedGigs,
            'categoriesWithServices' => $categoriesWithServices,
            'userCategories' => $userCategories,
            'totalRecommendations' => $allRecommendedGigs->count()
        ]);
    }
}
