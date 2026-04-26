<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Models\User;
use Illuminate\Http\Request;

class UserSiswaController extends Controller
{
    public function index()
    {

        $periodeAktif = Periode::where('is_active', true)->first();
        // Hitung total siswa (role 3) dan wali kelas (misal role 2)
        $totalSiswa = User::where('role', 3)->count();
        $totalWali = User::where('role', 2)->count();
       
        return view('user-siswa.dashboard', compact('periodeAktif', 'totalSiswa', 'totalWali'));
    }
}
