<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sinh_vien_lop_hoc_phan', function (Blueprint $table) {
            $table->id();

            // Khóa ngoại
            $table->foreignId('sinh_vien_id')->constrained('sinh_vien')->onDelete('cascade');
            $table->foreignId('lop_hoc_phan_id')->constrained('lop_hoc_phan')->onDelete('cascade');

            // Các thông tin học tập
            $table->float('diem_giua_ky')->nullable();
            $table->float('diem_cuoi_ky')->nullable();
            $table->float('diem_tong_ket')->nullable();

            // Trạng thái học phần
            $table->enum('trang_thai', ['dang_hoc', 'hoan_thanh', 'huy'])->default('dang_hoc');

            // Ngày đăng ký
            $table->timestamp('ngay_dang_ky')->useCurrent();

            // Ràng buộc: 1 sinh viên chỉ được học 1 lớp học phần 1 lần
            $table->unique(['sinh_vien_id', 'lop_hoc_phan_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sinh_vien_lop_hoc_phan');
    }
};
