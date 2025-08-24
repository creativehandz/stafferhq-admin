<?php

namespace App\Http\Controllers;

use App\Models\Gig;
use App\Models\User;
use App\Models\ManageOrder;
use App\Models\Message;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the main dashboard
     */
    public function index()
    {
        $user = Auth::user();
        $userId = $user->id;

        // Get comprehensive dashboard stats
        $stats = $this->getDashboardStats($userId, $user->role);

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'user' => $user
        ]);
    }

    /**
     * Get seller dashboard data
     */
    public function sellerDashboard()
    {
        $user = Auth::user();
        $userId = $user->id;

        if ($user->role !== 2) { // Not a seller
            return redirect()->route('dashboard')->with('error', 'Access denied. Seller account required.');
        }

        $stats = $this->getSellerStats($userId);

        return Inertia::render('SellerDashboard', [
            'stats' => $stats,
            'user' => $user
        ]);
    }

    /**
     * Get dashboard statistics API endpoint
     */
    public function getStats()
    {
        $user = Auth::user();
        $stats = $this->getDashboardStats($user->id, $user->role);

        return response()->json($stats);
    }

    /**
     * Get seller statistics API endpoint
     */
    public function getSellerStatsApi()
    {
        $user = Auth::user();
        
        if ($user->role !== 2) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $stats = $this->getSellerStats($user->id);

        return response()->json($stats);
    }

    /**
     * Get comprehensive dashboard statistics
     */
    private function getDashboardStats($userId, $userRole)
    {
        $stats = [
            'user_role' => $userRole,
            'greeting' => $this->getTimeBasedGreeting(),
        ];

        // Role-based stats
        switch ($userRole) {
            case 1: // Buyer
                $stats = array_merge($stats, $this->getBuyerStats($userId));
                break;
            case 2: // Seller
                $stats = array_merge($stats, $this->getSellerStats($userId));
                break;
            case 3: // Admin
                $stats = array_merge($stats, $this->getAdminStats());
                break;
            default:
                $stats = array_merge($stats, $this->getDefaultStats($userId));
        }

        return $stats;
    }

    /**
     * Get buyer-specific statistics
     */
    private function getBuyerStats($userId)
    {
        return [
            'active_orders' => ManageOrder::where('buyer_id', $userId)->whereIn('status', ['pending', 'in_progress'])->count(),
            'completed_orders' => ManageOrder::where('buyer_id', $userId)->where('status', 'completed')->count(),
            'total_spent' => ManageOrder::where('buyer_id', $userId)->where('status', 'completed')->sum('total'),
            'messages_count' => Message::where('receiver_id', $userId)->count(), // Simplified
            'favorite_gigs' => 0, // TODO: Implement favorites system
        ];
    }

    /**
     * Get seller-specific statistics
     */
    private function getSellerStats($userId)
    {
        $today = Carbon::today();
        $thisWeek = Carbon::now()->startOfWeek();
        $thisMonth = Carbon::now()->startOfMonth();

        return [
            // Gig Stats
            'total_gigs' => Gig::where('user_id', $userId)->count(),
            'active_gigs' => Gig::where('user_id', $userId)->where('status', 'active')->count(),
            'paused_gigs' => Gig::where('user_id', $userId)->where('status', 'paused')->count(),
            'draft_gigs' => Gig::where('user_id', $userId)->where('status', 'draft')->count(),

            // Order Stats
            'total_orders' => ManageOrder::where('user_id', $userId)->count(),
            'pending_orders' => ManageOrder::where('user_id', $userId)->where('status', 'pending')->count(),
            'in_progress_orders' => ManageOrder::where('user_id', $userId)->where('status', 'in_progress')->count(),
            'completed_orders' => ManageOrder::where('user_id', $userId)->where('status', 'completed')->count(),
            'cancelled_orders' => ManageOrder::where('user_id', $userId)->where('status', 'cancelled')->count(),

            // Financial Stats
            'total_earnings' => ManageOrder::where('user_id', $userId)->where('status', 'completed')->sum('total'),
            'this_month_earnings' => ManageOrder::where('user_id', $userId)
                ->where('status', 'completed')
                ->where('created_at', '>=', $thisMonth)
                ->sum('total'),
            'this_week_earnings' => ManageOrder::where('user_id', $userId)
                ->where('status', 'completed')
                ->where('created_at', '>=', $thisWeek)
                ->sum('total'),
            'today_earnings' => ManageOrder::where('user_id', $userId)
                ->where('status', 'completed')
                ->whereDate('created_at', $today)
                ->sum('total'),

            // Performance Stats
            'completion_rate' => $this->getCompletionRate($userId),
            'average_delivery_time' => $this->getAverageDeliveryTime($userId),
            'customer_satisfaction' => 4.8, // TODO: Implement rating system

            // Communication Stats
            'unread_messages' => Message::where('receiver_id', $userId)->count(), // Simplified - count all messages
            'total_messages' => Message::where('receiver_id', $userId)->count(),

            // Due Dates
            'due_soon' => ManageOrder::where('user_id', $userId)
                ->whereIn('status', ['pending', 'in_progress'])
                ->where('due_on', '<=', Carbon::now()->addDays(3))
                ->count(),
            'overdue' => ManageOrder::where('user_id', $userId)
                ->whereIn('status', ['pending', 'in_progress'])
                ->where('due_on', '<', Carbon::now())
                ->count(),

            // Recent Activity
            'recent_orders' => ManageOrder::where('user_id', $userId)
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(),
        ];
    }

    /**
     * Get admin statistics
     */
    private function getAdminStats()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();

        return [
            'total_users' => User::count(),
            'total_buyers' => User::where('role', 1)->count(),
            'total_sellers' => User::where('role', 2)->count(),
            'total_admins' => User::where('role', 3)->count(),
            'new_users_today' => User::whereDate('created_at', $today)->count(),
            'new_users_this_month' => User::where('created_at', '>=', $thisMonth)->count(),

            'total_gigs' => Gig::count(),
            'active_gigs' => Gig::where('status', 'active')->count(),
            'pending_gigs' => Gig::where('status', 'pending')->count(),

            'total_orders' => ManageOrder::count(),
            'pending_orders' => ManageOrder::where('status', 'pending')->count(),
            'completed_orders' => ManageOrder::where('status', 'completed')->count(),
            'total_revenue' => ManageOrder::where('status', 'completed')->sum('total'),
            'today_revenue' => ManageOrder::where('status', 'completed')->whereDate('created_at', $today)->sum('total'),
            'this_month_revenue' => ManageOrder::where('status', 'completed')->where('created_at', '>=', $thisMonth)->sum('total'),

            'total_messages' => Message::count(),
            'unread_messages' => Message::count(), // Simplified
        ];
    }

    /**
     * Get default statistics for unknown roles
     */
    private function getDefaultStats($userId)
    {
        return [
            'orders_count' => ManageOrder::where('user_id', $userId)->count(),
            'messages_count' => Message::where('receiver_id', $userId)->count(), // Simplified
            'gigs_count' => Gig::where('user_id', $userId)->count(),
        ];
    }

    /**
     * Calculate completion rate for seller
     */
    private function getCompletionRate($userId)
    {
        $totalOrders = ManageOrder::where('user_id', $userId)->count();
        if ($totalOrders === 0) return 0;

        $completedOrders = ManageOrder::where('user_id', $userId)->where('status', 'completed')->count();
        return round(($completedOrders / $totalOrders) * 100, 1);
    }

    /**
     * Calculate average delivery time for seller
     */
    private function getAverageDeliveryTime($userId)
    {
        $completedOrders = ManageOrder::where('user_id', $userId)
            ->where('status', 'completed')
            ->whereNotNull('updated_at')
            ->whereNotNull('created_at')
            ->get();

        if ($completedOrders->isEmpty()) return 0;

        $totalDays = $completedOrders->sum(function ($order) {
            return Carbon::parse($order->created_at)->diffInDays(Carbon::parse($order->updated_at));
        });

        return round($totalDays / $completedOrders->count(), 1);
    }

    /**
     * Get time-based greeting
     */
    private function getTimeBasedGreeting()
    {
        $hour = Carbon::now()->hour;

        if ($hour < 12) {
            return "Good Morning";
        } elseif ($hour < 17) {
            return "Good Afternoon";
        } else {
            return "Good Evening";
        }
    }

    /**
     * Get weekly performance data
     */
    public function getWeeklyPerformance()
    {
        $user = Auth::user();
        $startOfWeek = Carbon::now()->startOfWeek();

        $weeklyData = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $weeklyData[] = [
                'date' => $date->format('Y-m-d'),
                'day' => $date->format('l'),
                'orders' => ManageOrder::where('user_id', $user->id)
                    ->whereDate('created_at', $date)
                    ->count(),
                'earnings' => ManageOrder::where('user_id', $user->id)
                    ->where('status', 'completed')
                    ->whereDate('updated_at', $date)
                    ->sum('total'),
            ];
        }

        return response()->json($weeklyData);
    }

    /**
     * Get monthly performance data
     */
    public function getMonthlyPerformance()
    {
        $user = Auth::user();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $monthlyData = ManageOrder::where('user_id', $user->id)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as orders, SUM(CASE WHEN status = "completed" THEN total ELSE 0 END) as earnings')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json($monthlyData);
    }
}
