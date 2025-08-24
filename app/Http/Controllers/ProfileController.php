<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
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
        
        return Inertia::render('Profile/View', [
            'userName' => $user->name,
            'userEmail' => $user->email,
            'userPhone' => $user->phone,
            'userWebsite' => $user->website,
            'userCompanySize' => $user->company_size,
            'userCategories' => $user->user_categories->toArray(), // Get category names instead of IDs
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
        
        return Inertia::render('Profile/Edit', [
            'userName' => $user->name,
            'userEmail' => $user->email,
            'userPhone' => $user->phone,
            'userWebsite' => $user->website,
            'userCompanySize' => $user->company_size,
            'userLocation' => $user->location,
            'userSocialLinks' => $user->social_links,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // Get validated data from the request
        $validated = $request->validated();
        
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
        
        // Save the user
        $user->save();
        
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
