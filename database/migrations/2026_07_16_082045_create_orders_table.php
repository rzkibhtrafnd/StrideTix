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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('invoice_number')->unique();
            $table->string('midtrans_transaction_id')->nullable()->unique();
            $table->string('midtrans_snap_token')->nullable();
            $table->string('midtrans_redirect_url')->nullable();
            $table->decimal('total_original_price', 15, 2);
            $table->decimal('gross_amount', 15, 2);
            $table->enum('payment_status', ['pending', 'settlement', 'capture', 'deny', 'expire', 'cancel', 'refund'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('va_number')->nullable();
            $table->string('payment_provider_channel')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
