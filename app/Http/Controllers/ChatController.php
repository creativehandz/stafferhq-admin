<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Events\UserOnlineStatus;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;



class ChatController extends Controller
{
    public function fetchMessages($receiverId)
    {
        $userId = Auth::id();

        // Fetch messages between the authenticated user and the receiver
        $messages = Message::where(function($query) use ($userId, $receiverId) {
            $query->where('user_id', $userId)
                  ->where('receiver_id', $receiverId);
        })->orWhere(function($query) use ($userId, $receiverId) {
            $query->where('user_id', $receiverId)
                  ->where('receiver_id', $userId);
        })->with(['sender', 'receiver'])
          ->orderBy('created_at', 'asc')
          ->get();

        //   return Inertia::render('Messages', [
        //     'messages' => $messages,
        // ]);
        return response()->json($messages);
    }

    public function fetchLastMessages()
    {
        $userId = Auth::id();
    
        // Fetch the last message for each conversation involving the authenticated user
        $messages = Message::select('messages.*')
            ->where(function($query) use ($userId) {
                $query->where('user_id', $userId)
                      ->orWhere('receiver_id', $userId);
            })
            ->orderBy('created_at', 'desc') // Order by latest message first
            ->get()
            ->unique(function (Message $message) use ($userId) {
                // Unique by the conversation partner
                return $message->user_id === $userId ? $message->receiver_id : $message->user_id;
            });
    
        return response()->json($messages);
    }    

    /**
     * Send a new message.
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'receiver_id' => 'required|exists:users,id',
        ]);
        try {
            $message = new Message();
            $message->user_id = Auth::id(); // Sender is the currently authenticated user
            $message->receiver_id = $request->receiver_id;
            $message->message = $request->message;
            $message->save();
            
            // Broadcast the message to other users
            broadcast(new MessageSent($message))->toOthers();

            return response()->json(['status' => 'Message Sent!', 'message' => $message]);
        }catch (\Exception $e) {
            // Log the exception and return an error response
            \Log::error('Message sending failed: '.$e->getMessage());
            return response()->json(['error' => 'Failed to send message'], 500);
        }
    }

    public function fetchUsers()
    {
        // Get the ID of the currently authenticated user
        $currentUserId = Auth::id();

        // Fetch all users except the currently authenticated user
        $users = User::where('id', '!=', $currentUserId)->get();

        return Inertia::render('Messages', [
                'users' => $users,
            ]);
    }

}
