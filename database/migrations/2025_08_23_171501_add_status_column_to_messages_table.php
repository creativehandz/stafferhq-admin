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
        Schema::table('messages', function (Blueprint $table) {
            $table->enum('status', ['unread', 'read'])->default('unread')->after('message');
            $table->timestamp('read_at')->nullable()->after('status');
            $table->index('status'); // Add index for better query performance
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropColumn(['status', 'read_at']);
        });
    }
};
