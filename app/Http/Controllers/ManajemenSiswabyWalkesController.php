<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ManajemenSiswabyWalkesController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Mengambil siswa dengan role '3' yang berada di kelas walikelas tersebut
        $siswas = User::where('role', '3')
            ->where('kelas_id', $user->kelas_id)
            ->with(['kelas', 'periode'])
            ->get();

        // PERBAIKAN: Hanya mengambil periode yang statusnya aktif (is_active = 1)
        $list_periode = Periode::where('is_active', 1)->get();

        return view('user-walikelas.manajemen-siswa.index', compact('siswas', 'list_periode'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'       => 'required|string|max:255',
            'periode_id' => 'required|exists:periode,id',
            'email'      => 'required|string|unique:users,email',
            'password'   => 'required|min:6',
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'name'       => $request->name,
            'kelas_id'   => $user->kelas_id, // Otomatis dari user login
            'periode_id' => $request->periode_id,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => '3',
        ];

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos/siswa', 'public');
        }

        User::create($data);

        return back()->with('success', 'Siswa berhasil ditambahkan ke kelas Anda!');
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        // Pastikan siswa yang diedit memang anak buahnya
        $siswa = User::where('id', $id)->where('kelas_id', $user->kelas_id)->firstOrFail();

        $request->validate([
            'name'       => 'required|string|max:255',
            'periode_id' => 'required|exists:periode,id',
            'email'      => 'required|string|unique:users,email,' . $id,
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'name'       => $request->name,
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

        return back()->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = auth()->user();
        $siswa = User::where('id', $id)->where('kelas_id', $user->kelas_id)->firstOrFail();

        if ($siswa->photo) {
            Storage::disk('public')->delete($siswa->photo);
        }

        $siswa->delete();
        return back()->with('success', 'Siswa berhasil dihapus!');
    }
}
