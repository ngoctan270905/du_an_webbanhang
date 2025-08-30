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
        Schema::table('reviews', function (Blueprint $table) {
            // Xóa khóa ngoại cũ
            $table->dropForeign(['id_nguoi_dung']);

            // Tạo khóa ngoại mới trỏ đến bảng users
            $table->foreign('id_nguoi_dung')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Xóa khóa ngoại mới
            $table->dropForeign(['id_nguoi_dung']);

            // Khôi phục lại khóa ngoại cũ (customers)
            $table->foreign('id_nguoi_dung')->references('id')->on('customers');
        });
    }
};
