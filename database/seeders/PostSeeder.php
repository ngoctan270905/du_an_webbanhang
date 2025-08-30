<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('posts')->insert([
            [
                'tieu_de' => 'Giới thiệu sản phẩm mới',
                'noi_dung' => 'Chúng tôi ra mắt sản phẩm mới với nhiều ưu đãi hấp dẫn!',
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tieu_de' => 'Cách bảo dưỡng xe điện',
                'noi_dung' => 'Hướng dẫn chi tiết cách bảo dưỡng xe điện đúng cách.',
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
