<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use Illuminate\Support\Facades\DB;

class RollbackPropertySeeder extends Seeder
{
    public function run()
    {
        DB::beginTransaction();
        try {
            // Delete properties created by seeder (adjust the IDs as needed)
            Property::whereIn('user_id', range(7, 11))->delete();
            DB::commit();
            $this->command->info('Properties rollback completed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Rollback failed: ' . $e->getMessage());
        }
    }
}