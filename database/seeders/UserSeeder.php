<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
            'password' => 'hogehoge',
            'age' => 25,
            'sex' => true,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('users')->insert([
            'name' => 'piyo',
            'email' => 'piyopiyo@gmail.com',
            'password' => 'piyopiyo',
            'age' => 30,
            'sex' => false,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('users')->insert([
            'name' => 'hogepiyo',
            'email' => 'hogepiyo@gmail.com',
            'password' => 'hogepiyo',
            'age' => 50,
            'sex' => true,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
