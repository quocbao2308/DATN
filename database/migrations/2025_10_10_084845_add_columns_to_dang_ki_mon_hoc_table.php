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
        Schema::table('dang_ki_mon_hoc', function (Blueprint $table) {
            $table->enum('trang_thai', ['cho_duyet', 'da_duyet', 'bi_huy'])->default('da_duyet')->after('qua_mon');
            $table->timestamp('huy_dang_ky_at')->nullable()->after('trang_thai');
            $table->text('ly_do_huy')->nullable()->after('huy_dang_ky_at');
            $table->timestamps();

            $table->index('trang_thai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dang_ki_mon_hoc', function (Blueprint $table) {
            $table->dropColumn(['trang_thai', 'huy_dang_ky_at', 'ly_do_huy', 'created_at', 'updated_at']);
        });
    }
};
