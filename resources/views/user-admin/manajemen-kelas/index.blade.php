@extends('layouts.navbar')
@section('title', 'Manajemen Kelas')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="grid"></i></div>
                        Manajemen Kelas
                    </h1>
                    <div class="page-header-subtitle">Kelola daftar kelas/jurusan untuk pengelompokan siswa</div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="card mb-4">
                <div class="card-header">
                    Daftar Kelas
                    <button class="btn btn-sm btn-primary float-end" data-bs-toggle="modal"
                        data-bs-target="#modalTambahKelas">
                        <i data-feather="plus" class="me-1"></i> Tambah Kelas
                    </button>
                </div>
                <div class="card-body">
                    {{-- Alert Bootstrap dihapus karena sudah digantikan SweetAlert di bawah --}}

                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Nama Kelas</th>
                                    <th>Jumlah Anggota (User)</th>
                                    <th>Dibuat Pada</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($list_kelas as $k)
                                    <tr>
                                        <td class="fw-bold">{{ $k->nama }}</td>
                                        <td>{{ $k->users_count }} Orang</td>
                                        <td>{{ $k->created_at->format('d M Y') }}</td>
                                        <td>
                                            <button class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                                                data-bs-toggle="modal" data-bs-target="#modalEdit{{ $k->id }}">
                                                <i data-feather="edit"></i>
                                            </button>

                                            {{-- PERBAIKAN: Tambahkan ID pada form dan class btn-delete pada button --}}
                                            <form action="{{ route('manajemen-kelas.destroy', $k->id) }}" method="POST"
                                                id="form-delete-{{ $k->id }}" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-datatable btn-icon btn-transparent-dark btn-delete"
                                                    data-id="{{ $k->id }}">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    {{-- MODAL EDIT KELAS --}}
                                    <div class="modal fade" id="modalEdit{{ $k->id }}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="{{ route('manajemen-kelas.update', $k->id) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Nama Kelas</h5>
                                                        <button class="btn-close" type="button"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="small mb-1">Nama Kelas</label>
                                                            <input class="form-control" name="nama" type="text"
                                                                value="{{ $k->nama }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-light" type="button"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button class="btn btn-primary" type="submit">Update Kelas</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted italic">Belum ada data kelas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL TAMBAH KELAS --}}
        <div class="modal fade" id="modalTambahKelas" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('manajemen-kelas.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Kelas Baru</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="small mb-1">Nama Kelas (Contoh: XII RPL 1)</label>
                                <input class="form-control" name="nama" type="text" placeholder="Masukkan nama kelas"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-light" type="button" data-bs-dismiss="modal">Tutup</button>
                            <button class="btn btn-primary" type="submit">Simpan Kelas</button>
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
            // 1. Notifikasi Sukses
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    timer: 2500,
                    showConfirmButton: false
                });
            @endif

            // 2. Notifikasi Error
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                });
            @endif

            // 3. Notifikasi Validasi
            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Input',
                    text: "{{ $errors->first() }}",
                });
            @endif

            // 4. Konfirmasi Hapus (Event Delegation)
            document.addEventListener('click', function(event) {
                if (event.target.closest('.btn-delete')) {
                    const button = event.target.closest('.btn-delete');
                    const id = button.getAttribute('data-id');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data kelas yang dihapus tidak dapat dikembalikan!",
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
                }
            });
        });
    </script>
@endpush
