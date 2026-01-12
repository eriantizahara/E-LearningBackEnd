@extends('layouts.app')

@section('page-heading')
<div class="card profile-header shadow-sm">
    <div class="card-body d-flex align-items-center gap-3">
        <i class="bi bi-person-circle fs-10"></i>
        <div>
            <h4 class="fw-bold mb-0">My Profile</h4>
            <small class="opacity-75">Informasi identitas pengguna</small>
        </div>
    </div>
</div>
@endsection

@section('content')

<style>
    /* ===== HEADER ===== */
    .profile-header {
        background: linear-gradient(135deg, #cfe2ff, #e7f1ff);
        color: #1e3a8a;
        border: none;
        border-radius: 18px;
    }

    /* ===== CARD ===== */
    .profile-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #eef2f7;
        transition: .3s ease;
    }

    .profile-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 35px rgba(99, 102, 241, 0.12);
    }

    /* ===== TEXT ===== */
    .label {
        font-size: .8rem;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: .03em;
    }

    .value {
        font-weight: 600;
        color: #1f2937;
    }

    /* ===== ICON COLOR SOFT ===== */
    .bi-person-circle {
        color: #6366f1;
    }

    /* ===== BADGE PASTEL ===== */
    .badge.bg-primary {
        background-color: #dbeafe !important;
        color: #1e40af;
        font-weight: 600;
    }

    .badge.bg-success {
        background-color: #dcfce7 !important;
        color: #166534;
        font-weight: 600;
    }

    .badge.bg-warning {
        background-color: #fef3c7 !important;
        color: #92400e;
        font-weight: 600;
    }

    .badge.bg-secondary {
        background-color: #f1f5f9 !important;
        color: #475569;
        font-weight: 600;
    }

    /* ===== SECTION TITLES ===== */
    h6.text-primary {
        color: #2e46f7 !important;
    }

    h6.text-success {
        color: #22c55e !important;
    }

    h6.text-warning {
        color: #f59e0b !important;
    }

    /* ===== SPACING IMPROVEMENT ===== */
    .card-body .row>div {
        padding-top: 4px;
        padding-bottom: 4px;
    }
</style>


<div class="row g-1">

    {{-- ================= DATA AKUN ================= --}}
    <div class="col-md-12">
        <div class="card shadow-sm profile-card">
            <div class="card-body">
                <h6 class="fw-bold text-primary mb-3">
                    <i class="bi bi-shield-lock me-2"></i>Informasi Akun
                </h6>

                <div class="mb-3">
                    <div class="label">Nama Pengguna</div>
                    <div class="value">{{ $user->name }}</div>
                </div>

                <div class="mb-3">
                    <div class="label">Email</div>
                    <div class="value">{{ $user->email }}</div>
                </div>

                <div>
                    <div class="label">Status</div>
                    <span class="badge bg-primary text-uppercase">
                        {{ $user->role }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= DATA MAHASISWA ================= --}}
    @if($user->role === 'mahasiswa' && $mahasiswa)
    <div class="col-md-12">
        <div class="card shadow-sm profile-card">
            <div class="card-body">
                <h6 class="fw-bold text-success mb-3">
                    <i class="bi bi-mortarboard me-2"></i>Data Mahasiswa
                </h6>

                <div class="row">
                    <div class="col-6 mb-3">
                        <div class="label">NIM</div>
                        <div class="value">{{ $mahasiswa->nobp }}</div>
                    </div>

                    <div class="col-6 mb-3">
                        <div class="label">Nama Lengkap</div>
                        <div class="value">{{ $mahasiswa->nama_lengkap }}</div>
                    </div>

                    <div class="col-6 mb-3">
                        <div class="label">Jenis Kelamin</div>
                        <div class="value">{{ $mahasiswa->jenis_kelamin }}</div>
                    </div>

                    <div class="col-6 mb-3">
                        <div class="label">Program Studi</div>
                        <div class="value">{{ $mahasiswa->prodi }}</div>
                    </div>

                    <div class="col-6 mb-3">
                        <div class="label">Tempat Lahir</div>
                        <div class="value">
                            {{ $mahasiswa->tempat_lahir ?? '-' }}
                        </div>
                    </div>

                    <div class="col-6 mb-3">
                        <div class="label">Tanggal Lahir</div>
                        <div class="value">
                            {{ $mahasiswa->tanggal_lahir
                            ? \Carbon\Carbon::parse($mahasiswa->tanggal_lahir)->translatedFormat('d F Y')
                            : '-' }}
                        </div>
                    </div>

                    <div class="col-6 mb-3">
                        <div class="label">Angkatan</div>
                        <div class="value">{{ $mahasiswa->angkatan }}</div>
                    </div>

                    <div class="col-6 mb-3">
                        <div class="label">Status</div>
                        <span class="badge 
                            @if($mahasiswa->status === 'aktif') bg-success
                            @elseif($mahasiswa->status === 'cuti') bg-warning text-dark
                            @else bg-secondary @endif">
                            {{ ucfirst($mahasiswa->status) }}
                        </span>
                    </div>

                    <div class="col-6 mb-3">
                        <div class="label">No HP</div>
                        <div class="value">{{ $mahasiswa->no_hp ?? '-' }}</div>
                    </div>

                    <div class="col-12">
                        <div class="label">Alamat</div>
                        <div class="value">{{ $mahasiswa->alamat ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ================= DATA DOSEN ================= --}}
    @if($user->role === 'dosen' && $dosen)
    <div class="col-md-12">
        <div class="card shadow-sm profile-card">
            <div class="card-body">
                <h6 class="fw-bold text-warning mb-3">
                    <i class="bi bi-person-badge me-2"></i>Data Dosen
                </h6>

                <div class="row">
                    <div class="col-6 mb-3">
                        <div class="label">NIDN</div>
                        <div class="value">{{ $dosen->nidn }}</div>
                    </div>

                    <div class="col-6 mb-3">
                        <div class="label">Nama Lengkap</div>
                        <div class="value">{{ $dosen->nama_lengkap }}</div>
                    </div>

                    <div class="col-6 mb-3">
                        <div class="label">Jenis Kelamin</div>
                        <div class="value">{{ $dosen->jenis_kelamin }}</div>
                    </div>

                    <div class="col-6 mb-3">
                        <div class="label">Keahlian</div>
                        <div class="value">{{ $dosen->keahlian ?? '-' }}</div>
                    </div>

                    <div class="col-6 mb-3">
                        <div class="label">Tempat Lahir</div>
                        <div class="value">{{ $dosen->tempat_lahir ?? '-' }}</div>
                    </div>

                    <div class="col-6 mb-3">
                        <div class="label">Tanggal Lahir</div>
                        <div class="value">
                            {{ $dosen->tanggal_lahir
                            ? \Carbon\Carbon::parse($dosen->tanggal_lahir)->translatedFormat('d F Y')
                            : '-' }}
                        </div>
                    </div>

                    <div class="col-6 mb-3">
                        <div class="label">No HP</div>
                        <div class="value">{{ $dosen->no_hp ?? '-' }}</div>
                    </div>

                    <div class="col-6 mb-3">
                        <div class="label">Status</div>
                        <span class="badge 
                        @if($dosen->status === 'aktif') bg-success
                        @else bg-secondary @endif">
                            {{ ucfirst($dosen->status) }}
                        </span>
                    </div>

                    <div class="col-12">
                        <div class="label">Alamat</div>
                        <div class="value">{{ $dosen->alamat ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif


</div>

@endsection