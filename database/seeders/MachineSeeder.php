<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MachineSeeder extends Seeder
{
    public function run()
    {
        DB::table('machines')->insert([
            ['machine_name' => 'Machine 1', 'created_at' => now()],
            ['machine_name' => 'Machine 2', 'created_at' => now()],
        ]);
    }
}
