@extends('layouts.navbar')
@section('title', 'Kelola Wali Kelas')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="user-check"></i></div>
                        Manajemen Wali Kelas
                    </h1>
                    <div class="page-header-subtitle">Kelola akses akun untuk wali kelas setiap jenjang</div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="card mb-4">
                <div class="card-header border-bottom d-flex align-items-center justify-content-between">
                    <span>Daftar Wali Kelas</span>
                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahWali">
                        <i data-feather="plus" class="me-1"></i> Tambah Wali Kelas
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tableWalikelas" class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Foto</th>
                                    <th>Nama Lengkap</th>
                                    <th>Email / Username</th>
                                    <th>Kelas Diampu</th>
                                    <th>Status Akun</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($walis as $w)
                                    <tr>
                                        <td>
                                            @if ($w->photo)
                                                <img src="{{ asset('storage/' . $w->photo) }}" alt="Foto"
                                                    class="rounded-circle"
                                                    style="width:40px;height:40px;object-fit:cover;border:1px solid #ddd;">
                                            @else
                                                <div class="bg-gray-200 d-flex align-items-center justify-content-center rounded-circle"
                                                    style="width:40px;height:40px;font-size:10px;color:#666;border:1px solid #ddd;">
                                                    N/A
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $w->name }}</td>
                                        <td>{{ $w->email }}</td>
                                        <td>
                                            <span class="fw-bold text-primary">
                                                {{ $w->kelas->nama ?? 'Belum Diatur' }}
                                            </span>
                                        </td>
                                        <td><span class="badge bg-green-soft text-green">Wali Kelas</span></td>
                                        <td>
                                            <button class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                                                data-bs-toggle="modal" data-bs-target="#modalEdit{{ $w->id }}">
                                                <i data-feather="edit"></i>
                                            </button>
                                            <form action="{{ route('manajemen-walkes.destroy', $w->id) }}" method="POST"
                                                id="form-delete-{{ $w->id }}" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-datatable btn-icon btn-transparent-dark btn-delete"
                                                    data-id="{{ $w->id }}">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    {{-- MODAL EDIT --}}
                                    <div class="modal fade" id="modalEdit{{ $w->id }}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="{{ route('manajemen-walkes.update', $w->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Akun Wali Kelas</h5>
                                                        <button class="btn-close" type="button"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="small mb-1">Nama Lengkap</label>
                                                            <input class="form-control" name="name" type="text"
                                                                value="{{ $w->name }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="small mb-1">Pilih Kelas</label>
                                                            <select class="form-select" name="kelas_id" required>
                                                                <option value="">-- Pilih Kelas --</option>
                                                                @foreach ($list_kelas as $k)
                                                                    <option value="{{ $k->id }}"
                                                                        {{ $w->kelas_id == $k->id ? 'selected' : '' }}>
                                                                        {{ $k->nama }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="small mb-1">Email / Username</label>
                                                            <input class="form-control" name="email" type="email"
                                                                value="{{ $w->email }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="small mb-1">Ganti Password
                                                                (Kosongkan jika tetap)
                                                            </label>
                                                            <input class="form-control" name="password" type="password"
                                                                placeholder="********">
                                                        </div>
                                                        <div class="mb-3 text-center">
                                                            @if ($w->photo)
                                                                <img src="{{ asset('storage/' . $w->photo) }}"
                                                                    class="img-thumbnail mb-2 rounded-circle"
                                                                    style="height:80px;width:80px;object-fit:cover;">
                                                            @endif
                                                            <input class="form-control" name="photo" type="file"
                                                                accept="image/*">
                                                            <label class="small text-muted mt-1">
                                                                Unggah foto baru jika ingin mengganti
                                                            </label>
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
                                            Data wali kelas masih kosong.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL TAMBAH WALI KELAS --}}
        <div class="modal fade" id="modalTambahWali" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('manajemen-walkes.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Wali Kelas Baru</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="small mb-1">Nama Lengkap</label>
                                <input class="form-control" name="name" type="text"
                                    placeholder="Nama Guru / Wali Kelas" required>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1">Pilih Kelas</label>
                                <select class="form-select" name="kelas_id" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach ($list_kelas as $k)
                                        <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1">Email / Username</label>
                                <input class="form-control" name="email" type="email" placeholder="wali@sekolah.id"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1">Password</label>
                                <input class="form-control" name="password" type="password" required>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1">Foto (Opsional)</label>
                                <input class="form-control" name="photo" type="file" accept="image/*">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-light" type="button" data-bs-dismiss="modal">Tutup</button>
                            <button class="btn btn-success" type="submit">Simpan Akun</button>
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

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "{{ $errors->first() }}",
                });
            @endif

            const tableEl = document.getElementById('tableWalikelas');
            if (typeof simpleDatatables !== 'undefined' && tableEl) {
                new simpleDatatables.DataTable(tableEl, {
                    perPage: 10,
                    perPageSelect: false,
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

            document.addEventListener('click', function(e) {
                const button = e.target.closest('.btn-delete');
                if (!button) return;

                const id = button.getAttribute('data-id');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Akun wali kelas ini akan dihapus permanen!',
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
