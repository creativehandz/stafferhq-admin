<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Get notifications for the authenticated user
     */
    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // Get recent notifications for the authenticated user
            $notifications = Notification::where('user_id', $user->id)
                ->recent(10)
                ->get()
                ->map(function ($notification) {
                    return [
                        'id' => $notification->id,
                        'type' => $notification->type,
                        'title' => $notification->title,
                        'details' => $notification->message,
                        'time' => $notification->created_at->format('d M, Y'),
                        'route' => $notification->route ?: '#',
                        'is_read' => $notification->is_read,
                        'data' => $notification->data
                    ];
                });

            // Count unread notifications
            $unreadCount = Notification::where('user_id', $user->id)
                ->unread()
                ->count();

            return response()->json([
                'notifications' => $notifications,
                'unread_count' => $unreadCount,
                'has_unread' => $unreadCount > 0
            ]);

        } catch (\Exception $e) {
            \Log::error('Error fetching notifications:', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return response()->json(['error' => 'Failed to fetch notifications'], 500);
        }
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Request $request, $id)
    {
        try {
            $user = Auth::user();
            
            $notification = Notification::where('id', $id)
                ->where('user_id', $user->id)
                ->first();

            if (!$notification) {
                return response()->json(['error' => 'Notification not found'], 404);
            }

            $notification->markAsRead();

            return response()->json(['success' => 'Notification marked as read']);

        } catch (\Exception $e) {
            \Log::error('Error marking notification as read:', [
                'error' => $e->getMessage(),
                'notification_id' => $id,
                'user_id' => Auth::id()
            ]);

            return response()->json(['error' => 'Failed to mark notification as read'], 500);
        }
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(Request $request)
    {
        try {
            $user = Auth::user();
            
            Notification::where('user_id', $user->id)
                ->unread()
                ->update(['is_read' => true]);

            return response()->json(['success' => 'All notifications marked as read']);

        } catch (\Exception $e) {
            \Log::error('Error marking all notifications as read:', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return response()->json(['error' => 'Failed to mark all notifications as read'], 500);
        }
    }

    /**
     * Get unread notification count
     */
    public function getUnreadCount()
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $unreadCount = Notification::where('user_id', $user->id)
                ->unread()
                ->count();

            return response()->json(['count' => $unreadCount]);

        } catch (\Exception $e) {
            \Log::error('Error getting unread count:', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return response()->json(['error' => 'Failed to get unread count'], 500);
        }
    }
}
