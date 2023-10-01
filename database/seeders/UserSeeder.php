<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use DateTime;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'daiki0802fujimoto@gmail.com',
            'password' => Hash::make('admin'),
            'admin' => true,
            'age' => 23,
            'sex_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
