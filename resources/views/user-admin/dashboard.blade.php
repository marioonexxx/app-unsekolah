@extends('layouts.navbar')
@section('title', 'Dashboard Administrator Hasil Ujian Sekolah')

@section('content')
    <main>

        {{-- HEADER --}}
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <h1 class="page-header-title">
                        <i data-feather="home"></i> Dashboard Admin
                    </h1>
                    <div class="page-header-subtitle">
                        Sistem Informasi Hasil Ujian Sekolah
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">

            {{-- CARD RINGKASAN (DUMMY) --}}
            <div class="row">
                <div class="col-xl-4 mb-4">
                    <div class="card border-start-lg border-primary h-100">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <div class="small text-muted text-uppercase fw-bold">Total Siswa</div>
                            <div class="h3 mb-0">{{ $totalSiswa }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 mb-4">
                    <div class="card border-start-lg border-success h-100">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <div class="small text-muted text-uppercase fw-bold">Total Wali Kelas</div>
                            <div class="h3 mb-0">{{ $totalWalkes }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 mb-4">
                    <div class="card border-start-lg border-warning h-100">
                        <div class="card-body">
                            <div class="small text-muted text-uppercase fw-bold mb-2">
                                Periode Aktif ({{ $periodeAktif->tahun_ajaran }})
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="text-xs font-weight-bold text-success text-uppercase">Mulai</div>
                                    <div class="h6 mb-0">{{ $periodeAktif->waktu_mulai->format('d M Y') }}</div>
                                    <div class="small text-muted">{{ $periodeAktif->waktu_mulai->format('H:i') }}</div>
                                </div>
                                <div class="col-6 border-start">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase">Selesai</div>
                                    <div class="h6 mb-0">{{ $periodeAktif->waktu_selesai->format('d M Y') }}</div>
                                    <div class="small text-muted">{{ $periodeAktif->waktu_selesai->format('H:i') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- MENU CEPAT --}}
            <div class="row">
                <div class="col-xl-4 mb-4">
                    <a href="{{ route('manajemen-kelas.index') }}" class="card lift h-100 text-decoration-none">
                        <div class="card-body text-center">
                            <i data-feather="users" class="mb-3"></i>
                            <h5>Setting Akun Siswa</h5>
                            <p class="small text-muted">Kelola akun siswa</p>
                        </div>
                    </a>
                </div>

                <div class="col-xl-4 mb-4">
                    <a href="{{ route('manajemen-walkes.index') }}" class="card lift h-100 text-decoration-none">
                        <div class="card-body text-center">
                            <i data-feather="user-check" class="mb-3"></i>
                            <h5>Setting Wali Kelas</h5>
                            <p class="small text-muted">Kelola akun wali kelas</p>
                        </div>
                    </a>
                </div>

                <div class="col-xl-4 mb-4">
                    <a href="{{ route('periode.index') }}" class="card lift h-100 text-decoration-none">
                        <div class="card-body text-center">
                            <i data-feather="calendar" class="mb-3"></i>
                            <h5>Manajemen Periode</h5>
                            <p class="small text-muted">Atur waktu pengumuman</p>
                        </div>
                    </a>
                </div>
            </div>

            {{-- STATUS PERIODE --}}
            <div class="card mb-4">
                <div class="card-header">Status Pengumuman Kelulusan</div>
                <div class="card-body">

                    <p>
                        <strong>Tahun:</strong> 2025/2026 <br>
                        <strong>Mulai:</strong> 10 Juni 2026 - 08:00 <br>
                        <strong>Selesai:</strong> 15 Juni 2026 - 23:59
                    </p>

                    <span class="badge bg-success">Sedang Dibuka</span>
                    {{-- opsi lain:
                <span class="badge bg-warning">Belum Dibuka</span>
                <span class="badge bg-danger">Sudah Ditutup</span>
                --}}

                </div>
            </div>

        </div>
    </main>
@endsection
