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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('vin')->nullable();
            $table->string('engine_number')->nullable();
            $table->unsignedBigInteger('car_make_id');
            $table->unsignedBigInteger('car_model_id');
            $table->unsignedBigInteger('car_variant_id')->nullable();
            $table->unsignedBigInteger('car_body_type_id')->nullable();
            $table->unsignedBigInteger('car_category_id')->nullable();
            $table->enum('transmission', ['Manual', 'Automatic'])->nullable();
            $table->text('variant_details')->nullable();
            $table->enum('steering_type', ['LHD', 'RHD'])->nullable();
            $table->enum('fuel_type', ['Petrol', 'Diesel', 'Electric'])->nullable()->comment('petrol, diesel, electric');
            $table->string('fuel_tank_capacity')->nullable();
            $table->string('ext_color')->nullable();
            $table->string('int_color')->nullable();
            $table->string('production_year')->nullable();
            $table->double('mileage')->nullable()->comment('how many kilometers run');
            $table->double('average_on_road')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('cars', function (Blueprint $table) {
            $table->foreign('car_make_id')->references('id')->on('car_makes')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('car_model_id')->references('id')->on('car_models')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('car_variant_id')->references('id')->on('car_variants')->cascadeOnUpdate()->cascadeOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
