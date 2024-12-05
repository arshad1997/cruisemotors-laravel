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
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->char('country_code', 2)->nullable();
            $table->string('fips_code')->nullable();
            $table->string('iso2')->nullable();
            $table->string('type', 191)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->tinyInteger('flag')->default(1);
            $table->string('wikiDataId')->nullable()->comment('Rapid API GeoDB Cities');

            // Foreign key constraints if needed
//            $table->foreign('country_id')->references('id')->on('countries');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};
