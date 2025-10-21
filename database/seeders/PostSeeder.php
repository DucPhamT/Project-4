<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("posts")->insert([
            'title' => 'title for post 2',
            'content' => 'content for post 2',
            'thumbnail' => 'thumbnail for post 2',
            'user_id' => '2',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
