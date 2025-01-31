<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends Seeder
{
    public function run()
    {
        DB::table('teams')->insert([
            ['team_name' => 'Development', 'created_at' => now()],
            ['team_name' => 'Marketing', 'created_at' => now()],
            ['team_name' => 'HR', 'created_at' => now()],
        ]);
    }
}
