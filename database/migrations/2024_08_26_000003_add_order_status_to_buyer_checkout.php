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
            // Add foreign key for order status
            $table->foreignId('order_status_id')->nullable()->after('status')->constrained('order_statuses')->onDelete('set null');
            
            // Keep the old status column for backward compatibility during transition
            // We can remove it later once migration is complete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buyer_checkout', function (Blueprint $table) {
            $table->dropForeign(['order_status_id']);
            $table->dropColumn('order_status_id');
        });
    }
};
