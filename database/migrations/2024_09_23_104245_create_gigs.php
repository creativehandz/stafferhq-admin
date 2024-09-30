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
        Schema::create('gigs', function (Blueprint $table) { 
            $table->id();
            $table->string('name')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('gig')->nullable();
            $table->string('gig_title')->nullable();
            $table->string('gig_description')->nullable(); // description
            $table->string('category_id')->nullable();
            $table->string('subcategory_id')->nullable();
            $table->string('positive_keywords')->nullable();
            $table->integer('clicks')->nullable();
            $table->integer('orders')->nullable();
            $table->integer('cancellations')->nullable();
            $table->text('requirements')->nullable();
            $table->string('status')->nullable();
            $table->string('faqs')->nullable(); // New column for FAQs
            $table->json('pricing')->nullable();
            $table->timestamps();      
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gigs');
    }
};
