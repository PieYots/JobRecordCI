<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        DB::table('employees')->insert([
            [
                'employee_name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'department' => 'Development',
                'team_id' => 1, // Development team
                'created_at' => now(),
            ],
            [
                'employee_name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'department' => 'Marketing',
                'team_id' => 2, // Marketing team
                'created_at' => now(),
            ],
        ]);
    }
}
