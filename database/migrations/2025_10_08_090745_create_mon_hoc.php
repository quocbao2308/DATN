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
        Schema::create('mon_hoc', function (Blueprint $table) {
            $table->id();
            $table->string('ma_mon')->unique();
            $table->string('ten_mon');
            $table->unsignedTinyInteger('so_tin_chi');
            $table->text('mo_ta')->nullable();
            $table->string('loai_mon')->nullable();
            $table->enum('hinh_thuc_day', ['offline', 'online', 'hybrid']);
            $table->unsignedSmallInteger('thoi_luong')->nullable();
            $table->unsignedTinyInteger('so_buoi')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mon_hoc');
    }
};
