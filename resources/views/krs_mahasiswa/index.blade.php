@extends('layouts.app')

@section('page-heading')
<h4 class="fw-bold mb-0">Kartu Rencana Studi (KRS)</h4>
@endsection

@section('content')

{{-- ================= DATA MAHASISWA ================= --}}
@if($krs)
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3">

            <div class="col-md-3">
                <small class="text-muted">NOBP</small>
                <div class="fw-semibold">{{ $krs->mahasiswa->nobp }}</div>
            </div>

            <div class="col-md-4">
                <small class="text-muted">Nama Mahasiswa</small>
                <div class="fw-semibold">{{ $krs->mahasiswa->nama_lengkap }}</div>
            </div>

            <div class="col-md-3">
                <small class="text-muted">Program Studi</small>
                <div class="fw-semibold">
                    {{ $krs->mahasiswa->prodi ?? '-' }}
                </div>
            </div>

            {{-- @php
            $angkatan = $krs->mahasiswa->angkatan;

            $tahun = \Carbon\Carbon::now()->year; // 2026
            $bulan = \Carbon\Carbon::now()->month; // 1 (Januari)

            // Tahun ajaran
            $tahunAjaran = ($bulan >= 9) ? $tahun : $tahun - 1;

            $semester = ($tahunAjaran - $angkatan) * 2;

            // Ganjil: Sep–Feb
            if ($bulan >= 9 || $bulan <= 2) { $semester +=1; } @endphp --}} <div class="col-md-2">
                <small class="text-muted">Semester</small>
                <div class="fw-semibold" id="semester-aktif" data-angkatan="{{ $krs->mahasiswa->angkatan }}">
                    -
                </div>
        </div>

    </div>
</div>
</div>
@endif

{{-- ================= KRS ================= --}}
<div class="card">
    <div class="card-body">

        {{-- ===== HEADER ===== --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <strong>Status KRS :</strong>

                @if(!$krs)
                <span class="badge bg-secondary">-</span>

                @elseif($krs->status === 'approved')
                <span class="badge bg-success">Approved</span>

                @elseif($krs->status === 'pending')
                <span class="badge bg-warning text-dark">Pending</span>

                @else
                <span class="badge bg-secondary">-</span>
                @endif
            </div>


            @if(!$krs || $krs->status === 'pending')
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalPilihKelas">
                <i class="fa fa-plus-circle"></i> Tambah Kelas
            </button>
            @endif
        </div>

        {{-- ===== ALERT ===== --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- ===== TABEL KRS ===== --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="datatable">
                <thead class="table-light">
                    <tr class="text-center align-middle">
                        <th class="text-center">No</th>
                        <th class="text-center">Kode Kelas</th>
                        <th class="text-center">Mata Kuliah</th>
                        <th class="text-center">SKS</th>
                        <th class="text-center">Dosen</th>
                        <th class="text-center">Ruang</th>
                        <th class="text-center">Hari</th>
                        <th class="text-center">Jam</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @php $totalSks = 0; @endphp

                    @if($krs && $krs->detailKrs && $krs->detailKrs->count() > 0)

                    @foreach($krs->detailKrs as $item)
                    @php
                    $totalSks += $item->kelas->matakuliah->sks;
                    @endphp
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->kelas->kode_kelas }}</td>
                        <td>{{ $item->kelas->matakuliah->nama_matakuliah }}</td>
                        <td class="text-center">{{ $item->kelas->matakuliah->sks }}</td>
                        <td>{{ $item->kelas->dosen->nama_lengkap }}</td>
                        <td class="text-center">{{ $item->kelas->ruang }}</td>
                        <td class="text-center">{{ $item->kelas->hari }}</td>
                        <td class="text-center">
                            {{ $item->kelas->jam_mulai }} - {{ $item->kelas->jam_selesai }}
                        </td>
                        <td class="text-center">
                            @if($krs->status === 'pending')
                            <form action="{{ route('krs.mahasiswa.detail.destroy', $item->id) }}" method="POST"
                                onsubmit="return confirm('Hapus kelas ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach

                    @endif

                </tbody>

                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total SKS</th>
                        <th class="text-center">{{ $totalSks }}</th>
                        <th colspan="5"></th>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>
</div>

@endsection

{{-- ================= MODAL PILIH KELAS ================= --}}
<div class="modal fade" id="modalPilihKelas" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">Pilih Kelas Mata Kuliah</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="datatableKelas">
                        <thead class="table-light">
                            <tr class="text-center align-middle">
                                <th class="text-center">Kode</th>
                                <th class="text-center">Mata Kuliah</th>
                                <th class="text-center">SKS</th>
                                <th class="text-center">Dosen</th>
                                <th class="text-center">Ruang</th>
                                <th class="text-center">Hari</th>
                                <th class="text-center">Jam</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kelasList as $kelas)
                            <tr>
                                <td>{{ $kelas->kode_kelas }}</td>
                                <td>{{ $kelas->matakuliah->nama_matakuliah }}</td>
                                <td class="text-center">{{ $kelas->matakuliah->sks }}</td>
                                <td>{{ $kelas->dosen->nama_lengkap }}</td>
                                <td class="text-center">{{ $kelas->ruang }}</td>
                                <td class="text-center">{{ $kelas->hari }}</td>
                                <td class="text-center">
                                    {{ $kelas->jam_mulai }} - {{ $kelas->jam_selesai }}
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('krs.mahasiswa.detail.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="kelas_kode" value="{{ $kelas->kode_kelas }}">
                                        <button class="btn btn-success btn-sm">
                                            <i class="fa fa-check"></i> Pilih
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        $('#datatable').DataTable();
        $('#datatableKelas').DataTable();
    });

     // ===============================
        // HITUNG SEMESTER AKTIF
        // ===============================
        const semesterEl = document.getElementById('semester-aktif');

        if (semesterEl) {
            const angkatan = parseInt(semesterEl.dataset.angkatan);

            const now = new Date();
            const tahun = now.getFullYear();   // 2026
            const bulan = now.getMonth() + 1;  // JS: Januari = 0

            // Tahun ajaran (mulai September)
            const tahunAjaran = (bulan >= 9) ? tahun : tahun - 1;

            let semester = (tahunAjaran - angkatan) * 2;

            // Semester ganjil: Sep–Feb
            if (bulan >= 9 || bulan <= 2) {
                semester += 1;
            }

            semesterEl.textContent = semester;
        }

</script>
@endpush