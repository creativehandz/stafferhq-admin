<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ManageOrder;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function getOrdersByStatus(): Response
    {
        // Get orders for the currently authenticated seller
        $orders = ManageOrder::forUser(Auth::id())
                            ->with('user')
                            ->orderBy('created_at', 'desc')
                            ->get();

        // Group orders by status for better display
        $ordersByStatus = [
            'pending' => $orders->where('status', 'pending'),
            'in_progress' => $orders->where('status', 'in_progress'),
            'completed' => $orders->where('status', 'completed'),
            'cancelled' => $orders->where('status', 'cancelled'),
        ];

        return Inertia::render('Talent/YourActiveContracts', [
            'orders' => $orders,
            'ordersByStatus' => $ordersByStatus,
            'stats' => [
                'total' => $orders->count(),
                'pending' => $orders->where('status', 'pending')->count(),
                'in_progress' => $orders->where('status', 'in_progress')->count(),
                'completed' => $orders->where('status', 'completed')->count(),
                'overdue' => ManageOrder::forUser(Auth::id())->overdue()->count(),
                'due_soon' => ManageOrder::forUser(Auth::id())->dueSoon()->count(),
            ]
        ]);
    }
}
