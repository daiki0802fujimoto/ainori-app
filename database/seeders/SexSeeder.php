<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class SexSeeder extends Seeder
{
    public function run()
    {
        DB::table('sexes')->insert([
            'sex' => '男性',
        ]);
        DB::table('sexes')->insert([
            'sex' => '女性',
        ]);
        DB::table('sexes')->insert([
            'sex' => '無回答',
        ]);
    }
}
