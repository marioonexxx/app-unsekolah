@extends('layouts.navbar')
@section('title', 'Manajemen Periode')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="calendar"></i></div>
                        Manajemen Periode
                    </h1>
                    <div class="page-header-subtitle">Atur rentang waktu pengumuman kelulusan</div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <span>Daftar Periode</span>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        Tambah Periode
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tablePeriode" class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Tahun Ajaran</th>
                                    <th>Waktu Mulai</th>
                                    <th>Waktu Selesai</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($periodes as $p)
                                    <tr>
                                        <td>{{ $p->tahun_ajaran }}</td>
                                        <td>{{ \Carbon\Carbon::parse($p->waktu_mulai)->format('d M Y - H:i') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($p->waktu_selesai)->format('d M Y - H:i') }}</td>
                                        <td>
                                            @if ($p->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-light text-dark">Non-aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-datatable btn-icon btn-transparent-dark me-2"
                                                data-bs-toggle="modal" data-bs-target="#modalEdit{{ $p->id }}">
                                                <i data-feather="edit"></i>
                                            </button>
                                            <form action="{{ route('periode.destroy', $p->id) }}" method="POST"
                                                id="form-delete-{{ $p->id }}" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-datatable btn-icon btn-transparent-dark btn-delete"
                                                    data-id="{{ $p->id }}">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    {{-- MODAL EDIT --}}
                                    <div class="modal fade" id="modalEdit{{ $p->id }}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="{{ route('periode.update', $p->id) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Periode</h5>
                                                        <button class="btn-close" type="button"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="small mb-1">Tahun Ajaran</label>
                                                            <input class="form-control" name="tahun_ajaran" type="text"
                                                                value="{{ $p->tahun_ajaran }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="small mb-1">Waktu Mulai</label>
                                                            <input class="form-control" name="waktu_mulai"
                                                                type="datetime-local"
                                                                value="{{ date('Y-m-d\TH:i', strtotime($p->waktu_mulai)) }}"
                                                                required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="small mb-1">Waktu Selesai</label>
                                                            <input class="form-control" name="waktu_selesai"
                                                                type="datetime-local"
                                                                value="{{ date('Y-m-d\TH:i', strtotime($p->waktu_selesai)) }}"
                                                                required>
                                                        </div>
                                                        <div class="form-check form-switch mt-2">
                                                            <input class="form-check-input" type="checkbox" name="is_active"
                                                                id="switch{{ $p->id }}"
                                                                {{ $p->is_active ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="switch{{ $p->id }}">
                                                                Aktifkan Periode Ini
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" type="button"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button class="btn btn-primary" type="submit">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted fst-italic">
                                            Belum ada periode.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL TAMBAH --}}
        <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('periode.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Periode Baru</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="small mb-1">Tahun Ajaran (Contoh: 2025/2026)</label>
                                <input class="form-control" name="tahun_ajaran" type="text" placeholder="2025/2026"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1">Waktu Mulai</label>
                                <input class="form-control" name="waktu_mulai" type="datetime-local" required>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1">Waktu Selesai</label>
                                <input class="form-control" name="waktu_selesai" type="datetime-local" required>
                            </div>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_active" id="switchTambah"
                                    checked>
                                <label class="form-check-label" for="switchTambah">
                                    Set sebagai periode aktif
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-light" type="button" data-bs-dismiss="modal">Tutup</button>
                            <button class="btn btn-primary" type="submit">Simpan</button>
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

            const tableEl = document.getElementById('tablePeriode');
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
                            select: 4,
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
                    text: 'Periode ini akan dihapus permanen!',
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
