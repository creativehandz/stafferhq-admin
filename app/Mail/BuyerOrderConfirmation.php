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
        return $this->subject('Order Confirmation')
                    ->markdown('mail.buyer_order_confirmation')
                    ->with([
                        'packageName' => $this->buyerCheckout->package_selected,
                        'totalPrice' => $this->buyerCheckout->total_price,
                        'orderDetails' => json_decode($this->buyerCheckout->order_details, true), // assuming it's stored as JSON
                        'billingDetails' => $this->buyerCheckout->billing_details,
                    ]);
    }
}
