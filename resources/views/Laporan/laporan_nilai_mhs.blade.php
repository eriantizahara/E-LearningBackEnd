@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h4 class="fw-bold">Laporan Nilai Mahasiswa</h4>
    </div>

    {{-- FILTER --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('laporan.nilai') }}">
                <div class="row g-3">

                    {{-- KELAS --}}
                    <div class="col-md-4">
                        <label class="form-label">Kelas</label>
                        <select name="kelas" class="form-select">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($kelas as $k)
                            <option value="{{ $k->kode_kelas }}" {{ request('kelas')==$k->kode_kelas ? 'selected' : ''
                                }}>
                                {{ $k->kode_kelas }} - {{ $k->matakuliah->nama_matakuliah ?? '-' }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- TUGAS --}}
                    <div class="col-md-4">
                        <label class="form-label">Tugas</label>
                        <select name="tugas" class="form-select">
                            <option value="">-- Pilih Tugas --</option>
                            @foreach ($tugas as $t)
                            <option value="{{ $t->kode_tugas }}" {{ request('tugas')==$t->kode_tugas ? 'selected' : ''
                                }}>
                                {{ $t->kode_tugas }} - {{ $t->judul }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- BUTTON --}}
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fa fa-filter me-1"></i> Filter
                        </button>

                        <a href="{{ route('laporan.nilai') }}" class="btn btn-secondary">
                            <i class="fa fa-refresh me-1"></i> Reset
                        </a>

                        <a href="{{ route('laporan.nilai.pdf', request()->query()) }}" class="btn btn-danger ms-2"
                            target="_blank">
                            <i class="fa fa-file-pdf"></i> PDF
                        </a>

                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- TABEL --}}
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped align-middle" id="datatable-nilai">
                <thead class="table-light text-center">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Kelas</th>
                        <th class="text-center">Mahasiswa</th>
                        <th class="text-center">Tugas</th>
                        <th class="text-center">Nilai</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Tanggal</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($pengumpulan as $row)
                    <tr>
                        <td class="text-center">
                            {{ $pengumpulan->firstItem() + $loop->index }}
                        </td>
                        <td>{{ $row->tugas->kelas->kode_kelas ?? '-' }}</td>
                        <td>{{ $row->mahasiswa->nobp ?? '-' }} - {{ $row->mahasiswa->nama_lengkap ?? '-' }}</td>
                        <td>{{ $row->tugas->judul ?? '-' }}</td>
                        <td class="text-center fw-bold">{{ $row->nilai ?? '-' }}</td>
                        <td class="text-center">
                            @if ($row->nilai)
                            <span class="badge bg-success">Sudah Dinilai</span>
                            @else
                            <span class="badge bg-warning text-dark">Belum Dinilai</span>
                            @endif
                        </td>
                        <td class="text-center">{{ $row->created_at->format('d-m-Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- PAGINATION --}}
            <div class="mt-3">
                {{ $pengumpulan->withQueryString()->links() }}
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        $('#datatable-nilai').DataTable({
            "paging": false,
            "info": false,
            "searching": true
        });
    });
</script>
@endpush