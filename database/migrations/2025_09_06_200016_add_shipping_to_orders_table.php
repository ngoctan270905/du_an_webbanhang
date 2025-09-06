<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('phi_ship', 10, 2)->default(0)->after('ward_code');
            $table->enum('hinh_thuc_van_chuyen', ['standard', 'express'])->default('standard')->after('phi_ship');
            $table->decimal('tong_tien_hang', 10, 2)->default(0)->after('hinh_thuc_van_chuyen');
            $table->boolean('da_nhan_hang')->default(false)->after('tong_tien');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['phi_ship', 'hinh_thuc_van_chuyen', 'tong_tien_hang', 'da_nhan_hang']);
        });
    }
};
