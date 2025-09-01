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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('ma_don_hang', 20)->unique();
            $table->unsignedBigInteger('id_nguoi_dung');
            $table->decimal('tong_tien', 10, 2);
            $table->enum('trang_thai', ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending');
            $table->text('dia_chi_giao_hang');
            $table->enum('phuong_thuc_thanh_toan', ['cod', 'bank_transfer', 'online_payment']);
            $table->timestamp('ngay_dat_hang')->useCurrent();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id_nguoi_dung')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
