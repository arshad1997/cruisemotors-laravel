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
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('car_make_id')->after('product_sub_category_id');
            $table->unsignedBigInteger('car_model_id')->after('car_make_id');
            $table->unsignedBigInteger('car_variant_id')->nullable()->after('car_model_id');
//            $table->foreign('car_make_id')->references('id')->on('car_makes')->cascadeOnUpdate()->cascadeOnDelete();
//            $table->foreign('car_model_id')->references('id')->on('car_models')->cascadeOnUpdate()->cascadeOnDelete();
//            $table->foreign('car_variant_id')->references('id')->on('car_models')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
