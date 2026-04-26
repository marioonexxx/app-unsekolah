@extends('layouts.navbar')
@section('title', 'Manajemen Siswa Kelas')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="users"></i></div>
                        Siswa Kelas: {{ auth()->user()->kelas->nama ?? 'N/A' }}
                    </h1>
                    <div class="page-header-subtitle">
                        Daftar siswa aktif pada periode {{ $list_periode->first()->tahun_ajaran ?? '-' }}
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="card mb-4">
                <div class="card-header">
                    Data Siswa
                    <button class="btn btn-sm btn-primary float-end" data-bs-toggle="modal"
                        data-bs-target="#modalTambahSiswa">
                        <i data-feather="user-plus" class="me-1"></i> Tambah Siswa
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Foto</th>
                                    <th>Nama Lengkap</th>
                                    <th>Email/NISN</th>
                                    <th>Periode</th>
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
                                                    style="width: 40px; height: 40px; object-fit: cover; border: 1px solid #ddd;">
                                            @else
                                                <div class="bg-gray-200 d-flex align-items-center justify-content-center rounded-circle"
                                                    style="width: 40px; height: 40px; font-size: 10px; color: #666; border: 1px solid #ddd;">
                                                    N/A
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $s->name }}</td>
                                        <td>{{ $s->email }}</td>
                                        <td>
                                            <span class="badge bg-green-soft text-green">
                                                {{ $s->periode->tahun_ajaran ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                                                data-bs-toggle="modal" data-bs-target="#modalEdit{{ $s->id }}">
                                                <i data-feather="edit"></i>
                                            </button>

                                            <form action="{{ route('walikes-manajemen-siswa.destroy', $s->id) }}"
                                                method="POST" id="form-delete-{{ $s->id }}" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-datatable btn-icon btn-transparent-dark btn-delete"
                                                    data-id="{{ $s->id }}">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    {{-- MODAL EDIT SISWA --}}
                                    <div class="modal fade" id="modalEdit{{ $s->id }}" tabindex="-1" role="dialog"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="{{ route('walikes-manajemen-siswa.update', $s->id) }}"
                                                    method="POST" enctype="multipart/form-data">
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
                                                            <input type="text" class="form-control bg-light"
                                                                value="{{ auth()->user()->kelas->nama ?? '-' }}" readonly
                                                                disabled>
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
                                                                    class="img-thumbnail mb-2" style="height: 100px;">
                                                            @endif
                                                            <input class="form-control" name="photo" type="file"
                                                                accept="image/*">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="small mb-1">Password Baru (Kosongkan jika tidak
                                                                ganti)</label>
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
                                        <td colspan="5" class="text-center italic text-muted py-4">Belum ada data siswa
                                            di kelas Anda.</td>
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
                    <form action="{{ route('walikes-manajemen-siswa.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Siswa Baru</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="small mb-1">Kelas</label>
                                <input type="text" class="form-control bg-light"
                                    value="{{ auth()->user()->kelas->nama ?? '-' }}" readonly disabled>
                            </div>

                            <div class="mb-3">
                                <label class="small mb-1">Nama Lengkap</label>
                                <input class="form-control" name="name" type="text"
                                    placeholder="Masukkan nama siswa" required>
                            </div>

                            <div class="mb-3">
                                <label class="small mb-1">Periode Aktif</label>
                                <select class="form-select" name="periode_id" required>
                                    @foreach ($list_periode as $p)
                                        <option value="{{ $p->id }}">{{ $p->tahun_ajaran }} (Aktif)</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="small mb-1">Email / NISN</label>
                                <input class="form-control" name="email" type="text"
                                    placeholder="Masukkan NISN sebagai username" required>
                            </div>

                            <div class="mb-3">
                                <label class="small mb-1">Password</label>
                                <input class="form-control" name="password" type="password" value="12345678" required>
                                <small class="text-muted">Default: 12345678</small>
                            </div>

                            <div class="mb-3">
                                <label class="small mb-1">Foto Siswa</label>
                                <input class="form-control" name="photo" type="file" accept="image/*">
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
            if (typeof feather !== 'undefined') {
                feather.replace();
            }

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            const deleteButtons = document.querySelectorAll('.btn-delete');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    Swal.fire({
                        title: 'Hapus data siswa?',
                        text: "Data akan dihapus permanen dari kelas Anda!",
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
        });
    </script>
@endpush
