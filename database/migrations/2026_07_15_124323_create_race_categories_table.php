<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('race_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->string('category_name');
            $table->string('distance_km');
            $table->integer('total_slot');
            $table->integer('available_slot');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('race_categories');
    }
};