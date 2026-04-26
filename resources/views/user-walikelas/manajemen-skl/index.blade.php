@extends('layouts.navbar')
@section('title', 'Manajemen SKL')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="file-text"></i></div>
                                Manajemen SKL Siswa
                            </h1>
                            <div class="page-header-subtitle">Periode Aktif:
                                <strong>{{ $periodeAktif->nama_periode }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="card mb-4">
                <div class="card-header border-bottom">
                    <ul class="nav nav-tabs card-header-tabs" id="cardTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="overview-tab" data-bs-toggle="tab" href="#overview"
                                role="tab" aria-controls="overview" aria-selected="true">Daftar Siswa</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="datatableSiswa">
                            <thead>
                                <tr>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Status Admin</th>
                                    <th>File SKL</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($siswas as $s)
                                    <tr>
                                        <td>
                                            <div class="fw-bold">{{ $s->name }}</div>
                                            <div class="small text-muted">{{ $s->email }}</div>
                                        </td>
                                        <td><span class="badge bg-blue-soft text-blue">{{ $s->kelas->nama ?? '-' }}</span>
                                        </td>
                                        <td>
                                            @if ($s->skl && $s->skl->file_skl)
                                                <span
                                                    class="badge {{ $s->skl->status_pembayaran == 1 ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $s->skl->status_pembayaran == 1 ? 'Lunas' : 'Bermasalah' }}
                                                </span>
                                            @else
                                                <span class="badge bg-warning text-dark">Belum Upload</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($s->skl && $s->skl->file_skl)
                                                <a href="{{ asset('storage/skl/' . $s->skl->file_skl) }}" target="_blank"
                                                    class="btn btn-sm btn-light text-primary">
                                                    <i data-feather="download"></i> PDF
                                                </a>
                                            @else
                                                <span class="text-muted small">Kosong</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#modalSkl{{ $s->id }}">
                                                <i data-feather="edit-2"></i> Kelola
                                            </button>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="modalSkl{{ $s->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('manajemen-skl.update', $s->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Update Data: {{ $s->name }}</h5>
                                                        <button class="btn-close" type="button" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="small mb-1 fw-bold">Status Kelulusan</label>
                                                            <select
                                                                class="form-select @error('status_kelulusan') is-invalid @enderror"
                                                                name="status_kelulusan" required>
                                                                <option value="0"
                                                                    {{ ($s->skl->status_kelulusan ?? 0) == 0 ? 'selected' : '' }}>
                                                                    ❌ Tidak Lulus
                                                                </option>
                                                                <option value="1"
                                                                    {{ ($s->skl->status_kelulusan ?? 0) == 1 ? 'selected' : '' }}>
                                                                    ✅ Lulus
                                                                </option>
                                                                <option value="2"
                                                                    {{ ($s->skl->status_kelulusan ?? 0) == 2 ? 'selected' : '' }}>
                                                                    ⚠️ Ditangguhkan
                                                                </option>
                                                            </select>
                                                            @error('status_kelulusan')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="small mb-1 fw-bold">Status Administrasi</label>
                                                            <select
                                                                class="form-select @error('status_pembayaran') is-invalid @enderror"
                                                                name="status_pembayaran" required>
                                                                <option value="0"
                                                                    {{ ($s->skl->status_pembayaran ?? 0) == 0 ? 'selected' : '' }}>
                                                                    Bermasalah / Belum Lunas
                                                                </option>
                                                                <option value="1"
                                                                    {{ ($s->skl->status_pembayaran ?? 0) == 1 ? 'selected' : '' }}>
                                                                    Lunas / Siap Download
                                                                </option>
                                                            </select>
                                                            @error('status_pembayaran')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="small mb-1">Keterangan (Opsional)</label>
                                                            <textarea class="form-control" name="keterangan_administrasi" rows="2"
                                                                placeholder="Contoh: Belum mengembalikan buku perpustakaan">{{ $s->skl->keterangan_administrasi ?? '' }}</textarea>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="small mb-1">Upload File SKL (PDF)</label>
                                                            <input type="file" name="file_skl"
                                                                class="form-control @error('file_skl') is-invalid @enderror"
                                                                accept=".pdf">
                                                            @error('file_skl')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror

                                                            @if ($s->skl && $s->skl->file_skl)
                                                                <div class="mt-2 p-2 bg-light border rounded">
                                                                    <small class="text-primary d-flex align-items-center">
                                                                        <i data-feather="file-text" class="me-1"
                                                                            style="width: 14px"></i>
                                                                        File saat ini: {{ $s->skl->file_skl }}
                                                                    </small>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button class="btn btn-light" type="button"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button class="btn btn-primary" type="submit">
                                                            <i data-feather="save" class="me-1"></i> Simpan Perubahan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0;
        }

        div.dataTables_wrapper div.dataTables_filter label {
            margin-bottom: 15px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            if (!$.fn.DataTable.isDataTable('#datatableSiswa')) {
                $('#datatableSiswa').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
                    },
                    "columnDefs": [{
                        "orderable": false,
                        "targets": [3, 4]
                    }],
                    "drawCallback": function(settings) {
                        feather.replace(); // Re-render icon saat pindah page
                    }
                });
            }
            feather.replace();
        });
    </script>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable
            if (!$.fn.DataTable.isDataTable('#datatableSiswa')) {
                $('#datatableSiswa').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
                    },
                    "columnDefs": [{
                        "orderable": false,
                        "targets": [3, 4]
                    }],
                    "drawCallback": function(settings) {
                        feather.replace();
                    }
                });
            }
            feather.replace();

            // 1. Notifikasi Sukses dari Session
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
            @endif

            // 2. Notifikasi Error Validasi
            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Terjadi kesalahan input, silakan periksa kembali.',
                    confirmButtonColor: '#4e73df'
                });
            @endif

            // 3. Konfirmasi Sebelum Submit Form (Opsional - Lebih Aman)
            $(document).on('submit', 'form', function(e) {
                const form = this;
                e.preventDefault(); // Tahan form agar tidak langsung kirim

                Swal.fire({
                    title: 'Simpan Perubahan?',
                    text: "Pastikan data status dan file SKL sudah benar.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#4e73df',
                    cancelButtonColor: '#858796',
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Kirim form jika user klik Ya
                    }
                });
            });
        });
    </script>
@endpush
