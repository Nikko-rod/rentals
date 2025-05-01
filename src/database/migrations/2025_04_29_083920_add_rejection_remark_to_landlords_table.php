<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('landlords', function (Blueprint $table) {
            $table->enum('rejection_remark', [
                'blurry',
                'corrupt_file',
                'expired_document',
                'invalid_document',
                'incomplete_information'
            ])->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('landlords', function (Blueprint $table) {
            $table->dropColumn('rejection_remark');
        });
    }
};