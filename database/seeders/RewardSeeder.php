<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RewardSeeder extends Seeder
{
    public function run()
    {
        DB::table('rewards')->insert([
            ['reward_name' => 'Gift Card', 'reward_image' => 'gift_card.png', 'reward_point' => 100, 'reward_left' => 10],
            ['reward_name' => 'Wireless Earbuds', 'reward_image' => 'earbuds.png', 'reward_point' => 500, 'reward_left' => 5],
            ['reward_name' => 'Smart Watch', 'reward_image' => 'smart_watch.png', 'reward_point' => 1000, 'reward_left' => 3],
            ['reward_name' => 'Office Chair', 'reward_image' => 'office_chair.png', 'reward_point' => 2000, 'reward_left' => 2],
            ['reward_name' => 'Laptop', 'reward_image' => 'laptop.png', 'reward_point' => 5000, 'reward_left' => 1],
            ['reward_name' => 'Vacation Package', 'reward_image' => 'vacation.png', 'reward_point' => 10000, 'reward_left' => 1],
        ]);
    }
}
