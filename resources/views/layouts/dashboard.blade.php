@extends('layouts.app')

@section('page-heading')
<div class="card shadow-sm page-heading-card">
    <div class="card-body">
        <h1 class="fs-3 fw-bold d-flex align-items-center gap-2">
            Selamat Datang <span>👋</span>
        </h1>

        <p class="mt-2 text-muted">
            Hai {{ Auth::user()->name }},
            selamat datang di Sistem Informasi E-Learning.
            Silakan gunakan menu di samping untuk mengakses fitur sesuai peran Anda.
        </p>
    </div>
</div>
@endsection

@section('content')

<style>
    /* ================= DASHBOARD GLOBAL ================= */
    .card {
        border-radius: 16px;
        transition: all .25s ease;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, .08);
    }

    /* ================= STAT CARD ================= */
    .card.shadow-sm.text-center.p-3 {
        background: linear-gradient(135deg, #ffffff, #f8f9fa);
        border: none;
    }

    .card.shadow-sm.text-center.p-3 i {
        background: rgba(0, 123, 255, 0.08);
        padding: 14px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    /* Warna icon khusus */
    .text-success {
        background-color: rgba(25, 135, 84, .08) !important;
    }

    .text-warning {
        background-color: rgba(255, 193, 7, .12) !important;
    }

    .text-danger {
        background-color: rgba(220, 53, 69, .12) !important;
    }

    /* ================= AKSI CEPAT ================= */
    .border.rounded.shadow-sm.p-3.text-center {
        border-radius: 18px !important;
        transition: all .25s ease;
        background: linear-gradient(135deg, #f8f9fa, #ffffff);
    }

    .border.rounded.shadow-sm.p-3.text-center:hover {
        transform: scale(1.03);
        box-shadow: 0 15px 35px rgba(0, 0, 0, .1);
    }

    /* ================= HEADER ================= */
    .page-heading-card {
        border: none;
        background: linear-gradient(135deg, #ffffff, #eaeff7);
        color: white;
    }

    .page-heading-card p {
        color: rgba(2, 20, 71, 0.85) !important;
    }


    /* ================= JAM DIGITAL ================= */
    #jam-digital {
        font-size: 1.6rem;
        font-weight: 600;
        letter-spacing: 2px;
        color: #0d6efd;
    }

    /* ================= RESPONSIVE ================= */
    @media (max-width: 768px) {
        h1.fs-3 {
            font-size: 1.4rem !important;
        }
    }
</style>


{{-- ===================== STATISTIK DASHBOARD ===================== --}}
<div class="row mb-3 g-3">

    {{-- ================= ADMIN ================= --}}
    @if(Auth::user()->role === 'admin')
    <div class="col-md-3">
        <div class="card shadow-sm text-center p-3">
            <i class="bi bi-people-fill fs-2 text-primary"></i>
            <h6 class="text-muted mt-2">Total Mahasiswa</h6>
            <h4 class="fw-bold">{{ $totalMahasiswa ?? 0 }}</h4>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm text-center p-3">
            <i class="bi bi-person-badge-fill fs-2 text-success"></i>
            <h6 class="text-muted mt-2">Total Dosen</h6>
            <h4 class="fw-bold">{{ $totalDosen ?? 0 }}</h4>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm text-center p-3">
            <i class="bi bi-journal-bookmark-fill fs-2 text-warning"></i>
            <h6 class="text-muted mt-2">Mata Kuliah</h6>
            <h4 class="fw-bold">{{ $totalMatakuliah ?? 0 }}</h4>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm text-center p-3">
            <i class="bi bi-clipboard-data-fill fs-2 text-danger"></i>
            <h6 class="text-muted mt-2">Kelas Aktif</h6>
            <h4 class="fw-bold">{{ $totalKelas ?? 0 }}</h4>
        </div>
    </div>
    @endif

    {{-- ================= DOSEN ================= --}}
    @if(Auth::user()->role === 'dosen')
    <div class="col-md-4">
        <div class="card shadow-sm text-center p-3">
            <i class="bi bi-easel-fill fs-2 text-primary"></i>
            <h6 class="text-muted mt-2">Kelas Mengajar</h6>
            <h4 class="fw-bold">{{ $kelasMengajar ?? 0 }}</h4>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm text-center p-3">
            <i class="bi bi-journal-text fs-2 text-success"></i>
            <h6 class="text-muted mt-2">Mata Kuliah</h6>
            <h4 class="fw-bold">{{ $matakuliahDosen ?? 0 }}</h4>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm text-center p-3">
            <i class="bi bi-file-earmark-text fs-2 text-warning"></i>
            <h6 class="text-muted mt-2">Tugas Dibuat</h6>
            <h4 class="fw-bold">{{ $totalTugas ?? 0 }}</h4>
        </div>
    </div>
    @endif

    {{-- ================= MAHASISWA ================= --}}
    @if(Auth::user()->role === 'mahasiswa')
    <div class="col-md-4">
        <div class="card shadow-sm text-center p-3">
            <i class="bi bi-book-fill fs-2 text-primary"></i>
            <h6 class="text-muted mt-2">Mata Kuliah Diambil</h6>
            <h4 class="fw-bold">{{ $matakuliahDiambil ?? 0 }}</h4>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm text-center p-3">
            <i class="bi bi-file-earmark-check fs-2 text-success"></i>
            <h6 class="text-muted mt-2">Tugas Selesai</h6>
            <h4 class="fw-bold">{{ $tugasSelesai ?? 0 }}</h4>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm text-center p-3">
            <i class="bi bi-hourglass-split fs-2 text-danger"></i>
            <h6 class="text-muted mt-2">Tugas Pending</h6>
            <h4 class="fw-bold">{{ $tugasPending ?? 0 }}</h4>
        </div>
    </div>
    @endif

</div>

{{-- ===================== AKSI CEPAT ===================== --}}
<div class="row mb-4 g-3">

    @if(Auth::user()->role === 'admin')
    <div class="col-md-12">
        <a href="#" class="text-decoration-none">
            <div class="border border-primary rounded shadow-sm p-3 text-center">
                <i class="bi bi-bar-chart-fill fs-2 text-primary"></i>
                <div class="fw-bold mt-2">Laporan Akademik</div>
                <div class="text-muted small">Rekap data</div>
            </div>
        </a>
    </div>
    @endif

    @if(Auth::user()->role === 'dosen')
    <div class="col-md-12">
        <a href="#" class="text-decoration-none">
            <div class="border border-warning rounded shadow-sm p-3 text-center">
                <i class="bi bi-file-earmark-plus fs-2 text-warning"></i>
                <div class="fw-bold mt-2">Kelola Tugas</div>
                <div class="text-muted small">Menilai tugas</div>
            </div>
        </a>
    </div>
    @endif

    @if(Auth::user()->role === 'mahasiswa')
    <div class="col-md-12">
        <a href="{{ route('krs.mahasiswa.index') }}" class="text-decoration-none">
            <div class="border border-success rounded shadow-sm p-3 text-center">
                <i class="bi bi-card-checklist fs-2 text-success"></i>
                <div class="fw-bold mt-2">KRS</div>
                <div class="text-muted small">Kelola studi Anda</div>
            </div>
        </a>
    </div>
    @endif

</div>

{{-- ===================== WAKTU ===================== --}}
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
        document.getElementById('jam-digital').innerText = jam + ':' + menit + ':' + detik;
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>

@endsection