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
        Schema::create('phong_hoc', function (Blueprint $table) {
            $table->id();
            $table->string('ma_phong')->unique();
            $table->integer('suc_chua')->nullable();
            $table->string('vi_tri')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phong_hoc');
    }
};
