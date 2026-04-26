<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Models\Skl;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManajemenSklController extends Controller
{
    public function index()
    {
        // 1. Ambil periode yang sedang aktif
        $periodeAktif = Periode::where('is_active', true)->first();

        if (!$periodeAktif) {
            return back()->with('error', 'Periode aktif belum ditentukan.');
        }

        // 2. Ambil data siswa dengan filter:
        // - Role 3 (Siswa)
        // - Periode yang sedang aktif
        // - Kelas yang sama dengan Wali Kelas yang sedang login
        $siswas = User::where('role', 3)
            ->where('periode_id', $periodeAktif->id)
            ->where('kelas_id', auth()->user()->kelas_id) // Filter berdasarkan kelas wali kelas
            ->get();

        return view('user-walikelas.manajemen-skl.index', compact('siswas', 'periodeAktif'));
    }

    // app/Http/Controllers/ManajemenSklController.php

    public function update(Request $request, $id)
{
    $request->validate([
        'status_pembayaran' => 'required',
        'status_kelulusan'  => 'required',
        'file_skl'          => 'nullable|mimes:pdf|max:2048',
    ]);

    // Ambil data user siswa untuk dapat kelas_id dan periode_id
    $siswa = User::findOrFail($id);

    $skl = Skl::updateOrCreate(
        ['user_id' => $id],
        [
            'status_pembayaran'       => $request->status_pembayaran,
            'status_kelulusan'        => $request->status_kelulusan,
            'keterangan_administrasi' => $request->keterangan_administrasi,
            'kelas_id'                => $siswa->kelas_id,
            'periode_id'              => $siswa->periode_id,
        ]
    );

    if ($request->hasFile('file_skl')) {
        if ($skl->file_skl) {
            Storage::delete('public/skl/' . $skl->file_skl);
        }

        $file     = $request->file('file_skl');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/skl', $filename);

        $skl->update(['file_skl' => $filename]);
    }

    return redirect()->back()->with('success', 'Data SKL berhasil diperbarui!');
}
}
