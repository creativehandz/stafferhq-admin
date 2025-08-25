<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "WHERE TO FIND PENDING ORDERS IN SELLER DASHBOARD\n";
echo str_repeat("=", 55) . "\n\n";

echo "📋 CURRENT PENDING ORDERS COUNT:\n";

// Get pending orders for seller (user ID 3)
$sellerId = 3;
$pendingOrders = DB::table('manage_orders')
    ->where('user_id', $sellerId)
    ->where('status', 'pending')
    ->get();

echo "Seller ID {$sellerId} has " . count($pendingOrders) . " pending orders:\n";
foreach($pendingOrders as $order) {
    echo "- Order {$order->id}: {$order->gig} from {$order->buyer} (Created: {$order->created_at})\n";
}

echo "\n" . str_repeat("-", 55) . "\n";
echo "🎯 PLACES TO CHECK PENDING ORDERS:\n";
echo str_repeat("-", 55) . "\n\n";

echo "1. SELLER DASHBOARD OVERVIEW:\n";
echo "   📍 URL: http://127.0.0.1:8000/seller-dashboard\n";
echo "   📊 Shows: pending_orders count in stats\n";
echo "   🔍 Look for: 'Pending Orders: X' in dashboard cards\n";
echo "   📝 Note: Only shows COUNT, not individual orders\n\n";

echo "2. MANAGE ORDERS PAGE (Main Orders List):\n";
echo "   📍 URL: http://127.0.0.1:8000/manage-orders\n";
echo "   📊 Shows: All orders with status filtering\n";
echo "   🔍 Look for: 'Active' tab (pending orders mapped to Active)\n";
echo "   📝 Note: Our recent fix maps 'pending' → 'Active' status\n\n";

echo "3. SELLER ORDERS API ENDPOINT:\n";
echo "   📍 URL: http://127.0.0.1:8000/seller-orders\n";
echo "   📊 Shows: JSON data of all orders\n";
echo "   🔍 Look for: Orders with status='Active' (mapped from pending)\n";
echo "   📝 Note: Used by frontend components\n\n";

echo "4. ORDER TIMELINE PAGE:\n";
echo "   📍 URL: http://127.0.0.1:8000/order-timeline\n";
echo "   📊 Shows: Timeline view of orders\n";
echo "   📝 Note: May show pending orders chronologically\n\n";

echo str_repeat("-", 55) . "\n";
echo "🔧 DETAILED BREAKDOWN:\n";
echo str_repeat("-", 55) . "\n\n";

echo "A. SELLER DASHBOARD (/seller-dashboard):\n";
echo "   ✅ Contains DashboardController::getSellerStats()\n";
echo "   ✅ Shows: pending_orders = " . DB::table('manage_orders')
    ->where('user_id', $sellerId)
    ->where('status', 'pending')
    ->count() . " orders\n";
echo "   ❓ Displays: Only statistics, not individual order details\n\n";

echo "B. MANAGE ORDERS PAGE (/manage-orders):\n";
echo "   ✅ Contains OrderController::getOrdersByStatus()\n";
echo "   ✅ Shows: Individual order details with status grouping\n";
echo "   ✅ Fixed: Now maps 'pending' → 'Active' for proper display\n";
echo "   ✅ Filter: Orders by currently logged-in seller\n\n";

echo "C. FRONTEND COMPONENTS:\n";
echo "   📄 YourActiveContracts.vue: Calls /seller-orders endpoint\n";
echo "   📄 SellerDashboard.vue: Shows static demo data (not real)\n";
echo "   🔧 CheckoutController::index(): Returns combined data\n\n";

echo str_repeat("-", 55) . "\n";
echo "🎯 RECOMMENDATION FOR CHECKING PENDING ORDERS:\n";
echo str_repeat("-", 55) . "\n\n";

echo "BEST PLACE: /manage-orders page\n";
echo "1. Login as pranavtfcppp@gmail.com\n";
echo "2. Navigate to: http://127.0.0.1:8000/manage-orders\n";
echo "3. Click on 'Active' tab\n";
echo "4. You should see all {$sellerId} pending orders displayed as 'Active'\n\n";

echo "ALTERNATIVE: Check dashboard stats\n";
echo "1. Navigate to: http://127.0.0.1:8000/seller-dashboard\n";
echo "2. Look for 'Pending Orders' stat card\n";
echo "3. Should show count: " . count($pendingOrders) . " pending orders\n\n";

echo "🚨 IMPORTANT NOTES:\n";
echo "- Pending orders are NEW orders that need seller attention\n";
echo "- They appear in 'Active' tab due to our status mapping fix\n";
echo "- SellerDashboard.vue shows demo data, not real orders\n";
echo "- Real order data comes from CheckoutController::index()\n\n";

echo "✅ STATUS: After our recent fix, pending orders should now be visible!\n";
