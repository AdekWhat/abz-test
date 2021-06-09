<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     DB::table('users')->insert([
         'name' => 'abz-hr',
         'email' => 'abz-hr@gmail.com',
         'password' => Hash::make('}<~R}/Xva5}NQye'),
     ]);
    }
}
