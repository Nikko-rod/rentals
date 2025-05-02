<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inquiry_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inquiry_id')->constrained()->onDelete('cascade');
            $table->text('message');
            $table->boolean('is_landlord')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
          
            $table->index(['inquiry_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('inquiry_messages');
    }
};