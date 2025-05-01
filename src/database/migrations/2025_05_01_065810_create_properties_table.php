<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title', 100);
            $table->text('description');
            $table->string('contact_number', 11);
            $table->enum('available_for', ['male', 'female', 'couples', 'any']);
            $table->enum('type', ['bedspace', 'house', 'room', 'apartment']);
            $table->string('address');
            $table->decimal('monthly_rent', 10, 2);
            $table->timestamps();
        });

        Schema::create('property_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_images');
        Schema::dropIfExists('properties');
    }
};