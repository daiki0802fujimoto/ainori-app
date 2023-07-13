<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            'user_id' => 2,
            'origin' => '東京駅',
            'destination' => '大阪駅',
            'people' => 4,
            'time_zone' => new DateTime("@1662288858"),
            'comment' => '相乗り募集してます！',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
