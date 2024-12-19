<?php

namespace Database\Seeders;

use App\Models\Post;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class PostSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //create fake posts from factory
        Post::factory(15)->create();

        //create manually posts
        // DB::table('posts')->insert([
        //     'user_id' => 1,
        //     'title' => 'post1',
        //     'body' => 'admin@outlook.com',
        // ]);
        // DB::table('posts')->insert([
        //     'user_id' => 1,
        //     'title' => 'post2',
        //     'body' => 'admin2@outlook.com',
        // ]);
        // DB::table('posts')->insert([
        //     'user_id' => 1,
        //     'title' => 'post3',
        //     'body' => 'admin3@outlook.com',
        // ]);
    }
}
