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
        // Mặc định trong 1 file migration bắt buộc phải có đủ hàm up và hàm down
        // Hàm UP dùng để cập nhật cơ sở dữ liệu
        // Hàm DOWN làm những công việc ngược lại so với hàm up
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('ma_san_pham', 20)->unique(); // Quy định độ dài và ko được phép trùng nhau
            $table->string('ten_san_pham');
            $table->decimal('gia', 10, 2);
            $table->decimal('gia_khuyen_mai', 10, 2)->nullable(); // Cho phép chứa giá trị null
            $table->unsignedInteger('so_luong'); // Số nguyên dương
            $table->date('ngay_nhap');
            $table->text('mo_ta')->nullable();
            $table->boolean('trang_thai')->default(true); // Set giá trị mặc định
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
