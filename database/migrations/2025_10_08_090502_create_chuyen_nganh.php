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
        Schema::create('chuyen_nganh', function (Blueprint $table) {
            $table->id();
            $table->string('ten_chuyen_nganh');
            $table->foreignId('nganh_id')->constrained('nganh');
            $table->unique(['ten_chuyen_nganh', 'nganh_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chuyen_nganh');
    }
};
