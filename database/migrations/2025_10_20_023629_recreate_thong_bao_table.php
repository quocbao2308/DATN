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
        // Drop bảng cũ nếu tồn tại
        Schema::dropIfExists('thong_bao_nguoi_dung');
        Schema::dropIfExists('thong_bao');

        // Tạo lại bảng mới với cấu trúc đúng
        Schema::create('thong_bao', function (Blueprint $table) {
            $table->id();

            // Người nhận và người tạo
            $table->foreignId('nguoi_nhan_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('nguoi_tao_id')->nullable()->constrained('users')->nullOnDelete();

            // Nội dung thông báo
            $table->string('tieu_de');
            $table->text('noi_dung');

            // Loại thông báo: thong_tin, canh_bao, quan_trong
            $table->string('loai')->default('thong_tin');

            // Đối tượng nhận: all, admin, dao_tao, giang_vien, sinh_vien, specific
            $table->string('vai_tro_nhan')->nullable();

            // Liên kết (tùy chọn)
            $table->string('lien_ket')->nullable();

            // Trạng thái đọc
            $table->boolean('da_doc')->default(false);

            $table->timestamps();

            // Indexes để tăng tốc query
            $table->index('nguoi_nhan_id');
            $table->index('nguoi_tao_id');
            $table->index('vai_tro_nhan');
            $table->index('da_doc');
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
