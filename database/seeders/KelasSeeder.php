<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $daftar_kelas = [
            ['nama' => 'XII RPL 1'],
            ['nama' => 'XII RPL 2'],
            ['nama' => 'XII TKJ 1'],
            ['nama' => 'XII TKJ 2'],
            ['nama' => 'XII Multimedia'],
            ['nama' => 'XII Akuntansi'],
            ['nama' => 'XII Tata Boga'],
        ];

        foreach ($daftar_kelas as $kelas) {
            Kelas::create($kelas);
        }
    }
}
