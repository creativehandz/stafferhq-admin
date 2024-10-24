<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuyerCheckoutTable extends Migration
{
    public function up()
    {
        Schema::create('buyer_checkout', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('order_details'); // Store the order details as JSON or text
            $table->text('billing_details');
            $table->string('package_selected');
            $table->decimal('total_price', 8, 2); // 8 digits total, 2 after decimal
            $table->text('status');
            $table->unsignedBigInteger('gig_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('buyer_checkout');
    }
}
