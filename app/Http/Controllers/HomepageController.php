<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Periode;
use App\Models\User;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index()
    {
        // Hitung jumlah siswa (role 3)
        $jumlahSiswa = User::where('role', '3')->count();

        // Hitung jumlah walikelas (role 2)
        $jumlahWalikelas = User::where('role', '2')->count();

        // Hitung jumlah kelas
        $jumlahKelas = Kelas::count();

        $periodeAktif = Periode::where('is_active', 1)->first();

        // Kirim data ke view menggunakan compact
        return view('homepage.index', compact('jumlahSiswa', 'jumlahWalikelas', 'jumlahKelas', 'periodeAktif'));
    }
}
