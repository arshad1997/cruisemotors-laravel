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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('state_id')->nullable();
            $table->string('state_code')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->char('country_code', 2);
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->tinyInteger('flag')->default(1);
            $table->string('wikiDataId')->nullable()->comment('Rapid API GeoDB Cities');

            // Foreign key constraints if needed
//            $table->foreign('state_id')->references('id')->on('states');
//            $table->foreign('country_id')->references('id')->on('countries');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
