<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
</head>
<body>
    <h1>Thank You for Your Order!</h1>
    <p>Dear {{ $order->buyer_name }},</p>
    <p>Your order has been successfully placed. Here are the details:</p>
    <ul>
        <li>Order ID: {{ $order->id }}</li>
        <li>Total Amount: {{ $order->total }}</li>
        <li>Order Details: {{ $order->details }}</li>
    </ul>
    <p>Thank you for shopping with us!</p>
</body>
</html>
