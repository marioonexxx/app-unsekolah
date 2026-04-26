@extends('layouts.navbar')
@section('title', 'Monitoring SKL')

@section('content')
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="bar-chart-2"></i></div>
                        Monitoring Upload SKL
                    </h1>
                    <div class="page-header-subtitle">Periode Aktif:
                        <strong>{{ $periodeAktif->tahun_ajaran }}</strong>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">

            {{-- Summary Cards --}}
            <div class="row g-4 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="card border-start border-primary border-4 h-100">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                <i data-feather="users" style="width:24px;height:24px;color:#4e73df;"></i>
                            </div>
                            <div>
                                <div class="small text-muted">Total Siswa</div>
                                <div class="fw-bold fs-4">{{ $totalSiswaKeseluruhan }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-start border-success border-4 h-100">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-success bg-opacity-10 p-3">
                                <i data-feather="check-circle" style="width:24px;height:24px;color:#1cc88a;"></i>
                            </div>
                            <div>
                                <div class="small text-muted">Sudah Upload</div>
                                <div class="fw-bold fs-4">{{ $totalSudahUpload }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-start border-danger border-4 h-100">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                                <i data-feather="x-circle" style="width:24px;height:24px;color:#e74a3b;"></i>
                            </div>
                            <div>
                                <div class="small text-muted">Belum Upload</div>
                                <div class="fw-bold fs-4">{{ $totalBelumUpload }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-start border-warning border-4 h-100">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                                <i data-feather="percent" style="width:24px;height:24px;color:#f6c23e;"></i>
                            </div>
                            <div>
                                <div class="small text-muted">Progress Keseluruhan</div>
                                <div class="fw-bold fs-4">{{ $persenKeseluruhan }}%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Progress Bar Keseluruhan --}}
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small fw-bold">Progress Upload SKL Keseluruhan</span>
                        <span class="small fw-bold">{{ $totalSudahUpload }} / {{ $totalSiswaKeseluruhan }} siswa</span>
                    </div>
                    <div class="progress" style="height:16px;border-radius:8px;">
                        <div class="progress-bar
                            {{ $persenKeseluruhan == 100 ? 'bg-success' : ($persenKeseluruhan >= 50 ? 'bg-primary' : 'bg-danger') }}"
                            role="progressbar" style="width: {{ $persenKeseluruhan }}%; border-radius:8px;"
                            aria-valuenow="{{ $persenKeseluruhan }}" aria-valuemin="0" aria-valuemax="100">
                            {{ $persenKeseluruhan }}%
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabel Per Kelas --}}
            <div class="card mb-4">
                <div class="card-header border-bottom">
                    Detail Per Kelas
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="tableMonitoring">
                            <thead>
                                <tr>
                                    <th>Kelas</th>
                                    <th>Total Siswa</th>
                                    <th>Sudah Upload</th>
                                    <th>Belum Upload</th>
                                    <th>Progress</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kelasList as $k)
                                    <tr>
                                        <td class="fw-bold">{{ $k['nama'] }}</td>
                                        <td>{{ $k['total'] }}</td>
                                        <td>
                                            <span class="badge bg-success">{{ $k['sudah_upload'] }}</span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $k['belum_upload'] > 0 ? 'bg-danger' : 'bg-success' }}">
                                                {{ $k['belum_upload'] }}
                                            </span>
                                        </td>
                                        <td style="min-width:180px;">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="progress flex-grow-1" style="height:10px;border-radius:6px;">
                                                    <div class="progress-bar
                                                        {{ $k['persen'] == 100 ? 'bg-success' : ($k['persen'] >= 50 ? 'bg-primary' : 'bg-danger') }}"
                                                        role="progressbar"
                                                        style="width: {{ $k['persen'] }}%; border-radius:6px;"
                                                        aria-valuenow="{{ $k['persen'] }}" aria-valuemin="0"
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <span class="small fw-bold"
                                                    style="min-width:36px;">{{ $k['persen'] }}%</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($k['persen'] == 100)
                                                <span class="badge bg-success">Selesai</span>
                                            @elseif($k['persen'] >= 50)
                                                <span class="badge bg-primary">Sebagian</span>
                                            @elseif($k['persen'] > 0)
                                                <span class="badge bg-warning text-dark">Baru Mulai</span>
                                            @else
                                                <span class="badge bg-danger">Belum Ada</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof feather !== 'undefined') feather.replace();

            const tableEl = document.getElementById('tableMonitoring');
            if (typeof simpleDatatables !== 'undefined' && tableEl) {
                new simpleDatatables.DataTable(tableEl, {
                    perPage: 20,
                    perPageSelect: false,
                    labels: {
                        placeholder: 'Cari kelas...',
                        noRows: 'Data tidak ditemukan',
                        info: 'Menampilkan {start} - {end} dari {rows} kelas',
                    },
                    columns: [{
                            select: 4,
                            sortable: false
                        }, // Progress
                        {
                            select: 5,
                            sortable: false
                        }, // Status
                    ],
                });
            }
        });
    </script>
@endpush
