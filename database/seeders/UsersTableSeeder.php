<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminExists = DB::table('users')->where('user_name', 'admin')->exists();

        if (!$adminExists) {
        DB::table('users')->insert([
            'user_type' => 'admin',
            'user_name' => 'admin',
            'password' => Hash::make('password123'),
            'active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
         ]);
        }
    }
}
