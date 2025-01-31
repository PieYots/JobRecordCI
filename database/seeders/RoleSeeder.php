<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->insert([
            ['role_name' => 'Admin', 'status' => 'active', 'created_at' => now()],
            ['role_name' => 'User', 'status' => 'active', 'created_at' => now()],
            ['role_name' => 'Manager', 'status' => 'inactive', 'created_at' => now()],
        ]);
    }
}
