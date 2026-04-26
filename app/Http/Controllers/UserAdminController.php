<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Models\User;
use Illuminate\Http\Request;

class UserAdminController extends Controller
{
    public function index()
    {

        $totalSiswa = User::where('role',3)->count();
        $totalWalkes = User::where('role', 2)->count();
        $periodeAktif = Periode::where('is_active', '1')->first();
        return view('user-admin.dashboard', compact('totalSiswa', 'totalWalkes', 'periodeAktif'));
    }
}
