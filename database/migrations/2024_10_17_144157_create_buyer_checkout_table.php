<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuyerCheckoutTable extends Migration
{
    public function up()
    {
        Schema::create('buyer_checkout', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->unsignedBigInteger('user_id'); // User ID
            $table->unsignedBigInteger('gig_id'); // Gig ID
            $table->string('order_details'); // Order details
            $table->string('package_selected', 255); // Package selected
            $table->decimal('total_price', 8, 2); // Total price
            $table->timestamps(); // created_at and updated_at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('buyer_checkout');
    }
}
