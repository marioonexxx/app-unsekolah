@extends('layouts.navbar')
@section('title', 'Cek Hasil Ujian Sekolah')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <h1 class="page-header-title">
                        <i data-feather="file-text" class="me-2"></i> Pengumuman Hasil Ujian
                    </h1>
                    <div class="page-header-subtitle">Silakan cek status kelulusan dan unduh dokumen SKL Anda</div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-lg border-0">
                        <div class="card-body p-5 text-center">

                            @php
                                $now = now();
                                $isStarted = $periodeAktif && $now->gt($periodeAktif->waktu_mulai);
                                $isEnded = $periodeAktif && $now->gt($periodeAktif->waktu_selesai);
                                $skl = auth()->user()->skl;
                            @endphp

                            @if (!$periodeAktif)
                                {{-- KONDISI 0: SISWA TIDAK DI PERIODE AKTIF --}}
                                <div class="py-5">
                                    <div class="h1 text-secondary mb-3">
                                        <i data-feather="calendar" style="width:50px;height:50px;"></i>
                                    </div>
                                    <h3>Tidak Ada Pengumuman Untukmu</h3>
                                    <p class="text-muted">
                                        Akun kamu tidak terdaftar pada periode kelulusan yang sedang aktif.<br>
                                        Silakan hubungi operator sekolah jika ada pertanyaan.
                                    </p>
                                </div>
                            @elseif ($isEnded)
                                {{-- KONDISI 1: SUDAH LEWAT --}}
                                <div class="py-5">
                                    <div class="h1 text-danger mb-3">
                                        <i data-feather="alert-circle" style="width:50px;height:50px;"></i>
                                    </div>
                                    <h3>Akses Ditutup</h3>
                                    <p class="text-muted">
                                        Masa pengambilan SKL secara online telah berakhir.<br>
                                        Silakan hubungi pihak sekolah untuk informasi lebih lanjut.
                                    </p>
                                </div>
                            @elseif (!$isStarted)
                                {{-- KONDISI 2: BELUM WAKTUNYA --}}
                                <div class="py-5">
                                    <div class="h1 text-primary mb-3">
                                        <i data-feather="clock" style="width:50px;height:50px;"></i>
                                    </div>
                                    <h3>Pengumuman Belum Dibuka</h3>
                                    <p class="text-muted">Sabar ya! Hasil ujian akan dapat diakses pada:</p>
                                    <div class="h4 fw-bold text-dark mb-3">
                                        {{ $periodeAktif->waktu_mulai->translatedFormat('d F Y - H:i') }} WIT
                                    </div>
                                    <hr class="my-4">
                                    <div id="countdown" class="h2 fw-bold text-primary"></div>
                                </div>
                            @else
                                {{-- KONDISI 3: WAKTU TERBUKA --}}

                                {{-- Data Peserta Didik --}}
                                <div class="text-start mb-4">
                                    <h4 class="text-primary border-bottom pb-2">Data Peserta Didik</h4>
                                    <div class="row align-items-center">
                                        <div class="col-md-3 text-center mb-3 mb-md-0">
                                            @if (auth()->user()->photo)
                                                <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Foto Siswa"
                                                    class="img-fluid rounded shadow-sm border"
                                                    style="width:150px;height:200px;object-fit:cover;">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center rounded shadow-sm border mx-auto"
                                                    style="width:150px;height:200px;color:#adb5bd;">
                                                    <div class="text-center">
                                                        <i data-feather="user" style="width:50px;height:50px;"></i>
                                                        <div class="small">Tanpa Foto</div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-9">
                                            <table class="table table-borderless mb-0">
                                                <tr>
                                                    <td class="fw-bold" width="30%">Nama Lengkap</td>
                                                    <td>: {{ auth()->user()->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">NISN</td>
                                                    <td>: {{ auth()->user()->email ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Kelas</td>
                                                    <td>: {{ auth()->user()->kelas->nama ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Periode</td>
                                                    <td>: {{ $periodeAktif->tahun_ajaran }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                {{-- Status Kelulusan --}}
                                <div class="card bg-light border-0 shadow-sm mb-4">
                                    <div class="card-body p-4 text-center">
                                        <h5 class="text-muted text-uppercase small fw-bold mb-3">
                                            Berdasarkan hasil rapat pleno kelulusan, Anda dinyatakan:
                                        </h5>
                                        @if ($skl && $skl->status_kelulusan == 1)
                                            <div class="display-4 fw-bold text-success mb-2">LULUS</div>
                                            <p class="text-muted mt-2">Selamat atas keberhasilan Anda!</p>
                                        @elseif ($skl && $skl->status_kelulusan == 2)
                                            <div class="display-4 fw-bold text-warning mb-2">DITANGGUHKAN</div>
                                            <p class="text-muted mt-2">Status Anda ditangguhkan. Silakan hubungi wali kelas.
                                            </p>
                                        @else
                                            <div class="display-4 fw-bold text-danger mb-2">TIDAK LULUS</div>
                                            <p class="text-muted mt-2">Tetap semangat. Silakan hubungi pihak sekolah.</p>
                                        @endif
                                    </div>
                                </div>

                                <hr class="my-4">

                                {{-- Status Administrasi --}}
                                <div
                                    class="alert {{ $skl && $skl->status_pembayaran == 1 ? 'alert-success' : 'alert-warning' }} border-0 shadow-sm p-4">
                                    <div class="d-flex align-items-center">
                                        <div class="h1 mb-0 me-3">
                                            <i
                                                data-feather="{{ $skl && $skl->status_pembayaran == 1 ? 'check-circle' : 'info' }}"></i>
                                        </div>
                                        <div class="text-start">
                                            <h5 class="mb-1 fw-bold">Status Administrasi</h5>
                                            <p class="mb-0">
                                                @if ($skl && $skl->status_pembayaran == 1)
                                                    Administrasi lunas. Anda dapat mengunduh berkas SKL di bawah ini.
                                                @else
                                                    Administrasi belum lengkap/lunas.<br>
                                                    <small class="fw-bold text-danger">
                                                        Ket:
                                                        {{ $skl->keterangan_administrasi ?? 'Silakan hubungi bagian keuangan.' }}
                                                    </small>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Tombol Download --}}
                                @if ($skl && $skl->status_pembayaran == 1 && $skl->file_skl)
                                    <div class="mt-4">
                                        <p class="text-muted small mb-3">Klik tombol di bawah untuk mengunduh SKL (PDF)</p>
                                        <a href="{{ asset('storage/skl/' . $skl->file_skl) }}"
                                            class="btn btn-primary btn-lg px-5 shadow" download>
                                            <i data-feather="download" class="me-2"></i> Download SKL PDF
                                        </a>
                                    </div>
                                @else
                                    <div class="mt-4">
                                        <button class="btn btn-secondary btn-lg px-5 shadow" disabled>
                                            <i data-feather="lock" class="me-2"></i> SKL Belum Tersedia
                                        </button>
                                    </div>
                                @endif

                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof feather !== 'undefined') feather.replace();

            @if (!$isStarted && $periodeAktif)
                const countDownDate = new Date("{{ $periodeAktif->waktu_mulai }}").getTime();
                const x = setInterval(function() {
                    const now = new Date().getTime();
                    const distance = countDownDate - now;

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    const el = document.getElementById('countdown');
                    if (el) el.innerHTML = `${days} Hari ${hours} Jam ${minutes} Menit ${seconds} Detik`;

                    if (distance < 0) {
                        clearInterval(x);
                        location.reload();
                    }
                }, 1000);
            @endif
        });
    </script>
@endpush
