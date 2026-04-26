<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Periode;
use App\Models\Skl;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManajemenSklAdminController extends Controller
{
    public function index(Request $request)
    {
        $periodeAktif = Periode::where('is_active', true)->first();

        if (!$periodeAktif) {
            return back()->with('error', 'Periode aktif belum ditentukan.');
        }

        $list_kelas  = Kelas::all();
        $kelas_aktif = $request->kelas_id;

        $siswas = User::where('role', 3)
            ->where('periode_id', $periodeAktif->id)
            ->when($kelas_aktif, fn($q) => $q->where('kelas_id', $kelas_aktif))
            ->with(['skl', 'kelas'])
            ->get();

        return view('user-admin.manajemen-skl.index', compact('siswas', 'periodeAktif', 'list_kelas', 'kelas_aktif'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status_pembayaran' => 'required',
            'status_kelulusan'  => 'required',
            'file_skl'          => 'nullable|mimes:pdf|max:2048',
        ]);

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
