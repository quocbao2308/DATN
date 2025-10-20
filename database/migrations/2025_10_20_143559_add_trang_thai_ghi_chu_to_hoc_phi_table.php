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
        Schema::table('hoc_phi', function (Blueprint $table) {
            $table->string('trang_thai')->default('chua_nop')->after('ngay_nop')->comment('chua_nop, da_nop, no');
            $table->text('ghi_chu')->nullable()->after('trang_thai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hoc_phi', function (Blueprint $table) {
            $table->dropColumn(['trang_thai', 'ghi_chu']);
        });
    }
};
