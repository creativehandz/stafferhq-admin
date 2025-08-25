<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'name' => 'Order Placed',
                'slug' => 'order-placed',
                'color' => '#3B82F6', // Blue
                'description' => 'Order has been placed by the buyer',
                'sort_order' => 1,
                'is_initial' => true,
                'is_final' => false
            ],
            [
                'name' => 'Order Received',
                'slug' => 'order-received',
                'color' => '#8B5CF6', // Purple
                'description' => 'Order has been received by the seller',
                'sort_order' => 2,
                'is_initial' => false,
                'is_final' => false
            ],
            [
                'name' => 'Order Accepted',
                'slug' => 'order-accepted',
                'color' => '#10B981', // Green
                'description' => 'Order has been accepted by the seller',
                'sort_order' => 3,
                'is_initial' => false,
                'is_final' => false
            ],
            [
                'name' => 'Started Work',
                'slug' => 'started-work',
                'color' => '#F59E0B', // Yellow
                'description' => 'Seller has started working on the order',
                'sort_order' => 4,
                'is_initial' => false,
                'is_final' => false
            ],
            [
                'name' => 'Priority',
                'slug' => 'priority',
                'color' => '#EF4444', // Red
                'description' => 'High priority order requiring immediate attention',
                'sort_order' => 5,
                'is_initial' => false,
                'is_final' => false
            ],
            [
                'name' => 'Active',
                'slug' => 'active',
                'color' => '#059669', // Emerald
                'description' => 'Order is currently being worked on',
                'sort_order' => 6,
                'is_initial' => false,
                'is_final' => false
            ],
            [
                'name' => 'Late',
                'slug' => 'late',
                'color' => '#DC2626', // Dark Red
                'description' => 'Order is past its expected delivery date',
                'sort_order' => 7,
                'is_initial' => false,
                'is_final' => false
            ],
            [
                'name' => 'Delivered',
                'slug' => 'delivered',
                'color' => '#7C3AED', // Violet
                'description' => 'Order has been delivered to the buyer',
                'sort_order' => 8,
                'is_initial' => false,
                'is_final' => false
            ],
            [
                'name' => 'Completed',
                'slug' => 'completed',
                'color' => '#16A34A', // Dark Green
                'description' => 'Order has been completed successfully',
                'sort_order' => 9,
                'is_initial' => false,
                'is_final' => true
            ],
            [
                'name' => 'Cancelled',
                'slug' => 'cancelled',
                'color' => '#991B1B', // Dark Red
                'description' => 'Order has been cancelled',
                'sort_order' => 10,
                'is_initial' => false,
                'is_final' => true
            ],
            [
                'name' => 'Starred',
                'slug' => 'starred',
                'color' => '#F59E0B', // Amber
                'description' => 'Important order marked with a star',
                'sort_order' => 11,
                'is_initial' => false,
                'is_final' => false
            ]
        ];

        foreach ($statuses as $status) {
            DB::table('order_statuses')->insert([
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
}
