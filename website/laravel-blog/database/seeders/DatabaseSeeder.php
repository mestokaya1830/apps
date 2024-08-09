<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //create fake users from factory
        // User::factory(10)->create();

        //create manually users
        // DB::table('users')->insert([
        //     'name' => 'admin',
        //     'email' => 'admin@outlook.com',
        //     'password' => Hash::make('9090'),
        // ]);
        // DB::table('users')->insert([
        //     'name' => 'admin2',
        //     'email' => 'admin2@outlook.com',
        //     'password' => Hash::make('9090'),
        // ]);
        // DB::table('users')->insert([
        //     'name' => 'admin3',
        //     'email' => 'admin3@outlook.com',
        //     'password' => Hash::make('9090'),
        // ]);
    }
}
