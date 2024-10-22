<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('billing_details', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('full_name');
            $table->string('company_name')->nullable();
            $table->string('country');
            $table->string('state');
            $table->string('address');
            $table->string('city');
            $table->string('postal_code');
            $table->string('is_citizen'); // Yes/No or similar string value
            $table->string('tax_category');
            $table->boolean('want_invoices')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('billing_details');
    }
}
