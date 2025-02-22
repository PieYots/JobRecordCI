<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            TeamSeeder::class,
            EmployeeSeeder::class,
            UsersSeeder::class,
            MachineSeeder::class,
            JobSeeder::class,
            ETrainingSeeder::class,
            CourseTypeSeeder::class,
            WorkTypeSeeder::class,
            ScoreCriteriaSeeder::class,
            RewardSeeder::class,
            SupportStrategySeeder::class
        ]);
    }
}
