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
        Schema::create('documentation_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('documentation_id');
            $table->unsignedBigInteger('document_service_id');
            $table->double('cost')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentation_and_certificate_items');
    }
};
