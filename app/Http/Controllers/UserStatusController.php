<?php

namespace App\Http\Controllers;

use App\Events\UserOnlineStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserStatusController extends Controller
{
    /**
     * Update the user's online status and broadcast it to other users.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateOnlineStatus(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'userId' => 'required|integer|exists:users,id',
            'isOnline' => 'required|boolean',
        ]);

        $userId = $request->input('userId');
        $isOnline = $request->input('isOnline');

        // Optionally, store the user's online status in the database
        // You would need to add a `is_online` field to your `users` table for this
        // $user = User::find($userId);
        // $user->is_online = $isOnline;
        // $user->save();

        // Broadcast the OnlineStatus event to other users
        broadcast(new UserOnlineStatus($userId, $isOnline))->toOthers();

        // Return a success response
        return response()->json([
            'status' => 'success',
            'message' => $isOnline? "'User online status updated': True" : "'User online status updated': False",
        ]);
    }
}


