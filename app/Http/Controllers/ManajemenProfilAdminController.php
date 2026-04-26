<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ManajemenProfilAdminController extends Controller
{
    public function index()
    {
        // Mengambil data user yang sedang login
        $user = Auth::user();

        // Pastikan path view sesuai dengan lokasi file blade Anda
        return view('user-admin.manajemen-profil.index', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Validasi inputan
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            // Custom pesan error (opsional)
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal harus 8 karakter.',
        ]);

        // Update data profil
        $user->name = $request->name;
        $user->email = $request->email;

        // Cek jika user mengisi input password
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Profil Anda berhasil diperbarui!');
    }
}
