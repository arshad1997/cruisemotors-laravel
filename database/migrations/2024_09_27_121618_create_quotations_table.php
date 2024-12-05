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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('departure_country_id');
            $table->unsignedBigInteger('departure_state_id');
            $table->unsignedBigInteger('departure_city_id')->nullable();
            $table->unsignedBigInteger('departure_port_id')->nullable();
            $table->unsignedBigInteger('pickup_country_id');
            $table->unsignedBigInteger('pickup_state_id');
            $table->unsignedBigInteger('pickup_city_id')->nullable();
            $table->unsignedBigInteger('pickup_port_id')->nullable();
            $table->enum('transportation_type', ['air', 'sea', 'land']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
