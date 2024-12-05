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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->unsignedBigInteger('thumbnail')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedBigInteger('product_category_id');
            $table->unsignedBigInteger('product_sub_category_id')->nullable();
            $table->string('sku')->nullable();
            $table->text('short_description')->nullable();
            $table->text('long_description')->nullable();
            $table->double('price')->default(0);
            $table->double('discount')->default(0);
            $table->integer('opening_stock')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreign('product_category_id')->references('id')->on('product_categories')->onDelete('cascade');
            $table->foreign('product_sub_category_id')->references('id')->on('product_sub_categories')->onDelete('cascade');
//            $table->foreign('thumbnail')->references('id')->on('uploads')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
