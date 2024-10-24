<!DOCTYPE html>
<html>
<head>
    <title>New Order Notification</title>
</head>
<body>
    <h1>You Have a New Order!</h1>
    <p>Dear Seller,</p>
    <p>A new order has been placed. Here are the details:</p>
    <ul>
        <li>Order ID: {{ $order->id }}</li>
        <li>Buyer Name: {{ $order->buyer_name }}</li>
        <li>Total Amount: {{ $order->total }}</li>
        <li>Order Details: {{ $order->details }}</li>
    </ul>
    <p>Please process this order as soon as possible.</p>
</body>
</html>
