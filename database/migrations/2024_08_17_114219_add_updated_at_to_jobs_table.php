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
        Schema::table('jobs_table', function (Blueprint $table) {
            // Adds the updated_at column
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs_table', function (Blueprint $table) {
            // Drops the updated_at column if the migration is rolled back
            $table->dropColumn('updated_at');
        });
    }
};
