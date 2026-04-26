@extends('layouts.navbar')
@section('title', 'Status Pengumuman Kelulusan')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <h1 class="page-header-title">
                        <i data-feather="activity" class="me-2"></i> Monitor Pengumuman Kelulusan
                    </h1>
                    <div class="page-header-subtitle">
                        Pantau waktu akses dan kelola pengumuman secara real-time
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="card shadow-lg border-0 overflow-hidden">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold text-primary">Status Periode Aktif</h5>
                    @if ($periodeAktif)
                        <a class="btn btn-sm btn-outline-primary" href="{{ route('hasil-ujian.index') }}">
                            <i data-feather="external-link" class="me-1"></i> Cek Hasil Kelulusan
                        </a>
                    @endif
                </div>

                <div class="card-body py-5">
                    @if ($periodeAktif)
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

                        <div class="row justify-content-center align-items-center">

                            {{-- Info Detail --}}
                            <div class="col-lg-5 text-center mb-5 mb-lg-0">
                                <div class="badge bg-primary-soft text-primary mb-2 px-3 py-2 rounded-pill">
                                    {{ $periodeAktif->tahun_ajaran }}
                                </div>
                                <h2 class="display-5 fw-bold mb-4">Tahun Ajaran</h2>

                                <div class="row g-3 mb-3">
                                    <div class="col-6">
                                        <div class="p-3 bg-light rounded-3 shadow-sm border-start border-primary border-4">
                                            <div class="small text-uppercase text-muted fw-bold" style="font-size:0.65rem;">
                                                Waktu Mulai</div>
                                            <div class="fw-bold">{{ $periodeAktif->waktu_mulai->format('d M Y') }}</div>
                                            <div class="small text-primary">
                                                {{ $periodeAktif->waktu_mulai->format('H:i') }} WIT
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 bg-light rounded-3 shadow-sm border-start border-danger border-4">
                                            <div class="small text-uppercase text-muted fw-bold" style="font-size:0.65rem;">
                                                Waktu Selesai</div>
                                            <div class="fw-bold">{{ $periodeAktif->waktu_selesai->format('d M Y') }}</div>
                                            <div class="small text-danger">
                                                {{ $periodeAktif->waktu_selesai->format('H:i') }} WIT
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Stats Siswa & Wali --}}
                                <div class="row g-3 mb-4">
                                    <div class="col-6">
                                        <div class="p-3 bg-light rounded-3 shadow-sm">
                                            <div class="small text-uppercase text-muted fw-bold" style="font-size:0.65rem;">
                                                Total Siswa</div>
                                            <div class="fw-bold fs-4 text-primary">{{ $totalSiswa }}</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 bg-light rounded-3 shadow-sm">
                                            <div class="small text-uppercase text-muted fw-bold" style="font-size:0.65rem;">
                                                Wali Kelas</div>
                                            <div class="fw-bold fs-4 text-success">{{ $totalWali }}</div>
                                        </div>
                                    </div>
                                </div>

                                <a href="{{ route('hasil-ujian.index') }}"
                                    class="btn btn-primary btn-lg w-100 shadow-sm py-3 fw-bold">
                                    <i data-feather="eye" class="me-2"></i> LIHAT HASIL KELULUSAN
                                </a>
                            </div>

                            {{-- Divider --}}
                            <div class="col-lg-1 text-center d-none d-lg-block">
                                <div class="vr h-100" style="min-height:250px;opacity:0.1;"></div>
                            </div>

                            {{-- Timer --}}
                            <div class="col-lg-5 text-center">
                                <div class="mb-3">
                                    <span class="badge {{ $badge }} p-2 px-4 text-uppercase shadow-sm"
                                        id="statusBadge" style="letter-spacing:2px;font-size:0.75rem;">
                                        {{ $status }}
                                    </span>
                                </div>

                                <div class="h6 fw-normal text-muted mb-3" id="timerLabel">Menghitung...</div>

                                <div class="p-4 rounded-4 text-white shadow-lg mb-3 mx-auto"
                                    style="max-width:400px;background:linear-gradient(135deg,#1e293b 0%,#0f172a 100%);border:1px solid rgba(255,255,255,0.1);">
                                    <div class="h1 fw-bold mb-0" id="countdownTimer"
                                        style="font-size:2.8rem;font-family:'Monaco','Consolas',monospace;letter-spacing:2px;">
                                        00:00:00:00
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center gap-4 text-muted text-uppercase fw-bold"
                                    style="font-size:0.65rem;letter-spacing:1px;">
                                    <span>Hari</span>
                                    <span>Jam</span>
                                    <span>Menit</span>
                                    <span>Detik</span>
                                </div>
                            </div>

                        </div>
                    @else
                        {{-- Siswa tidak di periode aktif --}}
                        <div class="text-center py-5">
                            <div class="bg-light d-inline-flex p-4 rounded-circle mb-4">
                                <i data-feather="calendar" style="width:48px;height:48px;" class="text-muted"></i>
                            </div>
                            <h4 class="text-dark fw-bold">Tidak Ada Pengumuman Untukmu</h4>
                            <p class="text-muted">
                                Akun kamu tidak terdaftar pada periode kelulusan yang sedang aktif.<br>
                                Silakan hubungi operator sekolah jika ada pertanyaan.
                            </p>
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
            if (typeof feather !== 'undefined') feather.replace();

            @if ($periodeAktif)
                const startTime = new Date("{{ $periodeAktif->waktu_mulai }}").getTime();
                const endTime = new Date("{{ $periodeAktif->waktu_selesai }}").getTime();
                const timerDisplay = document.getElementById('countdownTimer');
                const timerLabel = document.getElementById('timerLabel');
                const statusBadge = document.getElementById('statusBadge');

                function updateTimer() {
                    const now = new Date().getTime();
                    let distance;

                    if (now < startTime) {
                        distance = startTime - now;
                        timerLabel.innerHTML = 'PENGUMUMAN AKAN DIBUKA DALAM:';
                        timerDisplay.style.color = '#3498db';
                        statusBadge.innerHTML = 'Menunggu';
                        statusBadge.className = 'badge bg-warning p-2 px-4 text-uppercase shadow-sm';
                    } else if (now <= endTime) {
                        distance = endTime - now;
                        timerLabel.innerHTML = 'SISA WAKTU AKSES SISWA:';
                        timerDisplay.style.color = '#2ecc71';
                        statusBadge.innerHTML = 'Sedang Berlangsung';
                        statusBadge.className = 'badge bg-success p-2 px-4 text-uppercase shadow-sm';
                    } else {
                        clearInterval(timer);
                        timerDisplay.innerHTML = '00:00:00:00';
                        timerDisplay.style.color = '#e74c3c';
                        timerLabel.innerHTML = 'MASA PENGUMUMAN TELAH BERAKHIR';
                        statusBadge.innerHTML = 'Sudah Selesai';
                        statusBadge.className = 'badge bg-danger p-2 px-4 text-uppercase shadow-sm';
                        return;
                    }

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    timerDisplay.innerHTML =
                        `${String(days).padStart(2,'0')}:${String(hours).padStart(2,'0')}:${String(minutes).padStart(2,'0')}:${String(seconds).padStart(2,'0')}`;
                }

                updateTimer();
                const timer = setInterval(updateTimer, 1000);
            @endif
        });
    </script>
@endpush
