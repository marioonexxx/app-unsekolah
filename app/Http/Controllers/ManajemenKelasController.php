<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class ManajemenKelasController extends Controller
{
    public function index()
    {
        $list_kelas = Kelas::withCount(['users' => function ($query) {
            // Filter ini ditujukan untuk tabel users, bukan tabel kelas
            $query->where('role', 3);
        }])
            ->latest()
            ->get();

        return view('user-admin.manajemen-kelas.index', compact('list_kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:kelas,nama',
        ]);

        Kelas::create([
            'nama' => $request->nama
        ]);

        return back()->with('success', 'Kelas baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255|unique:kelas,nama,' . $id,
        ]);

        $kelas->update([
            'nama' => $request->nama
        ]);

        return back()->with('success', 'Nama kelas berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);

        // Cek apakah ada user (siswa/guru) di kelas ini
        if ($kelas->users()->count() > 0) {
            return back()->with('error', 'Kelas tidak bisa dihapus karena masih memiliki data siswa/wali kelas!');
        }

        $kelas->delete();
        return back()->with('success', 'Kelas berhasil dihapus!');
    }
}
