<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <title>@yield('title') | SMA Negeri 1 Ambon</title>
    <meta name="description" content="@yield('meta_description', 'Sistem Informasi Akademik Resmi SMA Negeri 1 Ambon. Kelola data siswa, manajemen kelas, dan administrasi sekolah dengan mudah.')" />
    <meta name="keywords" content="SMA Negeri 1 Ambon, Smansa Ambon, Sekolah Ambon, Manajemen Sekolah, SMAN 1 Ambon" />
    <meta name="author" content="Tim IT SMA Negeri 1 Ambon" />
    <meta name="robots" content="index, follow" />

    <meta property="og:type" content="website" />
    <meta property="og:title" content="@yield('title') | SMA Negeri 1 Ambon" />
    <meta property="og:description" content="@yield('meta_description', 'Portal resmi pengelolaan akademik SMA Negeri 1 Ambon.')" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ asset('assets/img/logo-sman1-ambon.png') }}" />

    <link rel="canonical" href="{{ url()->current() }}" />

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('sbadmin/css/styles.css') }}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous">
    </script>
    @stack('styles')
</head>

<body class="nav-fixed">
    <nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white"
        id="sidenavAccordion">
        <!-- Sidenav Toggle Button-->
        <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0" id="sidebarToggle"><i
                data-feather="menu"></i></button>
        <!-- Navbar Brand-->
        <!-- * * Tip * * You can use text or an image for your navbar brand.-->
        <!-- * * * * * * When using an image, we recommend the SVG format.-->
        <!-- * * * * * * Dimensions: Maximum height: 32px, maximum width: 240px-->
        <a class="navbar-brand pe-3 ps-4 ps-lg-2" href="#">SMAN 1 AMBON</a>

        <!-- Navbar Items-->
        <ul class="navbar-nav align-items-center ms-auto">



            <!-- User Dropdown-->
            <li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
                <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage"
                    href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">

                    @if (Auth::user()->photo)
                        {{-- Jika User memiliki foto di database --}}
                        <img class="img-fluid rounded-circle" src="{{ asset('storage/' . Auth::user()->photo) }}"
                            style="width: 40px; height: 40px; object-fit: cover;" />
                    @else
                        {{-- Jika foto kosong, gunakan foto default --}}
                        <img class="img-fluid"
                            src="{{ asset('sbadmin/assets/img/illustrations/profiles/profile-1.png') }}" />
                    @endif

                </a>
                <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up"
                    aria-labelledby="navbarDropdownUserImage">
                    <h6 class="dropdown-header d-flex align-items-center">
                        {{-- Foto Profil di dalam Dropdown --}}
                        @if (Auth::user()->photo)
                            <img class="dropdown-user-img rounded-circle"
                                src="{{ asset('storage/' . Auth::user()->photo) }}" style="object-fit: cover;" />
                        @else
                            <img class="dropdown-user-img"
                                src="{{ asset('sbadmin/assets/img/illustrations/profiles/profile-1.png') }}" />
                        @endif

                        <div class="dropdown-user-details">
                            {{-- Menampilkan Nama User --}}
                            <div class="dropdown-user-details-name">{{ auth()->user()->name }}</div>

                            {{-- Menampilkan Email atau Role/Kelas --}}
                            <div class="dropdown-user-details-email text-muted">
                                {{ auth()->user()->email }}
                                @if (auth()->user()->role == 2)
                                    <span class="badge bg-primary-soft text-primary sm">Wali Kelas</span>
                                @elseif(auth()->user()->role == 3)
                                    <span class="badge bg-secondary-soft text-secondary sm">Siswa</span>
                                @endif
                            </div>
                        </div>
                    </h6>
                    <div class="dropdown-divider"></div>
                    {{-- <a class="dropdown-item" href="#!">
                        <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                        Account
                    </a> --}}
                    <!-- Logout Form (Hidden) -->
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                    <!-- Tombol Logout -->
                    <a class="dropdown-item" href="#!"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                        Logout
                    </a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sidenav shadow-right sidenav-light">
                @include('layouts.partial.sidebar')
                <!-- Sidenav Footer-->
                <div class="sidenav-footer">
                    <div class="sidenav-footer-content">
                        <div class="sidenav-footer-subtitle">
                            Logged in as:
                            <strong>
                                @if (auth()->user()->role == 1)
                                    Administrator
                                @elseif(auth()->user()->role == 2)
                                    Wali Kelas
                                @else
                                    Siswa
                                @endif
                            </strong>
                        </div>
                        <div class="sidenav-footer-title">{{ auth()->user()->name }}</div>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            @yield('content')
            @include('layouts.partial.footer')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('sbadmin/js/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
    {{-- <script src="{{ asset('sbadmin/assets/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('sbadmin/assets/demo/chart-pie-demo.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="{{ asset('sbadmin/js/datatables/datatables-simple-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')
</body>

</html>
