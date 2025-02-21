<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupportStrategySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('support_strategy')->insert([
            ['support_strategy' => 'Maximize %AF Usage tp 80% by heat', 'created_at' => now()],
            ['support_strategy' => 'Waste Circularity Center', 'created_at' => now()],
            ['support_strategy' => 'Turn Clinker to Cement & Motar', 'created_at' => now()],
            ['support_strategy' => 'Maximize Renewable Power', 'created_at' => now()],
            ['support_strategy' => 'New Business: Fertilizer', 'created_at' => now()],
            ['support_strategy' => 'Other', 'created_at' => now()]
        ]);
    }
}
