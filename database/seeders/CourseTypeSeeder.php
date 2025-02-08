<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('course_types')->insert([
            ['course_name' => 'Online'],
            ['course_name' => 'Offline'],
            ['course_name' => 'Hybrid'],
            // Add more as needed
        ]);
    }
}
