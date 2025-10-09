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
        Schema::create('mon_hoc_tien_quyet', function (Blueprint $table) {
            $table->foreignId('mon_hoc_id')->constrained('mon_hoc');
            $table->foreignId('mon_tien_quyet_id')->constrained('mon_hoc');
            $table->primary(['mon_hoc_id', 'mon_tien_quyet_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mon_hoc_tien_quyet');
    }
};
