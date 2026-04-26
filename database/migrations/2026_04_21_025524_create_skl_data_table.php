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
        Schema::create('skl', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas');
            $table->foreignId('periode_id')->constrained('periode');

            // Kolom baru untuk status kelulusan
            // 0: Tidak Lulus, 1: Lulus, 2: Ditangguhkan (opsional)
            $table->tinyInteger('status_kelulusan')->default(0);

            $table->boolean('status_pembayaran')->default(0);
            $table->text('keterangan_administrasi')->nullable();
            $table->string('file_skl')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skl_data');
    }
};
