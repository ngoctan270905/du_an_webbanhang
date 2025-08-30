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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('ho_ten', 255); // Quy định độ dài và ko được phép trùng nhau
            $table->string('email', 255)->unique(); // Quy định độ dài và ko được phép trùng nhau
            $table->string('so_dien_thoai', 20)->nullable(); // Quy định độ dài và ko được phép trùng nhau
            $table->text('dia_chi', 20)->nullable(); // Quy định độ dài và ko được phép trùng nhau
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
