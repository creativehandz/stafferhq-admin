<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use App\Mail\OrderNotification;
use Illuminate\Support\Facades\Mail as FacadesMail;

class MailController extends Controller
{
    public function index()
    {
        $mailData = [
            'title' => 'Mail from ToWork',
            'body' => 'Your order has been created. Order ID #####',
        ];

        FacadesMail::to('ms28.dev@gmail.com')->send(new OrderNotification($mailData));

        dd('Order Created and Email send successfully');
    }
}
