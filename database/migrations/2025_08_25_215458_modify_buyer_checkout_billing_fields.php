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
            // Add individual billing fields
            $table->string('billing_full_name')->nullable();
            $table->string('billing_company_name')->nullable();
            $table->string('billing_country')->nullable();
            $table->string('billing_state')->nullable();
            $table->text('billing_address')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_postal_code')->nullable();
            $table->boolean('billing_citizen_resident')->nullable();
            $table->string('billing_tax_category')->nullable();
            $table->boolean('billing_want_invoices')->nullable();
            $table->string('billing_phone')->nullable();
            $table->string('billing_email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buyer_checkout', function (Blueprint $table) {
            // Drop the individual billing fields
            $table->dropColumn([
                'billing_full_name',
                'billing_company_name', 
                'billing_country',
                'billing_state',
                'billing_address',
                'billing_city',
                'billing_postal_code',
                'billing_citizen_resident',
                'billing_tax_category',
                'billing_want_invoices',
                'billing_phone',
                'billing_email'
            ]);
        });
    }
};
