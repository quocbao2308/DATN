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
            $table->string('tieu_de'); // Tiêu đề thông báo
            $table->text('noi_dung'); // Nội dung thông báo
            $table->string('loai')->default('info'); // info, success, warning, danger
            $table->string('url')->nullable(); // Link để click vào thông báo
            $table->foreignId('nguoi_tao_id')->nullable()->constrained('users')->nullOnDelete(); // Admin tạo thông báo
            $table->boolean('is_global')->default(false); // Gửi cho tất cả hay không
            $table->timestamps();
        });

        // Bảng trung gian: Thông báo - User (Many-to-Many)
        Schema::create('thong_bao_nguoi_dung', function (Blueprint $table) {
            $table->id();
            $table->foreignId('thong_bao_id')->constrained('thong_bao')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->boolean('da_doc')->default(false); // Đã đọc chưa
            $table->timestamp('thoi_gian_doc')->nullable(); // Thời gian đọc
            $table->timestamps();

            $table->unique(['thong_bao_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thong_bao_nguoi_dung');
        Schema::dropIfExists('thong_bao');
    }
};
