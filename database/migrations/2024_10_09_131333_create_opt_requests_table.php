<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('opt_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('otp_code');
            $table->string('message_id')->nullable();
            $table->string('status')->default('pending');
            $table->enum('type', ['sms', 'email'])->default('sms');
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opt_requests');
    }
};
