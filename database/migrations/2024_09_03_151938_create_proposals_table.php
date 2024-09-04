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
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('jobs_table')->onDelete('cascade'); // Foreign key to jobs table
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Assuming proposals are submitted by users
            $table->longText('cover_letter')->nullable(); // Cover letter or main proposal content
            $table->longText('attachment')->nullable(); // Attachment file name
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending'); // Status of the proposal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
