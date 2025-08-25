<?php

namespace App\Http\Controllers;

use App\Models\OrderStatus;
use App\Models\BuyerCheckout;
use App\Models\OrderStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderStatusController extends Controller
{
    /**
     * Get all active order statuses
     */
    public function index()
    {
        $statuses = OrderStatus::active()
            ->orderBy('sort_order')
            ->get();

        return response()->json($statuses);
    }

    /**
     * Get status history for a specific order
     */
    public function getOrderHistory($orderId)
    {
        $history = OrderStatusHistory::where('buyer_checkout_id', $orderId)
            ->with(['orderStatus', 'changedByUser'])
            ->orderBy('changed_at', 'desc')
            ->get();

        return response()->json($history);
    }

    /**
     * Change order status
     */
    public function changeOrderStatus(Request $request, $orderId)
    {
        $request->validate([
            'status_id' => 'required|exists:order_statuses,id',
            'notes' => 'nullable|string|max:1000',
            'metadata' => 'nullable|array',
        ]);

        $order = BuyerCheckout::findOrFail($orderId);
        
        // Update status and create history
        $order->updateStatus(
            $request->status_id,
            Auth::id(),
            $request->notes,
            $request->metadata
        );

        // Return updated order with status info
        $order->load(['orderStatus', 'user']);
        
        return response()->json([
            'message' => 'Order status updated successfully',
            'order' => $order,
            'status_info' => [
                'id' => $order->orderStatus->id,
                'name' => $order->orderStatus->name,
                'slug' => $order->orderStatus->slug,
                'color' => $order->orderStatus->color,
                'description' => $order->orderStatus->description,
            ]
        ]);
    }

    /**
     * Get orders by status
     */
    public function getOrdersByStatus($statusSlug)
    {
        $orders = BuyerCheckout::with(['user', 'orderStatus'])
            ->withStatusSlug($statusSlug)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($orders);
    }

    /**
     * Get order status statistics
     */
    public function getStatusStatistics()
    {
        $statistics = OrderStatus::active()
            ->withCount('buyerCheckouts')
            ->orderBy('sort_order')
            ->get()
            ->map(function ($status) {
                return [
                    'id' => $status->id,
                    'name' => $status->name,
                    'slug' => $status->slug,
                    'color' => $status->color,
                    'count' => $status->buyer_checkouts_count,
                ];
            });

        return response()->json($statistics);
    }

    /**
     * Bulk update order statuses
     */
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:buyer_checkout,id',
            'status_id' => 'required|exists:order_statuses,id',
            'notes' => 'nullable|string|max:1000',
        ]);

        $updatedOrders = [];
        
        foreach ($request->order_ids as $orderId) {
            $order = BuyerCheckout::find($orderId);
            if ($order) {
                $order->updateStatus(
                    $request->status_id,
                    Auth::id(),
                    $request->notes,
                    ['bulk_update' => true]
                );
                $updatedOrders[] = $order->id;
            }
        }

        return response()->json([
            'message' => 'Orders updated successfully',
            'updated_orders' => $updatedOrders,
            'count' => count($updatedOrders)
        ]);
    }
}
