@extends('layouts.navbar')
@section('title', 'Manajemen SKL')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="file-text"></i></div>
                        Manajemen SKL Siswa
                    </h1>
                    <div class="page-header-subtitle">Periode Aktif:
                        <strong>{{ $periodeAktif->tahun_ajaran ?? ($periodeAktif->nama_periode ?? '-') }}</strong>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="card mb-4">
                <div class="card-header border-bottom d-flex align-items-center justify-content-between">
                    <span>Daftar Siswa</span>
                </div>

                <div class="card-body pb-0">
                    <form method="GET" action="{{ route('admin-manajemen-skl.index') }}"
                        class="row g-2 align-items-end mb-3">
                        <div class="col-auto">
                            <label class="small mb-1 d-block">Filter Kelas</label>
                            <select name="kelas_id" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">— Semua Kelas —</option>
                                @foreach ($list_kelas as $k)
                                    <option value="{{ $k->id }}" {{ $kelas_aktif == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if ($kelas_aktif)
                            <div class="col-auto">
                                <a href="{{ route('admin-manajemen-skl.index') }}" class="btn btn-sm btn-outline-secondary">
                                    <i data-feather="x" style="width:14px;height:14px;"></i> Reset
                                </a>
                            </div>
                        @endif
                    </form>
                </div>

                <div class="card-body">
                    @if ($siswas->isEmpty())
                        <div class="text-center text-muted fst-italic py-4">
                            <i data-feather="inbox" style="width:36px;height:36px;" class="mb-2 d-block mx-auto"></i>
                            Belum ada data siswa untuk kelas ini.
                        </div>
                    @else
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
                                            <td>
                                                <span class="badge bg-blue-soft text-blue">
                                                    {{ $s->kelas->nama ?? '-' }}
                                                </span>
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
                                                    <a href="{{ asset('storage/skl/' . $s->skl->file_skl) }}"
                                                        target="_blank" class="btn btn-sm btn-light text-primary">
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

                                        {{-- MODAL KELOLA SKL --}}
                                        <div class="modal fade" id="modalSkl{{ $s->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('admin-manajemen-skl.update', $s->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Update Data: {{ $s->name }}</h5>
                                                            <button class="btn-close" type="button"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="small mb-1 fw-bold">Status Kelulusan</label>
                                                                <select class="form-select" name="status_kelulusan"
                                                                    required>
                                                                    <option value="0"
                                                                        {{ ($s->skl->status_kelulusan ?? 0) == 0 ? 'selected' : '' }}>
                                                                        ❌ Tidak Lulus</option>
                                                                    <option value="1"
                                                                        {{ ($s->skl->status_kelulusan ?? 0) == 1 ? 'selected' : '' }}>
                                                                        ✅ Lulus</option>
                                                                    <option value="2"
                                                                        {{ ($s->skl->status_kelulusan ?? 0) == 2 ? 'selected' : '' }}>
                                                                        ⚠️ Ditangguhkan</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="small mb-1 fw-bold">Status
                                                                    Administrasi</label>
                                                                <select class="form-select" name="status_pembayaran"
                                                                    required>
                                                                    <option value="0"
                                                                        {{ ($s->skl->status_pembayaran ?? 0) == 0 ? 'selected' : '' }}>
                                                                        Bermasalah / Belum Lunas</option>
                                                                    <option value="1"
                                                                        {{ ($s->skl->status_pembayaran ?? 0) == 1 ? 'selected' : '' }}>
                                                                        Lunas / Siap Download</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="small mb-1">Keterangan (Opsional)</label>
                                                                <textarea class="form-control" name="keterangan_administrasi" rows="2"
                                                                    placeholder="Contoh: Belum mengembalikan buku perpustakaan">{{ $s->skl->keterangan_administrasi ?? '' }}</textarea>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="small mb-1">Upload File SKL (PDF)</label>
                                                                <input type="file" name="file_skl" class="form-control"
                                                                    accept=".pdf">
                                                                @if ($s->skl && $s->skl->file_skl)
                                                                    <div class="mt-2 p-2 bg-light border rounded">
                                                                        <small
                                                                            class="text-primary d-flex align-items-center">
                                                                            <i data-feather="file-text" class="me-1"
                                                                                style="width:14px;"></i>
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
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            if (typeof feather !== 'undefined') feather.replace();

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

            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "{{ $errors->first() }}",
                    confirmButtonColor: '#4e73df'
                });
            @endif

            @if ($siswas->isNotEmpty())
                if (!$.fn.DataTable.isDataTable('#datatableSiswa')) {
                    $('#datatableSiswa').DataTable({
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                        },
                        columnDefs: [{
                            orderable: false,
                            targets: [3, 4]
                        }],
                        drawCallback: function() {
                            if (typeof feather !== 'undefined') feather.replace();
                        }
                    });
                }
            @endif
        });
    </script>
@endpush
