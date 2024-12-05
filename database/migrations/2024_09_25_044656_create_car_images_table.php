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
        Schema::create('car_images', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->foreignId('car_id')->constrained();
            $table->foreignId('image_id')->constrained('uploads');
            $table->boolean('is_thumbnail')->default(false);
            $table->boolean('is_thumbnail_interior')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_images');
    }
};
