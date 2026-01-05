@extends('layouts.app')

@section('page-heading')
<h4 class="fw-bold mb-0">Data Mahasiswa</h4>
@endsection

@section('content')

<div class="card h-100">
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <span class="fw-semibold">Daftar Mahasiswa</span>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateMahasiswa">
                <i class="fa fa-plus-circle"></i> Tambah Data
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="datatable">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">NoBP</th>
                        <th class="text-center">Nama Lengkap</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Jenis Kelamin</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mahasiswas as $mahasiswa)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $mahasiswa->nobp }}</td>
                        <td>{{ $mahasiswa->nama_lengkap }}</td>
                        <td>{{ $mahasiswa->user->email }}</td>
                        <td>{{ $mahasiswa->jenis_kelamin }}</td>
                        <td class="text-center">
                            @php
                            $statusColors = [
                            'aktif' => 'success', // hijau
                            'cuti' => 'warning', // kuning
                            'lulus' => 'primary', // biru
                            ];
                            @endphp

                            <span class="badge bg-{{ $statusColors[$mahasiswa->status] ?? 'secondary' }}">
                                {{ ucfirst($mahasiswa->status) }}
                            </span>

                        </td>
                        <td class="text-center">

                            <button class="btn btn-warning btn-sm btn-edit" data-nobp="{{ $mahasiswa->nobp }}"
                                data-nama="{{ $mahasiswa->nama_lengkap }}" data-name="{{ $mahasiswa->user->name }}"
                                data-email="{{ $mahasiswa->user->email }}" data-jk="{{ $mahasiswa->jenis_kelamin }}"
                                data-tempat="{{ $mahasiswa->tempat_lahir }}"
                                data-tanggal="{{ $mahasiswa->tanggal_lahir }}" data-alamat="{{ $mahasiswa->alamat }}"
                                data-hp="{{ $mahasiswa->no_hp }}" data-prodi="{{ $mahasiswa->prodi }}"
                                data-angkatan="{{ $mahasiswa->angkatan }}" data-status="{{ $mahasiswa->status }}">
                                <i class="fa fa-edit"></i>
                            </button>

                            <form action="{{ route('mahasiswas.destroy', $mahasiswa->nobp) }}" method="POST"
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

{{-- ================= MODAL CREATE MAHASISWA ================= --}}
<div class="modal fade" id="modalCreateMahasiswa" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <form action="{{ route('mahasiswas.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Mahasiswa</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    {{-- DATA MAHASISWA --}}
                    <h6 class="fw-bold mb-3">Data Mahasiswa</h6>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>NoBP</label>
                            <input type="text" name="nobp" class="form-control" required>
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

                        <div class="col-md-4 mb-3">
                            <label>No HP</label>
                            <input type="text" name="no_hp" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Prodi</label>
                            <input type="text" name="prodi" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Angkatan</label>
                            <input type="text" name="angkatan" class="form-control">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control"></textarea>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Status</label>
                            <select name="status" class="form-select">
                                <option value="aktif">Aktif</option>
                                <option value="cuti">Cuti</option>
                                <option value="lulus">Lulus</option>
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


{{-- ================= MODAL EDIT MAHASISWA ================= --}}
<div class="modal fade" id="modalEditMahasiswa" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <form method="POST" id="formEditMahasiswa">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Mahasiswa</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    {{-- DATA MAHASISWA --}}
                    <h6 class="fw-bold mb-3">Data Mahasiswa</h6>

                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label>NoBP</label>
                            <input type="text" name="nobp" id="edit_nobp" class="form-control" required>
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

                        <div class="col-md-4 mb-3">
                            <label>No HP</label>
                            <input type="text" name="no_hp" id="edit_no_hp" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Prodi</label>
                            <input type="text" name="prodi" id="edit_prodi" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Angkatan</label>
                            <input type="text" name="angkatan" id="edit_angkatan" class="form-control">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Alamat</label>
                            <textarea name="alamat" id="edit_alamat" class="form-control"></textarea>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Status</label>
                            <select name="status" id="edit_status" class="form-select">
                                <option value="aktif">Aktif</option>
                                <option value="cuti">Cuti</option>
                                <option value="lulus">Lulus</option>
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

    $('#edit_nobp').val($(this).data('nobp'));
    $('#edit_nama_lengkap').val($(this).data('nama'));
    $('#edit_name').val($(this).data('name'));
    $('#edit_email').val($(this).data('email'));
    $('#edit_jenis_kelamin').val($(this).data('jk'));
    $('#edit_tempat_lahir').val($(this).data('tempat'));
    $('#edit_tanggal_lahir').val($(this).data('tanggal'));
    $('#edit_alamat').val($(this).data('alamat'));
    $('#edit_no_hp').val($(this).data('hp'));
    $('#edit_prodi').val($(this).data('prodi'));
    $('#edit_angkatan').val($(this).data('angkatan'));
    $('#edit_status').val($(this).data('status'));

    $('#formEditMahasiswa').attr('action', '/mahasiswas/' + $(this).data('nobp'));
    $('#modalEditMahasiswa').modal('show');
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