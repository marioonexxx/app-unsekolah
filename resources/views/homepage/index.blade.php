@extends('layouthomepage.partial.navbar')
@section('title', 'Halaman Utama Hasil Ujian Sekolah SMAN 1 AMBON')
@section('content')
    <main class="main">

        <section id="hero" class="hero section dark-background">

            <img src="{{ asset('images/slider1.png') }}" alt="SMA Negeri 1 Ambon" data-aos="fade-in">

            <div class="container text-center">
                @if ($periodeAktif)
                    @php
                        $now = \Carbon\Carbon::now();
                        $isStarted = $now->greaterThanOrEqualTo($periodeAktif->waktu_mulai);
                        $isEnded = $now->greaterThanOrEqualTo($periodeAktif->waktu_selesai);
                    @endphp

                    <div class="hero-text-box" data-aos="fade-up" data-aos-delay="100">
                        <h2 class="display-4 fw-bold mb-2 text-white" style="text-shadow: 3px 3px 6px rgba(0,0,0,0.5);">
                            Hasil Kelulusan Siswa
                        </h2>
                        <h3 class="h2 fw-bold mb-4" style="color: #ffd700; text-shadow: 2px 2px 4px rgba(0,0,0,0.4);">
                            Tahun Ajaran {{ $periodeAktif->tahun_ajaran }}
                        </h3>
                    </div>

                    @if ($isEnded)
                        {{-- STATUS 1: AKSES BERAKHIR --}}
                        <div class="status-closed-box px-4 py-4" data-aos="zoom-in">
                            <i class="bi bi-door-closed-fill display-4 text-white mb-3 d-block"></i>
                            <h4 class="text-white fw-bold">PENGUMUMAN TELAH DITUTUP</h4>
                            <p class="text-white-50 mb-0">Batas waktu akses online telah berakhir.<br>Silakan hubungi pihak
                                sekolah/operator untuk informasi lebih lanjut.</p>
                        </div>
                    @elseif ($isStarted)
                        {{-- STATUS 2: SUDAH DIBUKA --}}
                        <p class="fs-4 mb-4 text-white" data-aos="fade-up" data-aos-delay="200"
                            style="font-weight: 500; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">
                            Selamat! Pengumuman sudah dapat diakses.
                        </p>
                        <div class="d-flex justify-content-center mt-4" data-aos="fade-up" data-aos-delay="300">
                            <a href="{{ route('login') }}" class="btn-get-started btn-lg shadow-lg">
                                <i class="bi bi-person-check-fill me-2"></i> Cek Hasil Kelulusan
                            </a>
                        </div>
                    @else
                        {{-- STATUS 3: BELUM DIBUKA (COUNTDOWN) --}}
                        <p class="lead mb-4 text-white" data-aos="fade-up" data-aos-delay="200"
                            style="font-weight: 500; letter-spacing: 1px; text-transform: uppercase;">
                            PENGUMUMAN AKAN DIBUKA DALAM:
                        </p>

                        <div id="countdown" class="d-flex justify-content-center flex-wrap gap-3 mb-4" data-aos="fade-up"
                            data-time="{{ $periodeAktif->waktu_mulai->format('Y-m-d H:i:s') }}">

                            <div class="timer-box">
                                <span id="days" class="timer-number">00</span>
                                <span class="timer-label">Hari</span>
                            </div>
                            <div class="timer-box">
                                <span id="hours" class="timer-number">00</span>
                                <span class="timer-label">Jam</span>
                            </div>
                            <div class="timer-box">
                                <span id="minutes" class="timer-number">00</span>
                                <span class="timer-label">Menit</span>
                            </div>
                            <div class="timer-box">
                                <span id="seconds" class="timer-number">00</span>
                                <span class="timer-label">Detik</span>
                            </div>
                        </div>

                        <div class="schedule-badge px-4 py-2 d-inline-block" data-aos="fade-up">
                            <i class="bi bi-calendar3 me-2 text-warning"></i>
                            {{ $periodeAktif->waktu_mulai->translatedFormat('d F Y, H:i') }} WIT
                        </div>
                    @endif
                @else
                    {{-- STATUS 4: TIDAK ADA DATA --}}
                    <h2 class="display-5 fw-bold text-white" data-aos="fade-up">Belum Ada Pengumuman Aktif</h2>
                @endif
            </div>

            <style>
                .hero-text-box {
                    margin-bottom: 2rem;
                }

                /* Glassmorphism Dark Theme */
                .timer-box {
                    background: rgba(0, 0, 0, 0.45);
                    padding: 20px 15px;
                    border-radius: 12px;
                    min-width: 100px;
                    backdrop-filter: blur(10px);
                    border: 1px solid rgba(255, 215, 0, 0.3);
                    box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.4);
                    transition: all 0.3s ease;
                }

                .timer-box:hover {
                    transform: translateY(-8px);
                    background: rgba(185, 28, 28, 0.6);
                    /* Vibe Merah */
                    border-color: #ffd700;
                }

                .timer-number {
                    display: block;
                    font-size: 2.8rem;
                    font-weight: 800;
                    line-height: 1;
                    color: #ffffff;
                    margin-bottom: 8px;
                }

                .timer-label {
                    display: block;
                    font-size: 0.75rem;
                    text-transform: uppercase;
                    letter-spacing: 2px;
                    color: #ffd700;
                    /* Gold */
                    font-weight: 700;
                }

                .status-closed-box {
                    background: rgba(0, 0, 0, 0.6);
                    border: 2px solid #dc3545;
                    border-radius: 20px;
                    backdrop-filter: blur(15px);
                    display: inline-block;
                }

                .schedule-badge {
                    background: rgba(255, 255, 255, 0.1);
                    border: 1px solid rgba(255, 255, 255, 0.2);
                    border-radius: 50px;
                    color: #ffffff;
                    font-size: 0.95rem;
                    backdrop-filter: blur(5px);
                }

                .btn-get-started {
                    background: #ffd700;
                    color: #000000 !important;
                    padding: 16px 40px;
                    border-radius: 50px;
                    font-weight: 800;
                    text-transform: uppercase;
                    letter-spacing: 1px;
                    border: 2px solid #ffd700;
                    transition: all 0.4s ease;
                }

                .btn-get-started:hover {
                    background: transparent;
                    color: #ffd700 !important;
                    box-shadow: 0 0 25px rgba(255, 215, 0, 0.5);
                    transform: scale(1.05);
                }
            </style>
        </section>

        <section id="counts" class="section counts light-background">
            <div class="container" data-aos="fade-up">
                <div class="row gy-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="{{ $jumlahSiswa }}"
                                data-purecounter-duration="1" class="purecounter"></span>
                            <p>Total Siswa Kelas XII</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="{{ $jumlahKelas }}"
                                data-purecounter-duration="1" class="purecounter"></span>
                            <p>Total Rombongan Belajar</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="stats-item text-center w-100 h-100">
                            <span data-purecounter-start="0" data-purecounter-end="{{ $jumlahWalikelas }}"
                                data-purecounter-duration="1" class="purecounter"></span>
                            <p>Total Wali Kelas</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="features" class="features section py-5" style="background: #f8f9fa;">
            <div class="container">

                <div class="text-center mb-5" data-aos="fade-up">
                    <span class="badge text-uppercase fw-semibold px-3 py-2 mb-3"
                        style="background:#ffeaea; color:#c10000; border-radius:50px; letter-spacing:2px; font-size:0.75rem;">
                        Panduan Singkat
                    </span>
                    <h2 class="fw-bold mb-2" style="font-size:2rem;">Cara Mengakses Hasil Kelulusan</h2>
                    <p class="text-muted mx-auto" style="max-width:520px; font-size:0.95rem;">
                        Ikuti tiga langkah berikut untuk mengunduh Surat Keterangan Lulus (SKL) secara online.
                    </p>
                </div>

                <div class="row justify-content-center gy-4">

                    {{-- Step 1 --}}
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="h-100 p-4 bg-white rounded-4 shadow-sm d-flex flex-column align-items-center text-center"
                            style="border-top: 4px solid #c10000; transition: transform .3s;"
                            onmouseover="this.style.transform='translateY(-6px)'"
                            onmouseout="this.style.transform='translateY(0)'">
                            <div class="mb-3 d-flex align-items-center justify-content-center rounded-circle"
                                style="width:72px;height:72px;background:#ffeaea;">
                                <i class="bi bi-box-arrow-in-right" style="font-size:2rem;color:#c10000;"></i>
                            </div>
                            <div class="badge mb-3 px-3 py-1 rounded-pill"
                                style="background:#ffeaea;color:#c10000;font-size:0.75rem;letter-spacing:1px;">
                                LANGKAH 1
                            </div>
                            <h5 class="fw-bold mb-2">Login Sistem</h5>
                            <p class="text-muted small mb-0">
                                Gunakan <strong>NISN</strong> sebagai username dan password yang diberikan oleh operator
                                sekolah.
                            </p>
                        </div>
                    </div>

                    {{-- Step 2 --}}
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="h-100 p-4 bg-white rounded-4 shadow-sm d-flex flex-column align-items-center text-center"
                            style="border-top: 4px solid #f59e0b; transition: transform .3s;"
                            onmouseover="this.style.transform='translateY(-6px)'"
                            onmouseout="this.style.transform='translateY(0)'">
                            <div class="mb-3 d-flex align-items-center justify-content-center rounded-circle"
                                style="width:72px;height:72px;background:#fff8e1;">
                                <i class="bi bi-wallet2" style="font-size:2rem;color:#f59e0b;"></i>
                            </div>
                            <div class="badge mb-3 px-3 py-1 rounded-pill"
                                style="background:#fff8e1;color:#b45309;font-size:0.75rem;letter-spacing:1px;">
                                LANGKAH 2
                            </div>
                            <h5 class="fw-bold mb-2">Cek Status Administrasi</h5>
                            <p class="text-muted small mb-0">
                                Pastikan tidak ada kendala administrasi. Jika ada, segera hubungi <strong>Wali
                                    Kelas</strong> kamu.
                            </p>
                        </div>
                    </div>

                    {{-- Step 3 --}}
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="h-100 p-4 bg-white rounded-4 shadow-sm d-flex flex-column align-items-center text-center"
                            style="border-top: 4px solid #16a34a; transition: transform .3s;"
                            onmouseover="this.style.transform='translateY(-6px)'"
                            onmouseout="this.style.transform='translateY(0)'">
                            <div class="mb-3 d-flex align-items-center justify-content-center rounded-circle"
                                style="width:72px;height:72px;background:#f0fdf4;">
                                <i class="bi bi-file-earmark-arrow-down" style="font-size:2rem;color:#16a34a;"></i>
                            </div>
                            <div class="badge mb-3 px-3 py-1 rounded-pill"
                                style="background:#f0fdf4;color:#15803d;font-size:0.75rem;letter-spacing:1px;">
                                LANGKAH 3
                            </div>
                            <h5 class="fw-bold mb-2">Unduh SKL</h5>
                            <p class="text-muted small mb-0">
                                Tombol download SKL aktif otomatis bagi siswa yang sudah <strong>tervalidasi</strong>.
                            </p>
                        </div>
                    </div>

                </div>

                {{-- Connector line (desktop only) --}}
                <div class="d-none d-lg-flex justify-content-center align-items-center mt-4 gap-0" data-aos="fade-up"
                    data-aos-delay="350">
                    <div
                        style="width:120px;height:2px;background:linear-gradient(to right,#c10000,#f59e0b);border-radius:2px;">
                    </div>
                    <i class="bi bi-arrow-right" style="color:#f59e0b;font-size:1.2rem;margin:0 4px;"></i>
                    <div
                        style="width:120px;height:2px;background:linear-gradient(to right,#f59e0b,#16a34a);border-radius:2px;">
                    </div>
                </div>

            </div>
        </section>

    </main>

    {{-- Script Countdown --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const countdownElement = document.getElementById('countdown');
            if (!countdownElement) return;

            const targetDate = new Date(countdownElement.getAttribute('data-time')).getTime();

            const updateCountdown = () => {
                const now = new Date().getTime();
                const distance = targetDate - now;

                if (distance <= 0) {
                    clearInterval(countdownInterval);
                    setTimeout(() => {
                        window.location.reload();
                    }, 500);
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                const d = document.getElementById('days'),
                    h = document.getElementById('hours'),
                    m = document.getElementById('minutes'),
                    s = document.getElementById('seconds');

                if (d) d.innerText = String(days).padStart(2, '0');
                if (h) h.innerText = String(hours).padStart(2, '0');
                if (m) m.innerText = String(minutes).padStart(2, '0');
                if (s) s.innerText = String(seconds).padStart(2, '0');
            };

            const countdownInterval = setInterval(updateCountdown, 1000);
            updateCountdown();
        });
    </script>
@endsection
