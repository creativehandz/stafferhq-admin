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
        Schema::create('resumes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->index();
            $table->string('name');
            $table->string('occupation')->nullable();
            $table->text('about')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->json('social_links')->nullable();
            $table->integer('age')->nullable();
            $table->string('citizen')->nullable();
            $table->text('address')->nullable();
            $table->string('favorate_quote')->nullable();
            $table->string('expertise')->nullable();
            $table->json('what_i_do')->nullable();
            $table->json('skills')->nullable();
            $table->json('educations')->nullable();
            $table->json('experiences')->nullable();
            $table->json('projects')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};
