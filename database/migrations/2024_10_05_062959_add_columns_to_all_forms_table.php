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
        Schema::table('tenders', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
        });

        Schema::table('supply_contracts', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
        });

        Schema::table('deals', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
        });

        Schema::table('vehicle_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
        });

        Schema::table('inquiries', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
        });

        Schema::table('offer_vehicles', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('all_forms', function (Blueprint $table) {
            //
        });
    }
};
