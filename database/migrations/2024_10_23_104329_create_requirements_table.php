<?php
// database/migrations/xxxx_xx_xx_create_requirements_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequirementsTable extends Migration
{
    public function up()
    {
        Schema::create('requirements', function (Blueprint $table) {
            $table->id();
            $table->text('requirements'); // To store the user requirements
            $table->string('file_path')->nullable(); // To store the file path
            $table->foreignId('buyer_checkout_id')->constrained('buyer_checkout')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('requirements');
    }
}
