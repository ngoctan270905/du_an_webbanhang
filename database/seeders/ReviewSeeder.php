<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reviews')->insert([
            [
                'id_nguoi_dung' => 1, // Giả sử có user ID 1 trong bảng customers
                'id_san_pham' => 13,   // Giả sử có product ID 2 trong bảng products
                'noi_dung' => 'Sản phẩm rất tốt, tôi rất hài lòng!',
                'trang_thai' => 1, // Duyệt bình luận
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_nguoi_dung' => 2, // Giả sử có user ID 2 trong bảng customers
                'id_san_pham' => 14,   // Giả sử có product ID 3 trong bảng products
                'noi_dung' => 'Chất lượng chưa đạt mong đợi, cần cải thiện!',
                'trang_thai' => 0, // Chưa duyệt bình luận
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
