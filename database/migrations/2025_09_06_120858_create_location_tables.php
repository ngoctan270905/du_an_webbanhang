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
        Schema::create('provinces', function (Blueprint $table) {
            $table->string('code', 20)->primary();
            $table->string('name');
            $table->string('slug');
            $table->string('type')->nullable();
            $table->string('name_with_type');
            $table->timestamps();
        });

        Schema::create('districts', function (Blueprint $table) {
            $table->string('code', 20)->primary();
            $table->string('name');
            $table->string('type')->nullable();
            $table->string('name_with_type');
            $table->string('path_with_type')->nullable();
            $table->string('parent_code');
            $table->foreign('parent_code')->references('code')->on('provinces')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('wards', function (Blueprint $table) {
            $table->string('code', 20)->primary();
            $table->string('name');
            $table->string('type')->nullable();
            $table->string('name_with_type');
            $table->string('path_with_type')->nullable();
            $table->string('parent_code');
            $table->foreign('parent_code')->references('code')->on('districts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wards');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('provinces');
    }
};
