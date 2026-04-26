@extends('layouts.navbar')
@section('title', 'Dashboard Wali Kelas')

@section('content')
    <main>
        {{-- HEADER --}}
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <h1 class="page-header-title">
                        <i data-feather="briefcase" class="me-2"></i> Dashboard Wali Kelas
                    </h1>
                    <div class="page-header-subtitle">
                        Manajemen Kelulusan Kelas:
                        <strong>{{ auth()->user()->kelas->nama_kelas ?? 'Belum Ditentukan' }}</strong>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="row">
                {{-- CARD JUMLAH SISWA --}}
                <div class="col-xl-6 mb-4">
                    <div class="card border-start-lg border-primary h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <div class="small fw-bold text-primary text-uppercase mb-1">Jumlah Siswa di Kelas</div>
                                    <div class="h3">{{ $siswas->count() }} Orang</div>
                                    <div class="text-xs text-muted">Tahun Ajaran {{ $periodeAktif->tahun_ajaran ?? '-' }}
                                    </div>
                                </div>
                                <div class="ms-2">
                                    <i data-feather="users" class="text-gray-400" style="width: 3rem; height: 3rem;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CARD TAHUN AJARAN --}}
                <div class="col-xl-6 mb-4">
                    <div class="card border-start-lg border-success h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <div class="small fw-bold text-success text-uppercase mb-1">Tahun Ajaran Aktif</div>
                                    <div class="h3">{{ $periodeAktif->tahun_ajaran ?? 'Tidak Ada' }}</div>
                                    <div class="text-xs text-muted">Status:
                                        {{ $periodeAktif->is_active ? 'Aktif' : 'Non-Aktif' }}</div>
                                </div>
                                <div class="ms-2">
                                    <i data-feather="calendar" class="text-gray-400" style="width: 3rem; height: 3rem;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- MONITOR PERIODE DOWNLOAD --}}
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-white">Monitor Waktu Pengumuman</div>
                <div class="card-body">
                    @if ($periodeAktif)
                        <div class="row align-items-center">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <p class="mb-1"><strong>Waktu Mulai:</strong>
                                    {{ $periodeAktif->waktu_mulai->format('d M Y - H:i') }} WIB</p>
                                <p class="mb-3"><strong>Waktu Selesai:</strong>
                                    {{ $periodeAktif->waktu_selesai->format('d M Y - H:i') }} WIB</p>

                                @php
                                    $now = now();
                                    $statusText = 'Belum Dibuka';
                                    $badgeColor = 'bg-warning';
                                    if ($now->between($periodeAktif->waktu_mulai, $periodeAktif->waktu_selesai)) {
                                        $statusText = 'Akses Dibuka';
                                        $badgeColor = 'bg-success';
                                    } elseif ($now->gt($periodeAktif->waktu_selesai)) {
                                        $statusText = 'Akses Ditutup';
                                        $badgeColor = 'bg-danger';
                                    }
                                @endphp
                                <span class="badge {{ $badgeColor }}">{{ $statusText }}</span>
                            </div>
                            <div class="col-md-6 text-center border-start">
                                <div class="small text-muted mb-1" id="timerLabel">Loading Timer...</div>
                                <div class="h2 fw-bold text-primary mb-0" id="countdownTimer">00:00:00:00</div>
                                <div class="small text-muted">Hari : Jam : Menit : Detik</div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">Informasi periode pengumuman belum tersedia.</div>
                    @endif
                </div>
            </div>

            {{-- TOMBOL CEPAT --}}
            <div class="text-center">
                <a href="{{ route('manajemen-skl.index') }}" class="btn btn-primary btn-lg shadow-sm">
                    <i data-feather="edit-3" class="me-2"></i> Kelola Data SKL Siswa
                </a>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if ($periodeAktif)
                const startTime = new Date("{{ $periodeAktif->waktu_mulai }}").getTime();
                const endTime = new Date("{{ $periodeAktif->waktu_selesai }}").getTime();
                const timerDisplay = document.getElementById('countdownTimer');
                const timerLabel = document.getElementById('timerLabel');

                const x = setInterval(function() {
                    const now = new Date().getTime();
                    let distance, label;

                    if (now < startTime) {
                        distance = startTime - now;
                        label = "Pengumuman dibuka dalam:";
                    } else if (now >= startTime && now <= endTime) {
                        distance = endTime - now;
                        label = "Siswa dapat mendownload SKL:";
                    } else {
                        clearInterval(x);
                        timerDisplay.innerHTML = "00:00:00:00";
                        timerLabel.innerHTML = "Masa pengumuman berakhir.";
                        return;
                    }

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    timerDisplay.innerHTML =
                        `${days.toString().padStart(2,'0')}:${hours.toString().padStart(2,'0')}:${minutes.toString().padStart(2,'0')}:${seconds.toString().padStart(2,'0')}`;
                    timerLabel.innerHTML = label;
                }, 1000);
            @endif
        });
    </script>
@endpush
