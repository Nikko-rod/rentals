
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
    
            $table->dropColumn(['name', 'is_approved']);
            
            $table->string('first_name')->after('id');
            $table->string('last_name')->after('first_name');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->boolean('is_approved')->default(false)->after('remember_token');
            
            $table->dropColumn(['first_name', 'last_name']);
        });
    }
};