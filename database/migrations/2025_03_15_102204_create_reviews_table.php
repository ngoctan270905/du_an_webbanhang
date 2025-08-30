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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_nguoi_dung'); // Tạo cột kiểu unsignedBigInteger
            $table->unsignedBigInteger('id_san_pham');   // Tạo cột kiểu unsignedBigInteger
            $table->text('noi_dung')->nullable();
            $table->tinyInteger('trang_thai')->default(true);
            $table->timestamps();

            // Tạo khóa ngoại thủ công
            $table->foreign('id_nguoi_dung')->references('id')->on('customers');
            $table->foreign('id_san_pham')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['id_nguoi_dung']); // Xóa khóa ngoại 
            $table->dropForeign(['id_san_pham']); // Xóa khóa ngoại products
        });

        Schema::dropIfExists('reviews'); // Xóa bảng reviews
    }
};
