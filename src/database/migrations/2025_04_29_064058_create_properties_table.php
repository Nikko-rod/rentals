<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('price', 10, 2);
            $table->string('location');
            $table->enum('type', ['apartment', 'house', 'bedspace']);
            $table->enum('gender_restriction', ['male', 'female', 'any']);
            $table->text('landmarks')->nullable();
            $table->boolean('is_available')->default(true);
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('properties');
    }
};