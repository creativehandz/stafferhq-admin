<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Category;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile view page.
     */
    public function show(Request $request): Response
    {
        // Get user's data including category names from database
        $user = $request->user();
        
        // Get user's category IDs
        $userCategoryIds = $user->categories ? (is_string($user->categories) ? json_decode($user->categories, true) : $user->categories) : [];
        
        // Get category names for the user's selected categories
        $userCategoryNames = [];
        if (!empty($userCategoryIds)) {
            $userCategoryNames = Category::whereIn('id', $userCategoryIds)->pluck('name')->toArray();
        }
        
        return Inertia::render('Profile/View', [
            'userName' => $user->name,
            'userEmail' => $user->email,
            'userPhone' => $user->phone,
            'userWebsite' => $user->website,
            'userCompanySize' => $user->company_size,
            'userCategories' => $userCategoryNames, // Now passing category names instead of IDs
            'userRole' => $user->role,
            'userEmailVerifiedAt' => $user->email_verified_at,
            'userCreatedAt' => $user->created_at,
            'userUpdatedAt' => $user->updated_at,
            'userIsVerified' => $user->is_verified,
            'userAboutCompany' => $user->about_company,
            'userLocation' => $user->location,
            'userSocialLinks' => $user->social_links,
            'userProfileImage' => $user->profile_image,
            'status' => session('status')
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit()
    {
        $user = Auth::user();
        
        // Get all categories from database
        $categories = Category::orderBy('name')->get();
        
        // Get user's current categories (assuming it's stored as JSON array of IDs)
        $userCategoryIds = $user->categories ? (is_string($user->categories) ? json_decode($user->categories, true) : $user->categories) : [];
        
        return Inertia::render('Profile/Edit', [
            'userName' => $user->name,
            'userEmail' => $user->email,
            'userPhone' => $user->phone,
            'userWebsite' => $user->website,
            'userCompanySize' => $user->company_size,
            'userLocation' => $user->location,
            'userSocialLinks' => $user->social_links,
            'categories' => $categories,
            'userCategories' => $userCategoryIds,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // Debug: Log the incoming request data
        \Log::info('Profile update request data:', ['data' => $request->all()]);
        
        // Get validated data from the request
        $validated = $request->validated();
        
        \Log::info('Validated data:', ['validated' => $validated]);
        
        // Handle categories - convert to JSON array of integers
        if (isset($validated['categories'])) {
            \Log::info('Categories before processing:', ['categories' => $validated['categories']]);
            
            // Convert all category IDs to integers
            $categoryIds = array_map('intval', $validated['categories']);
            \Log::info('Categories after integer conversion:', ['categories_int' => $categoryIds]);
            
            $validated['categories'] = json_encode($categoryIds);
            \Log::info('Categories after JSON encode:', ['categories_json' => $validated['categories']]);
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
        
        // Update all the fields
        $user->fill($validated);
        
        \Log::info('User data before save:', ['user_data' => $user->toArray()]);
        \Log::info('User categories before save:', ['categories' => $user->categories]);
        
        // Save the user
        $user->save();
        
        \Log::info('User data after save:', ['user_data' => $user->toArray()]);
        \Log::info('User categories after save:', ['categories' => $user->categories]);
        
        return Redirect::route('profile.show')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        return redirect()->route('profile.show')->with('message', 'Account deletion is currently disabled.');
    }
}
