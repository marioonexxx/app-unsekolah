<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title', 'Hasil Ujian Sekolah') | SMAN 1 AMBON</title>

    <meta name="description"
        content="Portal resmi pengumuman hasil kelulusan ujian siswa Kelas XII SMA Negeri 1 Ambon Tahun Ajaran {{ $periodeAktif ? $periodeAktif->tahun_ajaran : '-' }}. Cek status kelulusan dan unduh SKL di sini.">
    <meta name="keywords"
        content="kelulusan sma negeri 1 ambon, pengumuman sma 1 ambon, cek skl sma 1 ambon, smansa ambon">

    <meta property="og:title" content="@yield('title') - SMAN 1 AMBON">
    <meta property="og:description"
        content="Klik di sini untuk melihat hasil kelulusan siswa SMA Negeri 1 Ambon tahun ajaran {{ $periodeAktif ? $periodeAktif->tahun_ajaran : '-' }}.">
    <meta property="og:image" content="{{ asset('images/slider1.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title') - SMAN 1 AMBON">

    <link href="{{ asset('images/logo_smansa.png') }}" rel="icon">
    <link href="{{ asset('images/logo_smansa.png') }}" rel="apple-touch-icon">

    <!-- Favicons -->
    <link href="{{ asset('images/logo_smansa.png') }}" rel="icon">
    <link href="{{ asset('images/logo_smansa.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('mentor/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('mentor/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('mentor/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('mentor/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('mentor/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('mentor/assets/css/main.css') }}" rel="stylesheet">

    <!-- =======================================================
  * Template Name: Mentor
  * Template URL: https://bootstrapmade.com/mentor-free-education-bootstrap-theme/
  * Updated: Jul 07 2025 with Bootstrap v5.3.7
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>


<body class="index-page">

    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">

            <a href="{{ route('homepage') }}" class="logo d-flex align-items-center me-auto text-decoration-none">
                <img src="{{ asset('images/logo_smansa.png') }}" alt="Logo SMA Negeri 1 Ambon"
                    style="height:52px; width:52px; object-fit:contain; margin-right:12px;">

                <div class="d-flex flex-column justify-content-center">
                    <span
                        style="
            font-family: 'Raleway', sans-serif;
            font-size: 1.15rem;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #111111;
            line-height: 1.1;
        ">SMAN
                        1 AMBON</span>

                    <span
                        style="
            font-family: 'Poppins', sans-serif;
            font-size: 0.65rem;
            font-weight: 500;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #c10000;
            margin-top: 3px;
            padding-left: 2px;
            border-left: 2px solid #c10000;
            padding-left: 6px;
        ">Berkarakter
                        · Kuat · Cerdas</span>
                </div>
            </a>

            @include('layouthomepage.partial.menubar')

            <a class="btn-getstarted" href="{{ route('login') }}">LOGIN</a>

        </div>
    </header>

    @yield('content')

    @include('layouthomepage.partial.footer')

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('mentor/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('mentor/assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('mentor/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('mentor/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('mentor/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('mentor/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('mentor/assets/js/main.js') }}"></script>

</body>

</html>
