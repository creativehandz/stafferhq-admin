@component('mail::message')
# Order Confirmation

Thank you for your order! Here are the details of your purchase:

**Package Name:** {{ $packageName }}  
**Total Price:** ${{ $totalPrice }}  
**Delivery Time:** {{ $orderDetails['deliveryTime'] }}  


**Billing Information:**
{{ $billingDetails }}

If you have any questions, feel free to contact us.

Thanks,  
{{ config('app.name') }}
@endcomponent
