<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'azure_ad_object_id' => 'A12345',
                'employee_id' => 1, // John Doe
                'username' => 'john.doe',
                'role_id' => 1, // Admin role
                'status' => 'active',
                'created_at' => now(),
            ],
            [
                'azure_ad_object_id' => 'B12345',
                'employee_id' => 2, // Jane Smith
                'username' => 'jane.smith',
                'role_id' => 2, // User role
                'status' => 'inactive',
                'created_at' => now(),
            ],
        ]);
    }
}
