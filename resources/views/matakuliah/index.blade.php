@extends('layouts.app')

@section('page-heading')
<h4 class="fw-bold mb-0">Data Matakuliah</h4>
@endsection

@section('content')

<div class="card h-100">
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <span class="fw-semibold">Daftar Matakuliah</span>
            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                data-bs-target="#modalCreateMatakuliah">
                <i class="fa fa-plus-circle"></i> Tambah Data
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="datatable">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Kode Matakuliah</th>
                        <th class="text-center">Nama Matakuliah</th>
                        <th class="text-center">SKS</th>
                        <th class="text-center">Semester</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($matakuliahs as $matakuliah)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $matakuliah->kode_matakuliah }}</td>
                        <td>{{ $matakuliah->nama_matakuliah }}</td>
                        <td>{{ $matakuliah->sks }}</td>
                        <td>{{ $matakuliah->semester }}</td>
                        <td class="text-center">

                            <!-- TOMBOL EDIT (MODAL) -->
                            <button type="button" class="btn btn-warning btn-sm btn-edit"
                                data-kode_matakuliah="{{ $matakuliah->kode_matakuliah }}"
                                data-nama_matakuliah="{{ $matakuliah->nama_matakuliah }}"
                                data-sks="{{ $matakuliah->sks }}" data-semester="{{ $matakuliah->semester }}">
                                <i class="fa fa-edit"></i>
                            </button>

                            <!-- DELETE -->
                            <form action="{{ route('matakuliahs.destroy', $matakuliah->kode_matakuliah) }}"
                                method="POST" class="d-inline form-hapus">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa-solid fa-trash"></i>
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

<!-- Modal Create matakuliah -->
<div class="modal fade" id="modalCreateMatakuliah" tabindex="-1" aria-labelledby="modalCreateMatakuliahLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalCreateMatakuliahLabel">Tambah Matakuliah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('matakuliahs.store') }}" method="POST">
                @csrf
                <div class="modal-body">

                    <!-- Kode Matakuliah-->
                    <div class="mb-3">
                        <label class="form-label">Kode Matakuliah</label>
                        <input type="text" name="kode_matakuliah" class="form-control" placeholder="Masukkan kode"
                            required>
                    </div>

                    <!-- Nama Matakuliah -->
                    <div class="mb-3">
                        <label class="form-label">Nama Matakuliah</label>
                        <input type="text" name="nama_matakuliah" class="form-control" placeholder="Masukkan nama"
                            required>
                    </div>

                    <!-- SKS -->
                    <div class="mb-3">
                        <label class="form-label">SKS</label>
                        <input type="number" name="sks" class="form-control" placeholder="Masukkan SKS" required>
                    </div>

                    <!-- Semester -->
                    <div class="mb-3">
                        <label class="form-label">Semester</label>
                        <input type="number" name="semester" class="form-control" placeholder="Masukkan semester"
                            required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- Modal Edit matakuliah -->
<div class="modal fade" id="modalEditmatakuliah" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">Edit Matakuliah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" id="formEditmatakuliah">
                @csrf
                @method('PUT')
                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Kode Matakuliah</label>
                        <input type="text" name="kode_matakuliah" class="form-control" id="edit_kode_matakuliah"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Matakuliah</label>
                        <input type="text" name="nama_matakuliah" id="edit_nama_matakuliah" class="form-control"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">SKS</label>
                        <input type="number" name="sks" id="edit_sks" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Semester</label>
                        <input type="number" name="semester" id="edit_semester" class="form-control" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>

            </form>

        </div>
    </div>
</div>

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
    $('#datatable').DataTable();
});

    // EDIT
    $(document).on('click', '.btn-edit', function () {
        $('#edit_kode_matakuliah').val($(this).data('kode_matakuliah'));
        $('#edit_nama_matakuliah').val($(this).data('nama_matakuliah'));
        $('#edit_sks').val($(this).data('sks'));
        $('#edit_semester').val($(this).data('semester'));

        let id = $(this).data('kode_matakuliah');
        $('#formEditmatakuliah').attr('action', '/matakuliahs/' + id);

        $('#modalEditmatakuliah').modal('show');
    });

    document.querySelectorAll('.form-hapus').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: 'Data yang dihapus tidak dapat dikembalikan!',
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

@if(session('success'))
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '{{ session('success') }}',
    timer: 2000,
    showConfirmButton: false
});
@endif
</script>

@endpush