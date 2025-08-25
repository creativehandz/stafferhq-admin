<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\OrderStatus;
use App\Models\BuyerCheckout;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, ensure order statuses are seeded
        $this->seedOrderStatuses();
        
        // Now migrate existing status data
        $this->migrateExistingStatuses();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reset all order_status_id to null
        DB::table('buyer_checkout')->update(['order_status_id' => null]);
    }

    private function seedOrderStatuses()
    {
        $statuses = [
            [
                'name' => 'Order Placed',
                'slug' => 'order-placed',
                'color' => '#3B82F6',
                'description' => 'Order has been placed by the buyer',
                'sort_order' => 1,
                'is_initial' => true,
                'is_final' => false
            ],
            [
                'name' => 'Order Received',
                'slug' => 'order-received',
                'color' => '#8B5CF6',
                'description' => 'Order has been received by the seller',
                'sort_order' => 2,
                'is_initial' => false,
                'is_final' => false
            ],
            [
                'name' => 'Order Accepted',
                'slug' => 'order-accepted',
                'color' => '#10B981',
                'description' => 'Order has been accepted by the seller',
                'sort_order' => 3,
                'is_initial' => false,
                'is_final' => false
            ],
            [
                'name' => 'Started Work',
                'slug' => 'started-work',
                'color' => '#F59E0B',
                'description' => 'Seller has started working on the order',
                'sort_order' => 4,
                'is_initial' => false,
                'is_final' => false
            ],
            [
                'name' => 'Priority',
                'slug' => 'priority',
                'color' => '#EF4444',
                'description' => 'High priority order requiring immediate attention',
                'sort_order' => 5,
                'is_initial' => false,
                'is_final' => false
            ],
            [
                'name' => 'Active',
                'slug' => 'active',
                'color' => '#059669',
                'description' => 'Order is currently being worked on',
                'sort_order' => 6,
                'is_initial' => false,
                'is_final' => false
            ],
            [
                'name' => 'Late',
                'slug' => 'late',
                'color' => '#DC2626',
                'description' => 'Order is past its expected delivery date',
                'sort_order' => 7,
                'is_initial' => false,
                'is_final' => false
            ],
            [
                'name' => 'Delivered',
                'slug' => 'delivered',
                'color' => '#7C3AED',
                'description' => 'Order has been delivered to the buyer',
                'sort_order' => 8,
                'is_initial' => false,
                'is_final' => false
            ],
            [
                'name' => 'Completed',
                'slug' => 'completed',
                'color' => '#16A34A',
                'description' => 'Order has been completed successfully',
                'sort_order' => 9,
                'is_initial' => false,
                'is_final' => true
            ],
            [
                'name' => 'Cancelled',
                'slug' => 'cancelled',
                'color' => '#991B1B',
                'description' => 'Order has been cancelled',
                'sort_order' => 10,
                'is_initial' => false,
                'is_final' => true
            ],
            [
                'name' => 'Starred',
                'slug' => 'starred',
                'color' => '#F59E0B',
                'description' => 'Important order marked with a star',
                'sort_order' => 11,
                'is_initial' => false,
                'is_final' => false
            ]
        ];

        foreach ($statuses as $status) {
            DB::table('order_statuses')->insertOrIgnore([
                'name' => $status['name'],
                'slug' => $status['slug'],
                'color' => $status['color'],
                'description' => $status['description'],
                'sort_order' => $status['sort_order'],
                'is_active' => true,
                'is_initial' => $status['is_initial'],
                'is_final' => $status['is_final'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function migrateExistingStatuses()
    {
        // Get all existing orders with status
        $orders = DB::table('buyer_checkout')->whereNotNull('status')->get();

        foreach ($orders as $order) {
            // Try to find matching status in our new table
            $orderStatus = DB::table('order_statuses')
                ->where('name', $order->status)
                ->first();

            if ($orderStatus) {
                // Update the order with the new status ID
                DB::table('buyer_checkout')
                    ->where('id', $order->id)
                    ->update(['order_status_id' => $orderStatus->id]);

                // Create initial history entry
                DB::table('order_status_history')->insert([
                    'buyer_checkout_id' => $order->id,
                    'order_status_id' => $orderStatus->id,
                    'changed_by_user_id' => $order->user_id,
                    'notes' => 'Migrated from legacy status system',
                    'changed_at' => $order->created_at ?? now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                // If no exact match found, set to default "Order Placed" status
                $defaultStatus = DB::table('order_statuses')
                    ->where('name', 'Order Placed')
                    ->first();

                if ($defaultStatus) {
                    DB::table('buyer_checkout')
                        ->where('id', $order->id)
                        ->update(['order_status_id' => $defaultStatus->id]);

                    DB::table('order_status_history')->insert([
                        'buyer_checkout_id' => $order->id,
                        'order_status_id' => $defaultStatus->id,
                        'changed_by_user_id' => $order->user_id,
                        'notes' => "Migrated from legacy status: {$order->status}",
                        'changed_at' => $order->created_at ?? now(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
};
