<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('periode')->insert([
            [
                'tahun_ajaran' => '2025/2026',
                // Contoh: Dibuka 1 Juni 2025 jam 08:00 pagi
                'waktu_mulai' => Carbon::create(2025, 6, 1, 8, 0, 0),
                // Contoh: Ditutup 30 Juni 2025 jam 23:59 malam
                'waktu_selesai' => Carbon::create(2025, 6, 30, 23, 59, 59),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Anda bisa menambah tahun ajaran sebelumnya jika perlu untuk arsip
            [
                'tahun_ajaran' => '2024/2025',
                'waktu_mulai' => Carbon::create(2024, 6, 1, 8, 0, 0),
                'waktu_selesai' => Carbon::create(2024, 6, 30, 23, 59, 59),
                'is_active' => false, // Nonaktifkan periode lama
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
