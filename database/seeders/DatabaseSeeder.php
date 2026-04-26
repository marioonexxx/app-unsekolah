<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator SMAN 1 Ambon',
            'email' => 'admin@sman1ambon.sch.id',
            'password' => Hash::make('admin123'), // Ganti dengan password yang aman
            'role' => '1',
        ]);

        // 2. Contoh Wali Kelas
        User::create([
            'name' => 'Guru Penguji',
            'email' => 'guru@sman1ambon.sch.id',
            'password' => Hash::make('guru123'),
            'role' => '2',
        ]);

        // 3. Contoh Siswa (Menggunakan format NISN)
        User::create([
            'name' => 'Siswa Sample 1',
            'email' => '12345678@sman1ambon.sch.id', // Format NISN@domain
            'password' => Hash::make('siswa123'),
            'role' => '3',
        ]);
    }
}
