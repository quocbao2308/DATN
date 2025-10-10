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
        Schema::table('tai_khoan', function (Blueprint $table) {
            $table->rememberToken()->after('last_login');
            $table->timestamp('email_verified_at')->nullable()->after('remember_token');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tai_khoan', function (Blueprint $table) {
            $table->dropColumn(['remember_token', 'email_verified_at', 'created_at', 'updated_at']);
        });
    }
};
