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
        Schema::table('phong_hoc', function (Blueprint $table) {
            $table->string('ten_phong')->after('ma_phong');
            $table->string('loai_phong')->nullable()->after('vi_tri')->comment('Lý thuyết, Thực hành, Hội trường, Phòng máy');
            $table->string('trang_thai')->default('Hoạt động')->after('loai_phong')->comment('Hoạt động, Bảo trì, Không sử dụng');
            $table->text('mo_ta')->nullable()->after('trang_thai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('phong_hoc', function (Blueprint $table) {
            $table->dropColumn(['ten_phong', 'loai_phong', 'trang_thai', 'mo_ta']);
        });
    }
};
