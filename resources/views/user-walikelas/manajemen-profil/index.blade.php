@extends('layouts.navbar')
@section('title', 'Edit Profil')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="user"></i></div>
                        Pengaturan Profil
                    </h1>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header text-uppercase small fw-700 text-muted">Detail Akun</div>
                        <div class="card-body">
                            <form action="{{ route('walikelas.profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="small mb-1 fw-600" for="name">Nama Lengkap</label>
                                    <input class="form-control @error('name') is-invalid @enderror" id="name"
                                        name="name" type="text" value="{{ old('name', $user->name) }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="small mb-1 fw-600" for="email">Alamat Email</label>
                                    <input class="form-control @error('email') is-invalid @enderror" id="email"
                                        name="email" type="email" value="{{ old('email', $user->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <hr class="my-4">

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="small mb-1 fw-600" for="password">Password Baru</label>
                                        <input class="form-control @error('password') is-invalid @enderror" id="password"
                                            name="password" type="password" placeholder="Kosongkan jika tidak ubah">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="small mb-1 fw-600" for="password_confirmation">Konfirmasi
                                            Password</label>
                                        <input class="form-control" id="password_confirmation" name="password_confirmation"
                                            type="password">
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <button class="btn btn-primary shadow-sm" type="submit">
                                        <i data-feather="save" class="me-1"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm border-start-lg border-primary">
                        <div class="card-header text-uppercase small fw-700 text-muted">Informasi Akun</div>
                        <div class="card-body">
                            <div class="text-center">
                                <div class="small text-muted mb-1">Status Login:</div>
                                <span class="badge bg-primary-soft text-primary p-2">
                                    <i data-feather="shield" class="me-1" style="width: 12px"></i>
                                    {{ $user->role == 1 ? 'Administrator' : ($user->role == 2 ? 'Wali Kelas' : 'Siswa') }}
                                </span>
                            </div>
                            <hr class="my-3">
                            <div class="small">
                                <span class="text-muted">Terdaftar pada:</span><br>
                                <strong>{{ $user->created_at->format('d F Y') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Notifikasi Sukses
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true
                });
            @endif

            // Notifikasi Error Validasi
            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Input',
                    text: 'Silakan periksa kembali formulir Anda.',
                    confirmButtonColor: '#4e73df'
                });
            @endif
        });
    </script>
@endpush
