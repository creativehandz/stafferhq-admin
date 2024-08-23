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
        Schema::create('jobs_table', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->index();
            $table->string('title');
            $table->string('project_type');
            $table->string('category');
            $table->json('skills');
            $table->string('experience_level');
            $table->string('budget_type');
            $table->integer('budget');
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->longText('attachment')->nullable();
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs_table');
    }
};
