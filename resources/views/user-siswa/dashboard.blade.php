@extends('layouts.navbar')
@section('title', 'Status Pengumuman Kelulusan')

@section('content')
    <main>
        {{-- HEADER --}}
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <h1 class="page-header-title">
                        <i data-feather="activity" class="me-2"></i> Monitor Pengumuman Kelulusan
                    </h1>
                    <div class="page-header-subtitle">
                        Pantau waktu akses siswa dan kelola pengumuman secara real-time
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="card shadow-lg border-0 overflow-hidden">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 font-weight-bold text-primary">Status Periode Aktif</h5>
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('hasil-ujian.index') }}">
                        <i data-feather="external-link" class="me-1"></i> Cek Halaman Siswa
                    </a>
                </div>
                <div class="card-body py-5">
                    @if ($periodeAktif)
                        <div class="row justify-content-center align-items-center">
                            {{-- Info Detail --}}
                            <div class="col-lg-5 text-center mb-5 mb-lg-0">
                                <div class="badge bg-primary-soft text-primary mb-2 px-3 py-2 rounded-pill">
                                    {{ $periodeAktif->tahun_ajaran }}
                                </div>
                                <h2 class="display-5 fw-900 mb-4">Tahun Ajaran</h2>

                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="p-3 bg-light rounded-3 shadow-sm border-start border-primary border-4">
                                            <div class="small text-uppercase text-muted fw-700" style="font-size: 0.65rem;">
                                                Waktu Mulai</div>
                                            <div class="fw-bold">{{ $periodeAktif->waktu_mulai->format('d M Y') }}</div>
                                            <div class="small text-primary">{{ $periodeAktif->waktu_mulai->format('H:i') }}
                                                WIB</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 bg-light rounded-3 shadow-sm border-start border-danger border-4">
                                            <div class="small text-uppercase text-muted fw-700" style="font-size: 0.65rem;">
                                                Waktu Selesai</div>
                                            <div class="fw-bold">{{ $periodeAktif->waktu_selesai->format('d M Y') }}</div>
                                            <div class="small text-danger">{{ $periodeAktif->waktu_selesai->format('H:i') }}
                                                WIB</div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Tombol Cek Hasil --}}
                                <div class="mt-4 pt-2">
                                    <a href="{{ route('hasil-ujian.index') }}"
                                        class="btn btn-primary btn-lg w-100 shadow-sm py-3 fw-bold"
                                        style="transition: all 0.3s ease;">
                                        <i data-feather="eye" class="me-2"></i> LIHAT HASIL KELULUSAN
                                    </a>
                                </div>
                            </div>

                            {{-- Divider --}}
                            <div class="col-lg-1 text-center d-none d-lg-block">
                                <div class="vr h-100" style="min-height: 250px; opacity: 0.1;"></div>
                            </div>

                            {{-- Timer Utama --}}
                            <div class="col-lg-5 text-center">
                                @php
                                    $now = now();
                                    $status = 'Menunggu';
                                    $badge = 'bg-warning';

                                    if ($now->between($periodeAktif->waktu_mulai, $periodeAktif->waktu_selesai)) {
                                        $status = 'Sedang Berlangsung';
                                        $badge = 'bg-success';
                                    } elseif ($now->gt($periodeAktif->waktu_selesai)) {
                                        $status = 'Sudah Selesai';
                                        $badge = 'bg-danger';
                                    }
                                @endphp

                                <div class="mb-3">
                                    <span class="badge {{ $badge }} p-2 px-4 text-uppercase shadow-sm"
                                        id="statusBadge" style="letter-spacing: 2px; font-size: 0.75rem;">
                                        {{ $status }}
                                    </span>
                                </div>

                                <div class="h6 fw-normal text-muted mb-3" id="timerLabel">Menghitung...</div>

                                {{-- Countdown Visual --}}
                                <div class="countdown-container p-4 rounded-4 bg-dark text-white shadow-lg mb-3 mx-auto"
                                    style="max-width: 400px; background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border: 1px solid rgba(255,255,255,0.1);">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div class="h1 fw-900 mb-0" id="countdownTimer"
                                            style="font-size: 2.8rem; font-family: 'Monaco', 'Consolas', monospace; letter-spacing: 2px;">
                                            00:00:00:00
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center gap-4 text-muted text-uppercase fw-700"
                                    style="font-size: 0.65rem; letter-spacing: 1px;">
                                    <span>Hari</span>
                                    <span>Jam</span>
                                    <span>Menit</span>
                                    <span>Detik</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="bg-light d-inline-flex p-4 rounded-circle mb-4">
                                <i data-feather="calendar" style="width: 48px; height: 48px;" class="text-muted"></i>
                            </div>
                            <h4 class="text-dark fw-bold">Tidak Ada Periode Aktif</h4>
                            <p class="text-muted">Silakan tentukan jadwal pengumuman di menu Manajemen Periode.</p>
                            <a href="#" class="btn btn-primary px-4 shadow">Atur Periode Sekarang</a>
                        </div>
                    @endif
                </div>
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
                const statusBadge = document.getElementById('statusBadge');

                function updateTimer() {
                    const now = new Date().getTime();
                    let distance, label;

                    if (now < startTime) {
                        distance = startTime - now;
                        label = "PENGUMUMAN AKAN DIBUKA DALAM:";
                        timerDisplay.style.color = "#3498db"; // Blue
                    } else if (now >= startTime && now <= endTime) {
                        distance = endTime - now;
                        label = "SISA WAKTU AKSES SISWA:";
                        timerDisplay.style.color = "#2ecc71"; // Green
                        statusBadge.innerHTML = "Sedang Berlangsung";
                        statusBadge.classList.remove('bg-warning', 'bg-danger');
                        statusBadge.classList.add('bg-success');
                    } else {
                        clearInterval(x);
                        timerDisplay.innerHTML = "00:00:00:00";
                        timerDisplay.style.color = "#e74c3c"; // Red
                        timerLabel.innerHTML = "MASA PENGUMUMAN TELAH BERAKHIR";
                        statusBadge.innerHTML = "Sudah Selesai";
                        statusBadge.classList.remove('bg-warning', 'bg-success');
                        statusBadge.classList.add('bg-danger');
                        return;
                    }

                    timerLabel.innerHTML = label;

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    timerDisplay.innerHTML =
                        `${days.toString().padStart(2, '0')}:${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                }

                updateTimer();
                const x = setInterval(updateTimer, 1000);
            @endif
        });
    </script>
@endpush
