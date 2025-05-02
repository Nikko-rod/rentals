<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    $inquiries = DB::table('inquiries')->get();
    
    foreach ($inquiries as $inquiry) {
        // Migrate initial message
        if ($inquiry->message) {
            DB::table('inquiry_messages')->insert([
                'inquiry_id' => $inquiry->id,
                'message' => $inquiry->message,
                'is_landlord' => false,
                'created_at' => $inquiry->created_at,
                'updated_at' => $inquiry->created_at
            ]);
        }
        
        // Migrate landlord response
        if ($inquiry->landlord_response) {
            DB::table('inquiry_messages')->insert([
                'inquiry_id' => $inquiry->id,
                'message' => $inquiry->landlord_response,
                'is_landlord' => true,
                'created_at' => $inquiry->responded_at,
                'updated_at' => $inquiry->responded_at
            ]);
        }
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
