<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('banners')->insert([
            [
                'tieu_de' => 'Khuyến mãi mùa hè',
                'hinh_anh' => 'banner1.jpg',
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tieu_de' => 'Giảm giá cuối năm',
                'hinh_anh' => 'banner2.jpg',
                'trang_thai' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tieu_de' => 'Mua 1 tặng 1',
                'hinh_anh' => 'banner3.jpg',
                'trang_thai' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
