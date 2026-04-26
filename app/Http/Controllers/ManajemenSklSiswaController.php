<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use Illuminate\Http\Request;

class ManajemenSklSiswaController extends Controller
{
    public function index()
    {
        // 1. Ambil data periode yang sedang aktif
        $periodeAktif = Periode::where('is_active', true)->first();

        // 2. Kirim variabel $periodeAktif ke view
        return view('user-siswa.hasil-ujian.index', compact('periodeAktif'));
       
    }
}
