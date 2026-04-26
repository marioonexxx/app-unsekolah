<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use Illuminate\Http\Request;

class ManajemenSklSiswaController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $periodeAktif = Periode::where('is_active', true)->first();

        // Cek apakah siswa terdaftar di periode aktif
        if (!$periodeAktif || $user->periode_id !== $periodeAktif->id) {
            $periodeAktif = null;
        }

        return view('user-siswa.hasil-ujian.index', compact('periodeAktif'));
    }
}
