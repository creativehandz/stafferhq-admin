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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Who receives the notification
            $table->string('type'); // Type of notification (order, message, etc.)
            $table->string('title'); // Notification title
            $table->text('message'); // Notification message/details
            $table->json('data')->nullable(); // Additional data (order_id, gig_id, etc.)
            $table->boolean('is_read')->default(false); // Read status
            $table->string('route')->nullable(); // Route to navigate when clicked
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['user_id', 'is_read']); // For efficient querying
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
