<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Periode;
use App\Models\Skl;
use App\Models\User;
use Illuminate\Http\Request;

class ManajemenMonitoringSklController extends Controller
{
    public function index()
    {
        $periodeAktif = Periode::where('is_active', true)->first();

        if (!$periodeAktif) {
            return back()->with('error', 'Periode aktif belum ditentukan.');
        }

        $kelasList = Kelas::all()->map(function ($kelas) use ($periodeAktif) {
            $totalSiswa = User::where('role', 3)
                ->where('kelas_id', $kelas->id)
                ->where('periode_id', $periodeAktif->id)
                ->count();

            $sudahUpload = Skl::where('kelas_id', $kelas->id)
                ->where('periode_id', $periodeAktif->id)
                ->whereNotNull('file_skl')
                ->count();

            $belumUpload = $totalSiswa - $sudahUpload;
            $persen      = $totalSiswa > 0 ? round(($sudahUpload / $totalSiswa) * 100) : 0;

            return [
                'nama'         => $kelas->nama,
                'total'        => $totalSiswa,
                'sudah_upload' => $sudahUpload,
                'belum_upload' => $belumUpload,
                'persen'       => $persen,
            ];
        })->filter(fn($k) => $k['total'] > 0)->values();

        $totalSiswaKeseluruhan  = $kelasList->sum('total');
        $totalSudahUpload       = $kelasList->sum('sudah_upload');
        $totalBelumUpload       = $kelasList->sum('belum_upload');
        $persenKeseluruhan      = $totalSiswaKeseluruhan > 0
            ? round(($totalSudahUpload / $totalSiswaKeseluruhan) * 100)
            : 0;

        return view('user-admin.monitoring-skl.index', compact(
            'kelasList',
            'periodeAktif',
            'totalSiswaKeseluruhan',
            'totalSudahUpload',
            'totalBelumUpload',
            'persenKeseluruhan'
        ));
    }
}
