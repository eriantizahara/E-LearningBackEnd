@extends('layouts.app')

@section('page-heading')
<h4 class="fw-bold mb-0">Pengumpulan Tugas</h4>
@endsection

@section('content')

<div class="card h-100">
    <div class="card-body">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <span class="fw-semibold">Daftar Pengumpulan Tugas</span>
        </div>

        {{-- ALERT --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- FILTER --}}
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-6">
                <label>Kelas</label>
                <select name="kelas_kode" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelasList as $kelas)
                    <option value="{{ $kelas->kode_kelas }}" {{ ($selectedKelas==$kelas->kode_kelas)?'selected':'' }}>
                        {{ $kelas->kode_kelas }} - {{ $kelas->matakuliah->nama_matakuliah }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label>Mahasiswa</label>
                <select name="mahasiswa_nobp" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Pilih Mahasiswa --</option>
                    @foreach($mahasiswaList as $m)
                    <option value="{{ $m->nobp }}" {{ ($selectedMahasiswa==$m->nobp)?'selected':'' }}>
                        {{ $m->nobp }} - {{ $m->nama_lengkap }}
                    </option>
                    @endforeach
                </select>
            </div>
        </form>

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="datatable">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Mahasiswa</th>
                        <th class="text-center">Judul Tugas</th>
                        <th class="text-center">File Jawaban</th>
                        <th class="text-center">Nilai</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jawabanList as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->mahasiswa->nobp }} - {{ $item->mahasiswa->nama_lengkap }}</td>
                        <td>{{ $item->tugas->judul }}</td>
                        <td class="text-center">
                            @if($item->upload_file_jawaban)
                            <a href="{{ asset('storage/jawaban/'.$item->upload_file_jawaban) }}" 
                               class="btn btn-outline-primary btn-sm" target="_blank">
                                <i class="fa fa-eye"></i>
                            </a>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">{{ $item->nilai ?? '-' }}</td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm btn-edit"
                                data-id="{{ $item->id }}"
                                data-nilai="{{ $item->nilai }}">
                                <i class="fa fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

{{-- MODAL EDIT NILAI --}}
<div class="modal fade" id="modalEditNilai" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" id="formEditNilai">
            @csrf
            @method('PUT')
            <input type="hidden" name="kelas_kode" value="{{ $selectedKelas }}">
            <input type="hidden" name="mahasiswa_nobp" value="{{ $selectedMahasiswa }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Nilai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label>Nilai</label>
                    <input type="number" name="nilai" id="edit_nilai" class="form-control" min="0" max="100" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {
    $('#datatable').DataTable();
});

// Edit nilai
$(document).on('click', '.btn-edit', function () {
    var id = $(this).data('id');
    var nilai = $(this).data('nilai');
    $('#edit_nilai').val(nilai);
    $('#formEditNilai').attr('action', '/pengumpulan-tugas/' + id);
    $('#modalEditNilai').modal('show');
});
</script>
@endpush
