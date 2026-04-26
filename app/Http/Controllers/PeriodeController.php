<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index()
    {
        $periodes = Periode::latest()->get();
        return view('user-admin.manajemen-periode.index', compact('periodes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tahun_ajaran' => 'required|string',
            'waktu_mulai'  => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'is_active'    => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->has('is_active');

        if ($data['is_active']) {
            Periode::where('id', '>', 0)->update(['is_active' => false]);
        }

        Periode::create($data);
        return back()->with('success', 'Periode berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $periode = Periode::findOrFail($id);

        $data = $request->validate([
            'tahun_ajaran'  => 'required|string',
            'waktu_mulai'   => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
        ]);

        $data['is_active'] = $request->has('is_active');

        if ($data['is_active']) {
            Periode::where('id', '!=', $id)->update(['is_active' => false]);
        }

        $periode->update($data);
        return back()->with('success', 'Periode berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Periode::findOrFail($id)->delete();
        return back()->with('success', 'Periode berhasil dihapus!');
    }
}
