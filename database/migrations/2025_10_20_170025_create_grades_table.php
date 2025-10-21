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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();

            // Tham chiếu sinh viên (bảng sinh_vien)
            $table->foreignId('student_id')
                ->constrained('sinh_vien')
                ->onDelete('cascade');

            // Tham chiếu môn học (bảng mon_hoc)
            $table->foreignId('course_id')
                ->constrained('mon_hoc')
                ->onDelete('cascade');

            $table->decimal('diem_qua_trinh', 5, 2)->nullable();
            $table->decimal('diem_cuoi_ky', 5, 2)->nullable();
            $table->decimal('diem_tong_ket', 5, 2)->nullable();
            $table->timestamps();

            // Tránh trùng lặp điểm của 1 sinh viên cho 1 môn
            $table->unique(['student_id', 'course_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
// Ghí chsu quản lý đểm 