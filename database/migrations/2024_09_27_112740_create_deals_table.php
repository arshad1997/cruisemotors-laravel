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
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('agent_name');
            $table->string('agent_phone');
            $table->string('client_name');
            $table->string('client_phone');
            $table->string('client_address');
            $table->unsignedBigInteger('car_make_id');
            $table->unsignedBigInteger('car_model_id');
            $table->string('year');
            $table->string('color');
            $table->string('quantity')->default(0);
            $table->string('destination');
            $table->string('agent_targeted_amount');
            $table->string('agent_commission_amount');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
