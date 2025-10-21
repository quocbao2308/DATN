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
        Schema::create('thong_bao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tai_khoan_id')->constrained('tai_khoan')->onDelete('cascade');
            $table->string('tieu_de');
            $table->text('noi_dung');
            $table->string('loai')->nullable(); // 'diem', 'lich_hoc', 'hoc_phi', 'dang_ky', 'he_thong'
            $table->string('lien_ket')->nullable(); // URL để chuyển đến
            $table->boolean('da_doc')->default(false);
            $table->timestamps();

            // Indexes
            $table->index(['tai_khoan_id', 'da_doc']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thong_bao');
    }
};
// Ghí chsu quản lý đểm 