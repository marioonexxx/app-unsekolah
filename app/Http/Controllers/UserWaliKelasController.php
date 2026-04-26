<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Models\User;
use Illuminate\Http\Request;

class UserWaliKelasController extends Controller
{
    public function index()
    {
        $periodeAktif = Periode::where('is_active', true)->first();

        // Pastikan Wali Kelas hanya menghitung siswa di kelasnya sendiri
        $siswas = User::where('role', 3)
            ->where('kelas_id', auth()->user()->kelas_id)
            ->get();

        return view('user-walikelas.dashboard', compact('periodeAktif', 'siswas'));
    }
}
