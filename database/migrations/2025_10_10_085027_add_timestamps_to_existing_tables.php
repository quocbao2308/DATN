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
        // Thêm timestamps vào các bảng danh mục
        $tables = [
            'khoa',
            'nganh',
            'chuyen_nganh',
            'khoa_hoc',
            'hoc_ky',
            'phong_hoc',
            'trang_thai_hoc_tap',
            'dm_trinh_do',
            'vai_tro',
            'quyen',
            'vai_tro_quyen',
            'tai_khoan_vai_tro',
            'admin',
            'dao_tao',
            'sinh_vien',
            'giang_vien',
            'mon_hoc',
            'mon_hoc_tien_quyet',
            'lop_hoc_phan',
            'lop_hoc_phan_giang_vien',
            'lich_hoc',
            'lich_thi',
            'cau_hinh_dau_diem',
            'nhap_diem',
            'bang_diem',
            'diem_danh',
            'hoc_phi',
            'chuong_trinh_khung',
            'ai_chatbot_knowledge_base',
            'ai_chatbot_log',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) {
                    if (!Schema::hasColumn($table->getTable(), 'created_at')) {
                        $table->timestamps();
                    }
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'khoa',
            'nganh',
            'chuyen_nganh',
            'khoa_hoc',
            'hoc_ky',
            'phong_hoc',
            'trang_thai_hoc_tap',
            'dm_trinh_do',
            'vai_tro',
            'quyen',
            'vai_tro_quyen',
            'tai_khoan_vai_tro',
            'admin',
            'dao_tao',
            'sinh_vien',
            'giang_vien',
            'mon_hoc',
            'mon_hoc_tien_quyet',
            'lop_hoc_phan',
            'lop_hoc_phan_giang_vien',
            'lich_hoc',
            'lich_thi',
            'cau_hinh_dau_diem',
            'nhap_diem',
            'bang_diem',
            'diem_danh',
            'hoc_phi',
            'chuong_trinh_khung',
            'ai_chatbot_knowledge_base',
            'ai_chatbot_log',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) {
                    if (Schema::hasColumn($table->getTable(), 'created_at')) {
                        $table->dropTimestamps();
                    }
                });
            }
        }
    }
};
