<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\Gender;
use App\Enums\IdentityType;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_item_id')->constrained('order_items')->onDelete('cascade');
            $table->string('full_name');
            $table->tinyInteger('gender')->default(Gender::MALE->value);
            $table->date('date_of_birth');
            $table->tinyInteger('identity_type')->default(IdentityType::KTP->value);
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