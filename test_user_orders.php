<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Testing with User ID 3 (PranavTFCPPP)\n";
echo "=====================================\n";

$orders = DB::table('manage_orders')->where('user_id', 3)->get();
echo "Orders for user 3: " . count($orders) . "\n\n";

foreach($orders as $order) {
    echo "- {$order->gig} ({$order->status}) - {$order->created_at}\n";
}

echo "\nAll orders grouped by user:\n";
$ordersByUser = DB::table('manage_orders')
    ->select('user_id', DB::raw('count(*) as order_count'))
    ->groupBy('user_id')
    ->get();

foreach($ordersByUser as $userOrders) {
    echo "User {$userOrders->user_id}: {$userOrders->order_count} orders\n";
}
