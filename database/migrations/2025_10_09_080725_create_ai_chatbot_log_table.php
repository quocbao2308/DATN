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
        Schema::create('ai_chatbot_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sinh_vien_id')->nullable()->constrained('sinh_vien');
            $table->string('session_id')->nullable();
            $table->text('cau_hoi_user')->nullable();
            $table->text('cau_tra_loi_bot')->nullable();
            $table->unsignedTinyInteger('do_hai_long')->nullable();
            $table->timestamp('thoi_gian')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_chatbot_log');
    }
};
