<?php

namespace Database\Seeders;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('comments')->insert([
            'created_at' => now(),
            'updated_at' => now(),
            'user_id' => '1',
            'content' => 'cmt_content for user 1',
            'post_id' => '1',
        ]);
    }
}
