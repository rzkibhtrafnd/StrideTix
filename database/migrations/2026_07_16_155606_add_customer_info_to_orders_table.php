<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Tambahkan kolom data diri pembeli (Guest)
            $table->string('customer_name')->after('user_id')->nullable();
            $table->string('customer_email')->after('customer_name')->nullable();
            $table->string('customer_phone')->after('customer_email')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['customer_name', 'customer_email', 'customer_phone']);
        });
    }
};