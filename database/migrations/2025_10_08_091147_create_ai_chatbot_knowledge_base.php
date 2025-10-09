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
        Schema::create('ai_chatbot_knowledge_base', function (Blueprint $table) {
            $table->id();
            $table->string('chu_de');
            $table->text('cau_hoi_mau')->nullable();
            $table->text('cau_tra_loi');
            $table->string('tu_khoa')->nullable();
            $table->dateTime('ngay_cap_nhat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_chatbot_knowledge_base');
    }
};
