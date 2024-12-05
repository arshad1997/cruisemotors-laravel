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
        Schema::create('offer_vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('client_name');
            $table->string('client_phone');
            $table->string('designation')->nullable();
            $table->string('location');
            $table->string('company_name');
            $table->string('interior_color')->nullable();
            $table->string('exterior_color')->nullable();
            $table->string('production_date_time')->nullable();
            $table->string('engin_size')->nullable();
            $table->enum('fuel_type', ['Petrol', 'Diesel', 'Electric', 'Hybrid'])->nullable();
            $table->enum('steering', ['LHD', 'RHD'])->nullable();
            $table->double('asking_price')->nullable()->default(0);
            $table->string('preferred_sale_method')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_vehicles');
    }
};
