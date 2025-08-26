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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('buyer_checkout')->onDelete('cascade');
            $table->foreignId('reviewer_id')->constrained('users')->onDelete('cascade'); // Seller ID
            $table->foreignId('reviewee_id')->constrained('users')->onDelete('cascade'); // Buyer ID
            $table->enum('review_type', ['seller_to_buyer', 'buyer_to_seller']); // Allow for future buyer-to-seller reviews
            $table->integer('rating')->unsigned()->check('rating >= 1 AND rating <= 5');
            $table->text('review_text');
            $table->json('review_criteria')->nullable(); // For structured reviews (communication, quality, etc.)
            $table->boolean('is_public')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->timestamp('reviewed_at')->useCurrent();
            $table->timestamps();
            
            // Ensure one review per seller per order
            $table->unique(['order_id', 'reviewer_id', 'review_type']);
            
            // Add indexes for better performance
            $table->index(['reviewee_id', 'review_type']);
            $table->index(['reviewer_id', 'review_type']);
            $table->index(['rating', 'is_public']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
