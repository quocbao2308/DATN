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
        Schema::create('tai_khoan_vai_tro', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tai_khoan_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('vai_tro_id')->constrained('vai_tro')->onDelete('cascade');
            $table->unique(['tai_khoan_id', 'vai_tro_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tai_khoan_vai_tro');
    }
};
