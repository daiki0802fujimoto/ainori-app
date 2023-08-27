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
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'hoge',
            'email' => 'hogehoge@gmail.com',
            'password' => Hash::make('hogehoge'),
            'age' => 25,
            'sex_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('users')->insert([
            'name' => 'piyo',
            'email' => 'piyopiyo@gmail.com',
            'password' => Hash::make('piyopiyo'),
            'age' => 30,
            'sex_id' => 2,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('users')->insert([
            'name' => 'hogepiyo',
            'email' => 'hogepiyo@gmail.com',
            'password' => Hash::make('hogepiyo'),
            'age' => 50,
            'sex_id' => 3,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('users')->insert([
            'name' => 'admin1',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'admin' => true,
            'age' => 23,
            'sex_id' => 1,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
