<?php

namespace App\Http\Controllers;
use App\Models\User;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

            // Update the user's role
            $user->role = 2;
            $user->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Log the exception
            \Log::error('Switch to selling failed: ' . $e->getMessage());
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

            // Update the user's role
            $user->role = 1;
            $user->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Log the exception
            \Log::error('Switch to buying failed: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

}
