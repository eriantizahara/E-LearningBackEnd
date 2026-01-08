@extends('layouts.app')

@section('page-heading')
<h4 class="fw-bold mb-0">Manajemen Modul</h4>
@endsection

@section('content')
<div class="card h-100">
    <div class="card-body">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <span class="fw-semibold">Daftar Modul</span>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateModul">
                <i class="fa fa-plus-circle"></i> Tambah Modul
            </button>
        </div>

        {{-- ALERT --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="datatable">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Kode Kelas</th>
                        <th class="text-center">Mata Kuliah</th>
                        <th class="text-center">Judul Modul</th>
                        <th class="text-center">File</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($moduls as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->kelas_kode }}</td>
                        <td>{{ $item->kelas->matakuliah->nama_matakuliah ?? '-' }}</td>
                        <td>{{ $item->judul }}</td>
                        <td class="text-center">
                            @if($item->file_modul)
                            <a href="{{ asset('storage/moduls/'.$item->file_modul) }}"
                                class="btn btn-outline-primary btn-sm" target="_blank">
                                <i class="fa fa-eye"></i>
                            </a>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <!-- EDIT -->
                            <button class="btn btn-warning btn-sm btn-edit" data-id="{{ $item->id }}"
                                data-kelas="{{ $item->kelas_kode }}" data-judul="{{ $item->judul }}">
                                <i class="fa fa-edit"></i>
                            </button>

                            <!-- DELETE -->
                            <form action="{{ route('moduls.destroy', $item->id) }}" method="POST"
                                class="d-inline form-hapus">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i>
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
@endsection


{{-- MODAL CREATE --}}
<div class="modal fade" id="modalCreateModul" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form action="{{ route('moduls.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Modul</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label>Kelas</label>
                            <select name="kelas_kode" class="form-select" required>
                                @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->kode_kelas }}">
                                    {{ $kelas->kode_kelas }} - {{ $kelas->matakuliah->nama_matakuliah }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Judul Modul</label>
                            <input type="text" name="judul" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>File Modul (Opsional)</label>
                            <input type="file" name="file_modul" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div class="modal fade" id="modalEditModul" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form method="POST" id="formEditModul" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Modul</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label>Kelas</label>
                            <select name="kelas_kode" id="edit_kelas" class="form-select" required>
                                @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->kode_kelas }}">
                                    {{ $kelas->kode_kelas }} - {{ $kelas->matakuliah->nama_matakuliah }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Judul Modul</label>
                            <input type="text" name="judul" id="edit_judul" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Ganti File (Opsional)</label>
                            <input type="file" name="file_modul" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
    $('#datatable').DataTable();
});

$(document).on('click', '.btn-edit', function () {
    $('#edit_kelas').val($(this).data('kelas'));
    $('#edit_judul').val($(this).data('judul'));

    $('#formEditModul').attr('action', '/moduls/' + $(this).data('id'));
    $('#modalEditModul').modal('show');
});

document.querySelectorAll('.form-hapus').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
});
</script>
@endpush