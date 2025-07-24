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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->integer('user_id');
            $table->integer('amount');
            $table->string('payment_type'); // bank_transfer, qris, gopay, etc.
            $table->string('bank')->nullable(); // bca, bni, etc.
            $table->string('status')->default('pending'); // pending, success, failed
            $table->text('snap_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
