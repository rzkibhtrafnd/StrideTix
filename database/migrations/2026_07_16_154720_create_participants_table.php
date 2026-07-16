<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            // Terhubung ke item order spesifik tempat tiket ini dibeli
            $table->foreignId('order_item_id')->constrained('order_items')->onDelete('cascade');
            $table->string('full_name');
            $table->enum('gender', ['M', 'F']);
            $table->date('date_of_birth');
            $table->enum('identity_type', ['KTP', 'PASPOR']); // Menyesuaikan enum tipe identitas
            $table->string('identity_number');
            $table->enum('blood_type', ['A', 'B', 'AB', 'O']);
            $table->enum('jersey_size', ['XS', 'S', 'M', 'L', 'XL', 'XXL']);
            $table->string('emergency_contact_name');
            $table->string('emergency_contact_phone');
            $table->string('emergency_relation');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};