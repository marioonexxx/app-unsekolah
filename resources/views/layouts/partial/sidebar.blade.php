 <div class="sidenav-menu">
     <div class="nav accordion" id="accordionSidenav">
         <!-- Sidenav Menu Heading (Account)-->
         
         <div class="nav accordion" id="accordionSidenav">

             <div class="sidenav-menu-heading">Core</div>
             <a class="nav-link" href="{{ route('dashboard') }}">
                 <div class="nav-link-icon"><i data-feather="activity"></i></div>
                 Dashboard
             </a>

             @if (Auth::user()->role == '1')
                 <div class="sidenav-menu-heading">Admin Menu</div>
                 <a class="nav-link" href="{{ route('manajemen-siswa.index') }}">
                     <div class="nav-link-icon"><i data-feather="users"></i></div>
                     Manajemen Siswa
                 </a>
                 <a class="nav-link" href="{{ route('manajemen-walkes.index') }}">
                     <div class="nav-link-icon"><i data-feather="users"></i></div>
                     Manajemen Wali Kelas
                 </a>

                 <a class="nav-link" href="{{ route('admin-manajemen-skl.index') }}">
                     <div class="nav-link-icon"><i data-feather="upload-cloud"></i></div>
                     Upload SKL
                 </a>
                 <a class="nav-link" href="{{ route('monitoring-skl.index') }}">
                     <div class="nav-link-icon"><i data-feather="pie-chart"></i></div>
                     Monitoring SKL
                 </a>
                 <a class="nav-link" href="{{ route('manajemen-kelas.index') }}">
                     <div class="nav-link-icon"><i data-feather="users"></i></div>
                     Manajemen Kelas
                 </a>
                 <a class="nav-link" href="{{ route('periode.index') }}">
                     <div class="nav-link-icon"><i data-feather="settings"></i></div>
                     Setting Periode
                 </a>

                 <a class="nav-link" href="{{ route('manajemen-profil.index') }}">
                     <div class="nav-link-icon"><i data-feather="user"></i></div>
                     Profil
                 </a>
             @elseif(Auth::user()->role == '2')
                 <div class="sidenav-menu-heading">Upload Dokumen</div>
                 <a class="nav-link" href="{{ route('manajemen-skl.index') }}">
                     <div class="nav-link-icon"><i data-feather="upload-cloud"></i></div>
                     Upload SKL
                 </a>

                 <a class="nav-link" href="{{ route('walikes-manajemen-siswa.index') }}">
                     <div class="nav-link-icon"><i data-feather="upload-cloud"></i></div>
                     Manage Data Siswa
                 </a>
                 <a class="nav-link" href="{{ route('walikelas.profile.index') }}">
                     <div class="nav-link-icon"><i data-feather="users"></i></div>
                     Profil
                 </a>
             @elseif(Auth::user()->role == '3')
                 <div class="sidenav-menu-heading">Menu Siswa</div>

                 {{-- Menu Profil --}}
                 {{-- <a class="nav-link" href="/siswa/profil">
                     <div class="nav-link-icon"><i data-feather="user"></i></div>
                     Profil Siswa
                 </a> --}}

                 {{-- Menu Hasil Ujian --}}
                 <a class="nav-link" href="{{ route('hasil-ujian.index') }}">
                     <div class="nav-link-icon"><i data-feather="file-text"></i></div>
                     Lihat Hasil Ujian
                 </a>

                 {{-- Menu Logout (Menggunakan Form agar Aman) --}}
                 <a class="nav-link text-danger" href="javascript:void(0);"
                     onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                     <div class="nav-link-icon"><i class="text-danger" data-feather="log-out"></i></div>
                     Logout
                 </a>

                 {{-- Hidden Logout Form --}}
                 <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                     @csrf
                 </form>
             @endif

         </div>




     </div>
 </div>
