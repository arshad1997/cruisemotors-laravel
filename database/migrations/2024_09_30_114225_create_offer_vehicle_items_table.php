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
        Schema::create('offer_vehicle_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_vehicle_id')->constrained();
            $table->unsignedBigInteger('car_make_id');
            $table->unsignedBigInteger('car_model_id');
            $table->string('year');
            $table->integer('quantity')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_vehicle_items');
    }
};
