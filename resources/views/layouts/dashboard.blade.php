@extends('layouts.app')

@section('page-heading')
<div class="card shadow-sm">
    <div class="card-body">
        <h1 class="fs-3 fw-bold d-flex align-items-center gap-2">
            Selamat Datang <span>👋</span>
        </h1>

        <p class="mt-2 text-muted">
            Hai admin {{ Auth::user()->name ?? '' }},
            selamat datang di Sistem Informasi Akademik.
            Silakan gunakan menu di samping untuk mengelola data akademik.
        </p>
    </div>
</div>
@endsection

@section('content')

{{-- STATISTIK UTAMA --}}
<div class="row mb-3 g-3">
    <div class="col-md-3">
        <div class="card shadow-sm text-center p-3">
            <div class="mb-2 text-primary">
                <i class="bi bi-people-fill fs-2"></i>
            </div>
            <h6 class="mb-1 text-muted">Total Mahasiswa</h6>
            <h4 class="fw-bold">{{ $totalMahasiswa ?? 0 }}</h4>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm text-center p-3">
            <div class="mb-2 text-success">
                <i class="bi bi-person-badge-fill fs-2"></i>
            </div>
            <h6 class="mb-1 text-muted">Total Dosen</h6>
            <h4 class="fw-bold">{{ $totalDosen ?? 0 }}</h4>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm text-center p-3">
            <div class="mb-2 text-warning">
                <i class="bi bi-journal-bookmark-fill fs-2"></i>
            </div>
            <h6 class="mb-1 text-muted">Mata Kuliah</h6>
            <h4 class="fw-bold">{{ $totalMatakuliah ?? 0 }}</h4>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm text-center p-3">
            <div class="mb-2 text-danger">
                <i class="bi bi-calendar-check-fill fs-2"></i>
            </div>
            <h6 class="mb-1 text-muted">Kelas Aktif</h6>
            <h4 class="fw-bold">{{ $totalKelas ?? 0 }}</h4>
        </div>
    </div>
</div>

{{-- AKSI UTAMA --}}
<div class="row mb-4 g-3">
    <div class="col-md-12">
        <a href="#" class="text-decoration-none">
            <div class="border border-primary rounded shadow-sm p-3 d-flex align-items-center justify-content-center">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-file-earmark-text-fill text-primary fs-2"></i>
                    <div>
                        <div class="fw-bold text-dark">Laporan Akademik</div>
                        <div class="text-muted small">Rekap mahasiswa & perkuliahan</div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

{{-- WAKTU --}}
<div class="card shadow-sm mb-3">
    <div class="card-body text-center">
        <h6 class="mb-1">
            <i class="bi bi-clock text-primary me-2"></i>
            Tanggal & Waktu
        </h6>
        <div class="fw-bold">
            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
        </div>
        <div class="text-muted fs-5" id="jam-digital"></div>
    </div>
</div>

<script>
    function updateClock() {
        const now = new Date();
        const jam = String(now.getHours()).padStart(2, '0');
        const menit = String(now.getMinutes()).padStart(2, '0');
        const detik = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('jam-digital').innerText = `${jam}:${menit}:${detik}`;
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>

@endsection