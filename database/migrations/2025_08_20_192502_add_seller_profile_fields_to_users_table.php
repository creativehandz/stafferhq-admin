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
        Schema::table('users', function (Blueprint $table) {
            // Basic seller profile information
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->date('founded_date')->nullable();
            $table->string('company_size')->nullable();
            $table->json('categories')->nullable();
            $table->string('intro_video_url')->nullable();
            $table->string('profile_url')->nullable();
            $table->text('about_company')->nullable();
            $table->json('profile_photos')->nullable();
            $table->json('social_links')->nullable();
            $table->string('location')->nullable();
            $table->string('friendly_address')->nullable();
            $table->string('map_location')->nullable();
            $table->string('profile_image')->nullable();
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('total_reviews')->default(0);
            $table->integer('total_orders')->default(0);
            $table->boolean('is_verified')->default(false);
            $table->timestamp('last_seen')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'website',
                'founded_date',
                'company_size',
                'categories',
                'intro_video_url',
                'profile_url',
                'about_company',
                'profile_photos',
                'social_links',
                'location',
                'friendly_address',
                'map_location',
                'profile_image',
                'rating',
                'total_reviews',
                'total_orders',
                'is_verified',
                'last_seen'
            ]);
        });
    }
};
