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
         Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_don_hang');
            $table->enum('phuong_thuc_thanh_toan', ['cod', 'bank_transfer', 'online_payment']);
            $table->decimal('so_tien', 10, 2);
            $table->enum('trang_thai', ['pending', 'completed', 'failed'])->default('pending');
            $table->string('ma_giao_dich', 255)->nullable();
            $table->timestamps();
            $table->foreign('id_don_hang')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
