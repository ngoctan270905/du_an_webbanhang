<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('returns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ma_tra_hang', 20)->unique();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('ngay_yeu_cau')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->text('ly_do_tra_hang');
            $table->enum('trang_thai', ['pending', 'approved', 'rejected', 'completed', 'cancelled'])->default('pending');
            $table->text('ghi_chu_admin')->nullable();
            $table->decimal('tong_tien_hoan', 10, 2)->nullable();
            $table->enum('phuong_thuc_hoan_tien', ['cod', 'bank_transfer', 'online_payment'])->nullable();
            $table->timestamp('ngay_hoan_tien')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Ràng buộc khóa ngoại
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};
