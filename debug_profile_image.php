<?php

// Test script to debug profile image upload issue
// Place this in the update method of BuyerProfileController to debug

use Illuminate\Support\Facades\Log;

class DebugProfileImageUpload {
    
    public static function debug($request, $user, $validated) {
        Log::info('=== PROFILE IMAGE DEBUG ===');
        Log::info('Request has file: ' . ($request->hasFile('profile_image') ? 'YES' : 'NO'));
        
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            Log::info('File details:', [
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'is_valid' => $file->isValid()
            ]);
        }
        
        Log::info('Validated data contains profile_image: ' . (isset($validated['profile_image']) ? 'YES' : 'NO'));
        
        if (isset($validated['profile_image'])) {
            Log::info('Profile image path: ' . $validated['profile_image']);
        }
        
        Log::info('User before save:', [
            'id' => $user->id,
            'name' => $user->name,
            'profile_image' => $user->profile_image
        ]);
        
        // After fill
        Log::info('User after fill:', [
            'id' => $user->id,
            'name' => $user->name,
            'profile_image' => $user->profile_image
        ]);
        
        // Check if profile_image is in fillable
        Log::info('User fillable fields: ' . implode(', ', $user->getFillable()));
        Log::info('Profile image in fillable: ' . (in_array('profile_image', $user->getFillable()) ? 'YES' : 'NO'));
        
        Log::info('=== END DEBUG ===');
    }
}

// Add this to your BuyerProfileController update method before $user->save():
// DebugProfileImageUpload::debug($request, $user, $validated);
