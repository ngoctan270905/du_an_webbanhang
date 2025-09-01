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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_don_hang');
            $table->unsignedBigInteger('id_san_pham');
            $table->unsignedInteger('so_luong');
            $table->decimal('gia', 10, 2);
            $table->timestamps();
            $table->foreign('id_don_hang')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('id_san_pham')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
