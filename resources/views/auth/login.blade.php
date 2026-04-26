@extends('layouthomepage.partial.navbar')
@section('title', 'Login - Hasil Ujian Sekolah SMAN 1 AMBON')

@section('content')
    <main class="main">

        <!-- Header Section -->
        <div class="page-title" data-aos="fade" style="background-color: #dd0037; padding: 80px 0 60px 0;">
            <div class="heading">
                <div class="container">
                    <div class="row d-flex justify-content-center text-center">
                        <div class="col-lg-8">
                            <h1 style="font-weight: 700; color: #ffffff;">Portal Pengumuman UN</h1>
                            <p class="mb-0">Silakan login untuk mengakses hasil ujian dan informasi kelulusan siswa SMAN 1
                                AMBON.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Login Section dengan Padding Lebih Luas -->
        <section id="login-section" class="contact section py-5" style="background: #fdfdfd;">
            <div class="container py-5" data-aos="fade-up" data-aos-delay="100">
                <div class="row justify-content-center">
                    <div class="col-lg-5">

                        <!-- Card Container dengan Aksen Merah -->
                        <div class="info-item"
                            style="padding: 40px; border-radius: 15px; box-shadow: 0px 10px 30px rgba(0,0,0,0.1); background: #ffffff; border-top: 5px solid #dc3545;">

                            <div class="text-center mb-4">
                                <h4 style="font-weight: 600; color: #dc3545;">MASUK KE AKUN</h4>
                            </div>

                            <form action="{{ route('login') }}" method="POST">
                                @csrf

                                <div class="row gy-3">
                                    <div class="col-md-12">
                                        <label for="email" class="form-label" style="font-weight: 500;">Email /
                                            NISN</label>
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            placeholder="user@example.com" value="{{ old('email') }}" required autofocus>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <label for="password" class="form-label" style="font-weight: 500;">Password</label>
                                        <input type="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Masukkan password" required>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                            <label class="form-check-label small" for="remember">Ingat perangkat ini</label>
                                        </div>
                                    </div>

                                    <div class="col-md-12 text-center mt-3">
                                        <button type="submit" class="btn-login-red w-100">
                                            MASUK SEKARANG
                                        </button>
                                    </div>

                                    <div class="col-md-12 text-center mt-4">
                                        <div style="border-top: 1px solid #eee; padding-top: 20px;">
                                            <p class="small text-muted mb-0">Lupa password?</p>
                                            <p class="small">Hubungi <strong>Admin IT SMAN 1 AMBON</strong></p>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <style>
        /* Custom Red Button */
        .btn-login-red {
            background: #dc3545;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 5px;
            font-weight: 600;
            transition: 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-login-red:hover {
            background: #bb2d3b;
            box-shadow: 0px 5px 15px rgba(220, 53, 69, 0.4);
            color: white;
        }

        .form-control:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.25 row rgba(220, 53, 69, 0.25);
        }
    </style>
@endsection
