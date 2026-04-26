<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Models\User;
use Illuminate\Http\Request;

class UserSiswaController extends Controller
{
    public function index()
    {
        $user         = auth()->user();
        $periodeAktif = Periode::where('is_active', true)->first();

        // Cek apakah siswa terdaftar di periode aktif
        if (!$periodeAktif || $user->periode_id !== $periodeAktif->id) {
            $periodeAktif = null;
        }

        $totalSiswa = User::where('role', 3)
            ->where('periode_id', $periodeAktif->id ?? 0)
            ->count();

        $totalWali = User::where('role', 2)->count();

        return view('user-siswa.dashboard', compact('periodeAktif', 'totalSiswa', 'totalWali'));
    }
}
