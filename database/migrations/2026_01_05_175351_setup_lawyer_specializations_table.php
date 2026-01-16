<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Sửa lỗi "Data truncated" cho cột status
        Schema::table('users', function (Blueprint $table) {
            $table->string('status', 20)->default('active')->change();
        });


        if (!Schema::hasTable('lawyer_specializations')) {
        Schema::create('lawyer_specializations', function (Blueprint $table) {
            $table->id();
            // Khóa ngoại nối tới bảng users (luật sư)
            $table->foreignId('lawyer_id')->constrained('users')->onDelete('cascade');
            // Khóa ngoại nối tới bảng specializations
            $table->foreignId('specialization_id')->constrained('specializations')->onDelete('cascade');
            $table->timestamps();
        });
        }

    }

    public function down(): void
    {
        Schema::dropIfExists('lawyer_specializations');
    }
};
