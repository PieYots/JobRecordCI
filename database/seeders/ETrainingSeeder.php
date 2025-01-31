<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ETrainingSeeder extends Seeder
{
    public function run()
    {
        DB::table('e_trainings')->insert([
            ['e_training_name' => 'JavaScript Basics', 'created_at' => now()],
            ['e_training_name' => 'PHP Advanced', 'created_at' => now()],
        ]);
    }
}
