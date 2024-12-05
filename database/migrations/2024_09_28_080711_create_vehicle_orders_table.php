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
        Schema::create('vehicle_orders', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('client_name');
            $table->string('client_phone');
            $table->string('designation')->nullable();
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('port_id')->nullable();
            $table->string('company_name');
            $table->string('interior_color')->nullable();
            $table->string('exterior_color')->nullable();
            $table->string('product_date_time')->nullable();
            $table->string('engin_size')->nullable();
            $table->enum('fuel_type', ['Petrol', 'Diesel', 'Electric', 'Hybrid'])->nullable();
            $table->enum('steering', ['LHD', 'RHD'])->nullable();
            $table->string('delivery_date_time')->nullable();
            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_orders');
    }
};
