<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobSeeder extends Seeder
{
    public function run()
    {
        DB::table('jobs')->insert([
            ['job_name' => 'Software Engineer', 'machine_id' => 1, 'created_at' => now()],
            ['job_name' => 'Product Manager', 'machine_id' => 2, 'created_at' => now()],
        ]);
    }
}
