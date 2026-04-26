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
        Schema::create('periode', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_ajaran'); // Contoh: 2025/2026
            $table->dateTime('waktu_mulai'); // Kapan siswa mulai bisa login
            $table->dateTime('waktu_selesai'); // Batas akhir akses (opsional)
            $table->boolean('is_active')->default(false); // Switch manual
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periode');
    }
};
