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
        Schema::create('order_status_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_checkout_id')->constrained('buyer_checkout')->onDelete('cascade');
            $table->foreignId('order_status_id')->constrained('order_statuses')->onDelete('cascade');
            $table->foreignId('changed_by_user_id')->constrained('users')->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable(); // For additional data like delivery files, etc.
            $table->timestamp('changed_at');
            $table->timestamps();
            
            // Index for faster queries
            $table->index(['buyer_checkout_id', 'changed_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_status_history');
    }
};
