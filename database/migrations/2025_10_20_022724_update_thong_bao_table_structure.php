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
        Schema::table('thong_bao', function (Blueprint $table) {
            // Kiểm tra và thêm các cột nếu chưa có
            if (!Schema::hasColumn('thong_bao', 'nguoi_nhan_id')) {
                $table->foreignId('nguoi_nhan_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
            }

            if (!Schema::hasColumn('thong_bao', 'vai_tro_nhan')) {
                $table->string('vai_tro_nhan')->nullable()->after('loai');
            }

            if (!Schema::hasColumn('thong_bao', 'lien_ket')) {
                $table->string('lien_ket')->nullable()->after('noi_dung');
            }

            if (!Schema::hasColumn('thong_bao', 'da_doc')) {
                $table->boolean('da_doc')->default(false)->after('lien_ket');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('thong_bao', function (Blueprint $table) {
            if (Schema::hasColumn('thong_bao', 'nguoi_nhan_id')) {
                $table->dropForeign(['nguoi_nhan_id']);
                $table->dropColumn('nguoi_nhan_id');
            }

            if (Schema::hasColumn('thong_bao', 'vai_tro_nhan')) {
                $table->dropColumn('vai_tro_nhan');
            }

            if (Schema::hasColumn('thong_bao', 'lien_ket')) {
                $table->dropColumn('lien_ket');
            }

            if (Schema::hasColumn('thong_bao', 'da_doc')) {
                $table->dropColumn('da_doc');
            }
        });
    }
};
