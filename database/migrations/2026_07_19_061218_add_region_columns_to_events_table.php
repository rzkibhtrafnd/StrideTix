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
        Schema::table('events', function (Blueprint $table) {
            $table->string('province_id', 10)->nullable()->after('description');
            $table->string('province_name', 100)->nullable()->after('province_id');
            $table->string('regency_id', 10)->nullable()->after('province_name');
            $table->string('regency_name', 100)->nullable()->after('regency_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'province_id',
                'province_name',
                'regency_id',
                'regency_name'
            ]);
        });
    }
};
