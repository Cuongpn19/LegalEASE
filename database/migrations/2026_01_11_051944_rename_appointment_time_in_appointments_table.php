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
        Schema::table('appointments', function (Blueprint $table) {
        // Chỉ đổi nếu cột cũ tồn tại
        if (Schema::hasColumn('appointments', 'appointment_time')) {
            $table->renameColumn('appointment_time', 'start_time');
        }
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->renameColumn('start_time', 'appointment_time');
        });
    }
};
