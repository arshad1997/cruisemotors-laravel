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
        Schema::create('ports', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('state_id');
            $table->unsignedBigInteger('country_id');
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ports');
    }
};
