<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Công nghệ',
                'description' => 'Các bài viết liên quan đến công nghệ, phần mềm, lập trình và xu hướng kỹ thuật số.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Đời sống',
                'description' => 'Chia sẻ về cuộc sống, sức khỏe, du lịch và trải nghiệm hàng ngày.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kinh doanh',
                'description' => 'Tin tức và phân tích về thị trường, tài chính, khởi nghiệp và quản lý doanh nghiệp.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
