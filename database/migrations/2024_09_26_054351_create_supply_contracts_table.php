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
        Schema::create('supply_contracts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('company_name')->nullable();
            $table->string('person_name')->nullable();
            $table->string('person_email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('person_designation')->nullable();
            $table->string('company_address')->nullable();
            $table->string('comments')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supply_contracts');
    }
};
