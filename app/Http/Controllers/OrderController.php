<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    public function getOrdersByStatus(): Response
    {
        $orders = Order::all(); 

        return Inertia::render('Talent/YourActiveContracts', [
            'orders' => $orders,
        ]);
    }
}
