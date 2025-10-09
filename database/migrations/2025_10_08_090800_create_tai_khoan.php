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
        Schema::create('tai_khoan', function (Blueprint $table) {
            $table->id();
            $table->string('ten_dang_nhap')->unique();
            $table->string('mat_khau');
            $table->foreignId('sinh_vien_id')->nullable()->constrained('sinh_vien');
            $table->foreignId('giang_vien_id')->nullable()->constrained('giang_vien');
            $table->foreignId('dao_tao_id')->nullable()->constrained('dao_tao');
            $table->foreignId('admin_id')->nullable()->constrained('admin');
            $table->dateTime('last_login')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tai_khoan');
    }
};
