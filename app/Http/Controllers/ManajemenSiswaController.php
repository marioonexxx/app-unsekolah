<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Periode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ManajemenSiswaController extends Controller
{
    public function index(Request $request)
    {
        $periodeAktif = Periode::where('is_active', 1)->first();

        $data['list_periode']       = Periode::all();
        $data['list_kelas']         = Kelas::all();
        $data['kelas_aktif']        = $request->kelas_id;
        $data['periode_aktif_filter'] = $request->periode_id ?? $periodeAktif->id ?? null;

        $query = User::with(['kelas', 'periode'])
            ->where('role', '3')
            ->when($data['periode_aktif_filter'], fn($q) => $q->where('periode_id', $data['periode_aktif_filter']))
            ->when($request->kelas_id, fn($q) => $q->where('kelas_id', $request->kelas_id));

        $data['siswas'] = $query->latest()->get();

        return view('user-admin.manajemen-siswa.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'kelas_id'   => 'required|exists:kelas,id',
            'periode_id' => 'required|exists:periode,id',
            'email'      => 'required|string|unique:users,email',
            'password'   => 'required|min:6',
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'name'       => $request->name,
            'kelas_id'   => $request->kelas_id,
            'periode_id' => $request->periode_id,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => '3',
        ];

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos/siswa', 'public');
        }

        User::create($data);

        return back()->with('success', 'Data Siswa berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $siswa = User::findOrFail($id);

        $request->validate([
            'name'       => 'required|string|max:255',
            'kelas_id'   => 'required|exists:kelas,id',
            'periode_id' => 'required|exists:periode,id',
            'email'      => 'required|string|unique:users,email,' . $id,
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'name'       => $request->name,
            'kelas_id'   => $request->kelas_id,
            'periode_id' => $request->periode_id,
            'email'      => $request->email,
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6']);
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            if ($siswa->photo) {
                Storage::disk('public')->delete($siswa->photo);
            }
            $data['photo'] = $request->file('photo')->store('photos/siswa', 'public');
        }

        $siswa->update($data);

        return back()->with('success', 'Data Siswa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $siswa = User::findOrFail($id);

        if ($siswa->photo) {
            Storage::disk('public')->delete($siswa->photo);
        }

        $siswa->delete();

        return back()->with('success', 'Data Siswa berhasil dihapus!');
    }
}
