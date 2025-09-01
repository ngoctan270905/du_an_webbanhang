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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('ma_giam_gia', 50)->unique();
            $table->text('mo_ta')->nullable();
            $table->enum('loai_giam_gia', ['percent', 'amount']); // % hay số tiền
            $table->decimal('gia_tri', 10, 2); // giá trị giảm
            $table->date('ngay_bat_dau');
            $table->date('ngay_ket_thuc');
            $table->boolean('trang_thai')->default(1); // 1 = active, 0 = inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
