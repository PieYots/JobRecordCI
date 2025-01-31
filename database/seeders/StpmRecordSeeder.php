<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StpmRecordSeeder extends Seeder
{
    public function run()
    {
        DB::table('stpm_records')->insert([
            [
                'team_id' => 1,
                'is_team' => true,
                'machine_id' => 1,
                'job_id' => 1,
                'file_ref' => 'file_001.pdf',
                'is_finish' => true,
                'e_training_id' => 1,
                'create_at' => now(),
                'record_by' => 1, // John Doe
            ],
        ]);
    }
}
