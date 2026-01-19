@extends('layouts.app')

@section('page-heading')
<div class="card akun-header shadow-sm">
    <div class="card-body d-flex align-items-center gap-3">
        <i class="bi bi-person-lock fs-10"></i>
        <div>
            <h4 class="fw-bold mb-0">My Account</h4>
            <small class="opacity-75">Akun & keamanan</small>
        </div>
    </div>
</div>
@endsection

@section('content')

<style>
    /* ================= HEADER ================= */
    .akun-header {
        background: linear-gradient(135deg, #cfe2ff, #e7f1ff);
        color: #1e3a8a;
        border: none;
        border-radius: 18px;
    }

    /* ================= CARD ================= */
    .akun-card {
        border-radius: 18px;
        border: none;
        background: linear-gradient(135deg, #ffffff, #f8fafc);
        transition: .3s ease;
    }

    .akun-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 35px rgba(99, 102, 241, .12);
    }

    /* ================= TEXT ================= */
    .akun-card p {
        margin-bottom: .6rem;
        color: #334155;
    }

    .akun-card strong {
        font-weight: 600;
        color: #475569;
    }

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

    /* ================= BADGE ================= */
    .badge {
        border-radius: 10px;
        font-weight: 500;
        padding: .4em .75em;
    }

    /* ================= BUTTON ================= */
    .btn-outline-danger {
        border-radius: 12px;
        padding: .35rem .9rem;
        transition: .25s;
    }

    .btn-outline-danger:hover {
        transform: translateY(-2px);
    }

    /* ================= ICON ================= */
    /* .akun-card i {
        background: rgba(99, 102, 241, .12);
        padding: 10px;
        border-radius: 50%;
    } */
</style>

{{-- ALERT PESAN --}}
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row g-1">

    {{-- ================= DATA AKUN ================= --}}

    <div class="col-md-12">
        <div class="card shadow-sm akun-card">
            <div class="card-body">
                <h6 class="fw-bold text-primary mb-3">
                    <i class="bi bi-person-circle me-2"></i>Informasi Akun
                </h6>

                <div class="mb-3">
                    <div class="label">Nama Pengguna / Username</div>
                    <div class="value">{{ $user->name }}</div>
                </div>

                <div class="mb-3">
                    <div class="label">Email</div>
                    <div class="value">{{ $user->email }}</div>
                </div>

                <div class="mb-3">
                    <div class="label">Status</div>
                    <span class="badge bg-secondary text-uppercase">
                        {{ $user->role }}
                    </span>
                </div>

                <div class="mb-3">
                    <div class="label">Bergabung</div>
                    <div class="value">{{ $user->created_at->translatedFormat('d F Y') }}</div>
                </div>

                {{-- <p><strong>Nama:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p>
                    <strong>Role:</strong>
                    <span class="badge bg-secondary text-uppercase">
                        {{ $user->role }}
                    </span>
                </p>
                <p>
                    <strong>Bergabung:</strong>
                    {{ $user->created_at->translatedFormat('d F Y') }}
                </p> --}}
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card shadow-sm akun-card">
            <div class="card-body">
                <h6 class="fw-bold text-danger mb-3">
                    <i class="bi bi-shield-lock me-2"></i>Keamanan
                </h6>

                <p>Password : ••••••••</p>

                <a href="#" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                    data-bs-target="#modalGantiPassword">
                    <i class="bi bi-key me-1"></i>Ganti Password
                </a>

            </div>
        </div>
    </div>

</div>
@endsection

<!-- ================= MODAL GANTI PASSWORD ================= -->
<div class="modal fade" id="modalGantiPassword" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">

            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-shield-lock me-2 text-danger"></i>Ganti Password
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('akun.password.update') }}" method="POST">
                @csrf

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Password Lama</label>
                        <input type="password" name="password_lama" class="form-control rounded-3" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="password_baru" class="form-control rounded-3" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_baru_confirmation" class="form-control rounded-3"
                            required>
                    </div>

                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-check-circle me-1"></i>Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>