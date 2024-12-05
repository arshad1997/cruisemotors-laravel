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
        Schema::create('checkout_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checkout_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity')->default(1);
            $table->string('price');
            $table->string('total');
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkout_items');
    }
};
