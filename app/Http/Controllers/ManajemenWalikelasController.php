<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ManajemenWalikelasController extends Controller
{
    public function index()
    {
        $walis = User::where('role', '2')->latest()->get();
        $list_kelas = Kelas::all();
        return view('user-admin.manajemen-walikelas.index', compact('walis', 'list_kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|unique:users,email',
            'password' => 'required|min:8',
            'kelas_id' => 'required|exists:kelas,id',
            'photo'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $sudahAda = User::where('role', '2')
            ->where('kelas_id', $request->kelas_id)
            ->exists();

        if ($sudahAda) {
            return back()->withErrors(['kelas_id' => 'Kelas ini sudah memiliki wali kelas!'])->withInput();
        }

        $data = [
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => '2',
            'kelas_id' => $request->kelas_id,
        ];

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos/walikelas', 'public');
        }

        User::create($data);

        return back()->with('success', 'Wali kelas berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $wali = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'kelas_id' => 'required|exists:kelas,id',
            'photo'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $sudahAda = User::where('role', '2')
            ->where('kelas_id', $request->kelas_id)
            ->where('id', '!=', $id)
            ->exists();

        if ($sudahAda) {
            return back()->withErrors(['kelas_id' => 'Kelas ini sudah memiliki wali kelas!'])->withInput();
        }

        $data = [
            'name'     => $request->name,
            'email'    => $request->email,
            'kelas_id' => $request->kelas_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            if ($wali->photo) {
                Storage::disk('public')->delete($wali->photo);
            }
            $data['photo'] = $request->file('photo')->store('photos/walikelas', 'public');
        }

        $wali->update($data);

        return back()->with('success', 'Data Wali Kelas berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $wali = User::findOrFail($id);

        if ($wali->photo) {
            Storage::disk('public')->delete($wali->photo);
        }

        $wali->delete();
        return back()->with('success', 'Data Wali Kelas berhasil dihapus!');
    }
}
