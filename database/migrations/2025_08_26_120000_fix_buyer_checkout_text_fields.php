<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('buyer_checkout', function (Blueprint $table) {
            // Change order_details from varchar(255) to text to accommodate larger JSON data
            $table->text('order_details')->change();
            
            // Also ensure billing_details can handle larger data if needed
            $table->text('billing_details')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buyer_checkout', function (Blueprint $table) {
            // Revert back to original types
            $table->string('order_details', 255)->change();
            $table->string('billing_details', 1000)->change();
        });
    }
};
