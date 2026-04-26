@extends('layouts.navbar')
@section('title', 'Kelola Akun Siswa')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="users"></i></div>
                        Manajemen Siswa
                    </h1>
                    <div class="page-header-subtitle">
                        Daftar akun siswa yang memiliki akses pengumuman
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <span>Data Siswa</span>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahSiswa">
                        <i data-feather="user-plus" class="me-1"></i> Tambah Siswa
                    </button>
                </div>

                <div class="card-body pb-0">
                    <form method="GET" action="{{ route('manajemen-siswa.index') }}" class="row g-2 align-items-end mb-3">
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
                                <a href="{{ route('manajemen-siswa.index') }}" class="btn btn-sm btn-outline-secondary">
                                    <i data-feather="x" style="width:14px;height:14px;"></i> Reset
                                </a>
                            </div>
                        @endif
                    </form>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tableSiswa" class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Foto</th>
                                    <th>Nama Lengkap</th>
                                    <th>Kelas</th>
                                    <th>Email/Username</th>
                                    <th>Dibuat Pada</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($siswas as $s)
                                    <tr>
                                        <td>
                                            @if ($s->photo)
                                                <img src="{{ asset('storage/' . $s->photo) }}" alt="Foto"
                                                    class="img-fluid rounded-circle"
                                                    style="width:40px;height:40px;object-fit:cover;border:1px solid #ddd;">
                                            @else
                                                <div class="bg-gray-200 d-flex align-items-center justify-content-center rounded-circle"
                                                    style="width:40px;height:40px;font-size:10px;color:#666;border:1px solid #ddd;">
                                                    N/A
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $s->name }}</td>
                                        <td>
                                            <span class="badge bg-green-soft text-green">
                                                {{ $s->kelas->nama ?? 'Tanpa Kelas' }}
                                            </span>
                                        </td>
                                        <td>{{ $s->email }}</td>
                                        <td>{{ $s->created_at->translatedFormat('d/m/Y') }}</td>
                                        <td>
                                            <button class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                                                data-bs-toggle="modal" data-bs-target="#modalEdit{{ $s->id }}">
                                                <i data-feather="edit"></i>
                                            </button>

                                            <form action="{{ route('manajemen-siswa.destroy', $s->id) }}" method="POST"
                                                id="form-delete-{{ $s->id }}" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-datatable btn-icon btn-transparent-dark btn-delete"
                                                    data-id="{{ $s->id }}">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    {{-- MODAL EDIT --}}
                                    <div class="modal fade" id="modalEdit{{ $s->id }}" tabindex="-1" role="dialog"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="{{ route('manajemen-siswa.update', $s->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Data Siswa</h5>
                                                        <button class="btn-close" type="button"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="small mb-1">Nama Lengkap</label>
                                                            <input class="form-control" name="name" type="text"
                                                                value="{{ $s->name }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="small mb-1">Kelas</label>
                                                            <select class="form-select" name="kelas_id" required>
                                                                @foreach ($list_kelas as $k)
                                                                    <option value="{{ $k->id }}"
                                                                        {{ $s->kelas_id == $k->id ? 'selected' : '' }}>
                                                                        {{ $k->nama }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="small mb-1">Periode Kelulusan</label>
                                                            <select class="form-select" name="periode_id" required>
                                                                @foreach ($list_periode as $p)
                                                                    <option value="{{ $p->id }}"
                                                                        {{ $s->periode_id == $p->id ? 'selected' : '' }}>
                                                                        {{ $p->tahun_ajaran }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="small mb-1">Email / NISN</label>
                                                            <input class="form-control" name="email" type="text"
                                                                value="{{ $s->email }}" required>
                                                        </div>
                                                        <div class="mb-3 text-center">
                                                            @if ($s->photo)
                                                                <img src="{{ asset('storage/' . $s->photo) }}"
                                                                    class="img-thumbnail mb-2" style="height:100px;">
                                                            @endif
                                                            <input class="form-control" name="photo" type="file"
                                                                accept="image/*">
                                                            <label class="small text-muted mt-1">
                                                                Unggah foto baru jika ingin mengganti
                                                            </label>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="small mb-1">Password Baru
                                                                (Kosongkan jika tidak ganti)
                                                            </label>
                                                            <input class="form-control" name="password" type="password">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-light" type="button"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button class="btn btn-primary" type="submit">Simpan
                                                            Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted fst-italic">
                                            Belum ada data siswa.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL TAMBAH SISWA --}}
        <div class="modal fade" id="modalTambahSiswa" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('manajemen-siswa.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Akun Siswa Baru</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="small mb-1">Nama Lengkap</label>
                                <input class="form-control" name="name" type="text"
                                    placeholder="Masukkan nama siswa" required>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1">Kelas</label>
                                <select class="form-select" name="kelas_id" required>
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($list_kelas as $k)
                                        <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1">Periode Kelulusan</label>
                                <select class="form-select" name="periode_id" required>
                                    @foreach ($list_periode as $p)
                                        <option value="{{ $p->id }}" {{ $p->is_active ? 'selected' : '' }}>
                                            {{ $p->tahun_ajaran }} {{ $p->is_active ? '(Aktif)' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1">Foto Siswa</label>
                                <input class="form-control" name="photo" type="file" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1">Email / NISN</label>
                                <input class="form-control" name="email" type="text"
                                    placeholder="Masukkan NISN atau Email" required>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1">Password</label>
                                <input class="form-control" name="password" type="password" value="12345678" required>
                                <small class="text-muted">Default: 12345678</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-light" type="button" data-bs-dismiss="modal">Tutup</button>
                            <button class="btn btn-primary" type="submit">Simpan Akun</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof feather !== 'undefined') feather.replace();

            // SweetAlert success
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            // SweetAlert error validasi
            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "{{ $errors->first() }}",
                });
            @endif

            // Init Simple DataTables (pakai yang sudah ada di layout)
            const tableEl = document.getElementById('tableSiswa');
            if (typeof simpleDatatables !== 'undefined' && tableEl) {
                new simpleDatatables.DataTable(tableEl, {
                    perPage: 10,
                    perPageSelect: [10, 25, 50],
                    labels: {
                        placeholder: 'Cari...',
                      
                        noRows: 'Data tidak ditemukan',
                        info: 'Menampilkan {start} - {end} dari {rows} data',
                    },
                    columns: [{
                            select: 0,
                            sortable: false
                        }, // Foto
                        {
                            select: 5,
                            sortable: false
                        }, // Aksi
                    ],
                });
            }

            // Konfirmasi hapus — event delegation supaya jalan setelah DataTables render
            document.addEventListener('click', function(e) {
                const button = e.target.closest('.btn-delete');
                if (!button) return;

                const id = button.getAttribute('data-id');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data siswa akan dihapus permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('form-delete-' + id).submit();
                    }
                });
            });
        });
    </script>
@endpush
