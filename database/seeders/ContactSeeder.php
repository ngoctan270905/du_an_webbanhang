<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('contacts')->insert([
            [
                'ho_ten' => 'Nguyễn Văn A',
                'so_dien_thoai' => '0987654321',
                'noi_dung' => 'Tôi muốn đặt hàng số lượng lớn.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ho_ten' => 'Trần Thị B',
                'so_dien_thoai' => '0912345678',
                'noi_dung' => 'Tôi cần tư vấn về sản phẩm.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
