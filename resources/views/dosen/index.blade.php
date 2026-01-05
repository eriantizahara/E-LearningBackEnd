@extends('layouts.app')

@section('page-heading')
<h4 class="fw-bold mb-0">Data Dosen</h4>
@endsection

@section('content')

<div class="card h-100">
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <span class="fw-semibold">Daftar Dosen</span>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateDosen">
                <i class="fa fa-plus-circle"></i> Tambah Data
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="datatable">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">NIDN</th>
                        <th class="text-center">Nama Lengkap</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Jenis Kelamin</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dosens as $dosen)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $dosen->nidn }}</td>
                        <td>{{ $dosen->nama_lengkap }}</td>
                        <td>{{ $dosen->user->email }}</td>
                        <td>{{ $dosen->jenis_kelamin }}</td>
                        <td class="text-center">
                            <span class="badge bg-{{ $dosen->status == 'aktif' ? 'success' : 'secondary' }}">
                                {{ ucfirst($dosen->status) }}
                            </span>
                        </td>
                        <td class="text-center">

                            <button class="btn btn-warning btn-sm btn-edit" data-nidn="{{ $dosen->nidn }}"
                                data-nama="{{ $dosen->nama_lengkap }}" data-name="{{ $dosen->user->name }}"
                                data-email="{{ $dosen->user->email }}" data-jk="{{ $dosen->jenis_kelamin }}"
                                data-tempat="{{ $dosen->tempat_lahir }}" data-tanggal="{{ $dosen->tanggal_lahir }}"
                                data-alamat="{{ $dosen->alamat }}" data-hp="{{ $dosen->no_hp }}"
                                data-keahlian="{{ $dosen->keahlian }}" data-status="{{ $dosen->status }}">
                                <i class="fa fa-edit"></i>
                            </button>

                            <form action="{{ route('dosens.destroy', $dosen->nidn) }}" method="POST"
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

{{-- ================= MODAL CREATE DOSEN ================= --}}
<div class="modal fade" id="modalCreateDosen" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <form action="{{ route('dosens.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Dosen</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    {{-- DATA DOSEN --}}
                    <h6 class="fw-bold mb-3">Data Dosen</h6>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>NIDN</label>
                            <input type="text" name="nidn" class="form-control" required>
                        </div>

                        <div class="col-md-8 mb-3">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Username / Nama Akun</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required minlength="8">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select">
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>No HP</label>
                            <input type="text" name="no_hp" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Keahlian</label>
                            <input type="text" name="keahlian" class="form-control">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control"></textarea>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Status</label>
                            <select name="status" class="form-select">
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">Simpan</button>
                </div>

            </form>

        </div>
    </div>
</div>


{{-- ================= MODAL EDIT DOSEN ================= --}}
<div class="modal fade" id="modalEditDosen" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <form method="POST" id="formEditDosen">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Dosen</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    {{-- DATA DOSEN --}}
                    <h6 class="fw-bold mb-3">Data Dosen</h6>

                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label>NIDN</label>
                            <input type="text" name="nidn" id="edit_nidn" class="form-control" required>
                        </div>

                        <div class="col-md-8 mb-3">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" id="edit_nama_lengkap" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Username / Nama Akun</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Email</label>
                            <input type="email" name="email" id="edit_email" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control">
                            <small class="text-muted">Kosongkan jika tidak diubah</small>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="edit_jenis_kelamin" class="form-select">
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" id="edit_tempat_lahir" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="edit_tanggal_lahir" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>No HP</label>
                            <input type="text" name="no_hp" id="edit_no_hp" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Keahlian</label>
                            <input type="text" name="keahlian" id="edit_keahlian" class="form-control">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Alamat</label>
                            <textarea name="alamat" id="edit_alamat" class="form-control"></textarea>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Status</label>
                            <select name="status" id="edit_status" class="form-select">
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">Simpan Perubahan</button>
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

$(document).on('click', '.btn-edit', function () {

    $('#edit_nidn').val($(this).data('nidn'));
    $('#edit_nama_lengkap').val($(this).data('nama'));
    $('#edit_name').val($(this).data('name'));
    $('#edit_email').val($(this).data('email'));
    $('#edit_jenis_kelamin').val($(this).data('jk'));
    $('#edit_tempat_lahir').val($(this).data('tempat'));
    $('#edit_tanggal_lahir').val($(this).data('tanggal'));
    $('#edit_alamat').val($(this).data('alamat'));
    $('#edit_no_hp').val($(this).data('hp'));
    $('#edit_keahlian').val($(this).data('keahlian'));
    $('#edit_status').val($(this).data('status'));

    $('#formEditDosen').attr('action', '/dosens/' + $(this).data('nidn'));
    $('#modalEditDosen').modal('show');
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
            cancelButtonText: 'Batal',
            confirmButtonText: 'Hapus'
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