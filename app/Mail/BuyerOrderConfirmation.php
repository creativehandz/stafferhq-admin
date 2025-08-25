<?php

namespace App\Mail;

use App\Models\BuyerCheckout;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BuyerOrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $buyerCheckout;

    /**
     * Create a new message instance.
     *
     * @param BuyerCheckout $buyerCheckout
     */
    public function __construct(BuyerCheckout $buyerCheckout)
    {
        $this->buyerCheckout = $buyerCheckout;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Get order details - handle both array and JSON string formats
        $orderDetails = $this->buyerCheckout->order_details;
        if (is_string($orderDetails)) {
            $orderDetails = json_decode($orderDetails, true);
        }
        
        // Get billing details - handle both array and JSON string formats
        $billingDetails = $this->buyerCheckout->billing_details;
        if (is_string($billingDetails)) {
            $billingDetails = json_decode($billingDetails, true);
        }

        return $this->subject('Order Confirmation')
                    ->markdown('mail.buyer_order_confirmation')
                    ->with([
                        'packageName' => $this->buyerCheckout->package_selected,
                        'totalPrice' => $this->buyerCheckout->total_price,
                        'orderDetails' => $orderDetails,
                        'billingDetails' => $billingDetails,
                    ]);
    }
}
