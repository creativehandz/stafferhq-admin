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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('gig')->nullable();;
            $table->integer('impressions')->nullable();
            $table->integer('clicks')->nullable();
            $table->integer('orders')->nullable();
            $table->integer('cancellations')->nullable();
            $table->string('status')->nullable();
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
