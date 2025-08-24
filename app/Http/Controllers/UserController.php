<?php

namespace App\Http\Controllers;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function getUsersByRole($role)
    {
        $users = User::where('role', $role)->get();
        return response()->json($users);
    }

    public function switchToSelling(Request $request)
    {
        try {
            // Ensure the user is authenticated
            if (!Auth::check()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $user = Auth::user();

            // Update the user's role to seller (role = 2)
            $user->role = 2;
            $user->save();

            // If it's an Inertia request, redirect to dashboard
            if ($request->header('X-Inertia')) {
                return Redirect::route('dashboard')->with('success', 'Successfully switched to selling mode!');
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Log the exception
            \Log::error('Switch to selling failed: ' . $e->getMessage());
            
            if ($request->header('X-Inertia')) {
                return Redirect::back()->withErrors(['error' => 'Something went wrong while switching to selling mode.']);
            }
            
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function switchToBuying(Request $request)
    {
        try {
            // Ensure the user is authenticated
            if (!Auth::check()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $user = Auth::user();

            // Update the user's role to buyer (role = 1)
            $user->role = 1;
            $user->save();

            // If it's an Inertia request, redirect to dashboard
            if ($request->header('X-Inertia')) {
                return Redirect::route('dashboard')->with('success', 'Successfully switched to buying mode!');
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Log the exception
            \Log::error('Switch to buying failed: ' . $e->getMessage());
            
            if ($request->header('X-Inertia')) {
                return Redirect::back()->withErrors(['error' => 'Something went wrong while switching to buying mode.']);
            }
            
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
}
