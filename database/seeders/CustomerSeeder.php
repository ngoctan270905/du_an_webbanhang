<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('customers')->insert([
            [
                'ho_ten' => 'Nguyễn Văn A',
                'email' => 'nguyenvana@example.com',
                'so_dien_thoai' => '0987654321',
                'dia_chi' => 'Hà Nội, Việt Nam',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ho_ten' => 'Trần Thị B',
                'email' => 'tranthib@example.com',
                'so_dien_thoai' => '0912345678',
                'dia_chi' => 'TP. Hồ Chí Minh, Việt Nam',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ho_ten' => 'Lê Văn C',
                'email' => 'levanc@example.com',
                'so_dien_thoai' => '0905123456',
                'dia_chi' => 'Đà Nẵng, Việt Nam',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
