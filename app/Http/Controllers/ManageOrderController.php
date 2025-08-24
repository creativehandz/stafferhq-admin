<?php

namespace App\Http\Controllers;

use App\Models\ManageOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ManageOrderController extends Controller
{
    /**
     * Display a listing of the orders for the authenticated user
     */
    public function index()
    {
        $orders = ManageOrder::where('user_id', Auth::id())
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        // Add status summary
        $statusSummary = [
            'total' => $orders->count(),
            'pending' => $orders->where('status', 'pending')->count(),
            'in_progress' => $orders->where('status', 'in_progress')->count(),
            'completed' => $orders->where('status', 'completed')->count(),
            'cancelled' => $orders->where('status', 'cancelled')->count(),
        ];

        return Inertia::render('Orders/ManageOrders', [
            'orders' => $orders,
            'statusSummary' => $statusSummary
        ]);
    }

    /**
     * Get orders by status for API
     */
    public function getOrdersByStatus(Request $request)
    {
        $status = $request->query('status');
        $userId = Auth::id();

        $query = ManageOrder::where('user_id', $userId)->with('user');

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'orders' => $orders,
            'total' => $orders->count()
        ]);
    }

    /**
     * Store a newly created order
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'buyer' => 'required|string|max:255',
            'gig' => 'required|string|max:255',
            'due_on' => 'required|date|after:today',
            'total' => 'required|numeric|min:0',
            'note' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,in_progress,completed,cancelled'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $order = ManageOrder::create([
            'user_id' => Auth::id(),
            'buyer' => $request->buyer,
            'gig' => $request->gig,
            'due_on' => $request->due_on,
            'total' => $request->total,
            'note' => $request->note,
            'status' => $request->status ?? 'pending'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully',
            'order' => $order->load('user')
        ], 201);
    }

    /**
     * Display the specified order
     */
    public function show($id)
    {
        $order = ManageOrder::where('user_id', Auth::id())
            ->where('id', $id)
            ->with('user')
            ->firstOrFail();

        return response()->json([
            'order' => $order
        ]);
    }

    /**
     * Update the specified order
     */
    public function update(Request $request, $id)
    {
        $order = ManageOrder::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'buyer' => 'sometimes|required|string|max:255',
            'gig' => 'sometimes|required|string|max:255',
            'due_on' => 'sometimes|required|date',
            'total' => 'sometimes|required|numeric|min:0',
            'note' => 'nullable|string|max:1000',
            'status' => 'sometimes|required|in:pending,in_progress,completed,cancelled'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $order->update($request->only([
            'buyer', 'gig', 'due_on', 'total', 'note', 'status'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully',
            'order' => $order->load('user')
        ]);
    }

    /**
     * Update only the status of an order
     */
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,in_progress,completed,cancelled'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $order = ManageOrder::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $order->status = $request->status;
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully',
            'order' => $order->load('user')
        ]);
    }

    /**
     * Remove the specified order
     */
    public function destroy($id)
    {
        $order = ManageOrder::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $order->delete();

        return response()->json([
            'success' => true,
            'message' => 'Order deleted successfully'
        ]);
    }

    /**
     * Get dashboard statistics for orders
     */
    public function getDashboardStats()
    {
        $userId = Auth::id();

        $stats = [
            'total_orders' => ManageOrder::where('user_id', $userId)->count(),
            'pending_orders' => ManageOrder::where('user_id', $userId)->where('status', 'pending')->count(),
            'in_progress_orders' => ManageOrder::where('user_id', $userId)->where('status', 'in_progress')->count(),
            'completed_orders' => ManageOrder::where('user_id', $userId)->where('status', 'completed')->count(),
            'total_earnings' => ManageOrder::where('user_id', $userId)->where('status', 'completed')->sum('total'),
            'due_soon' => ManageOrder::where('user_id', $userId)->dueSoon()->count(),
            'overdue' => ManageOrder::where('user_id', $userId)->overdue()->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Get orders due soon
     */
    public function getDueSoon()
    {
        $orders = ManageOrder::where('user_id', Auth::id())
            ->dueSoon()
            ->with('user')
            ->orderBy('due_on', 'asc')
            ->get();

        return response()->json([
            'orders' => $orders,
            'count' => $orders->count()
        ]);
    }

    /**
     * Get overdue orders
     */
    public function getOverdue()
    {
        $orders = ManageOrder::where('user_id', Auth::id())
            ->overdue()
            ->with('user')
            ->orderBy('due_on', 'asc')
            ->get();

        return response()->json([
            'orders' => $orders,
            'count' => $orders->count()
        ]);
    }
}
