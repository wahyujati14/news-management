<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'level' => 'ADMIN',
        ]);
        
        DB::table('users')->insert([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => Hash::make('user'),
            'level' => 'USER',
        ]);

    }
}
