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
        Schema::table('orders', function (Blueprint $table) {
            // Thêm cột location
            $table->string('province_code', 20)->nullable()->after('dia_chi_giao_hang');
            $table->string('district_code', 20)->nullable()->after('province_code');
            $table->string('ward_code', 20)->nullable()->after('district_code');


            // Tạo foreign key
            $table->foreign('province_code')->references('code')->on('provinces')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('district_code')->references('code')->on('districts')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('ward_code')->references('code')->on('wards')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Xóa foreign key trước khi drop cột
            $table->dropForeign(['province_code']);
            $table->dropForeign(['district_code']);
            $table->dropForeign(['ward_code']);

            // Xóa cột
            $table->dropColumn(['province_code', 'district_code', 'ward_code']);
        });
    }
};
