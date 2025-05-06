<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('landlord_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('property_id')->constrained('properties')->onDelete('cascade');
            
    
            $table->decimal('quoted_monthly_rent', 10, 2);
            $table->string('quoted_type');
            $table->string('quoted_contact_number');
    
            $table->text('message');
            $table->text('landlord_response')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            $table->index(['property_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('inquiries');
    }
};