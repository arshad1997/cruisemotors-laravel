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
        Schema::create('documentations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('code')->unique();
            $table->unsignedBigInteger('car_make_id');
            $table->unsignedBigInteger('car_model_id');
            $table->unsignedBigInteger('car_variant_id')->nullable();
            $table->string('vin')->nullable();
            $table->text('comments')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentation_and_certificates');
    }
};
