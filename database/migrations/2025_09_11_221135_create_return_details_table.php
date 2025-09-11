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
        Schema::create('return_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('return_id');
            $table->unsignedBigInteger('order_detail_id'); // Tham chiếu đến order_details
            $table->unsignedInteger('so_luong');
            $table->decimal('gia_tra', 10, 2);
            $table->text('ly_do_chi_tiet')->nullable();
            $table->timestamps();

            // Ràng buộc khóa ngoại
            $table->foreign('return_id')
                ->references('id')->on('returns')
                ->onDelete('cascade');

            $table->foreign('order_detail_id')
                ->references('id')->on('order_details')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_details');
    }
};
