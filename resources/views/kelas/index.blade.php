@extends('layouts.app')

@section('page-heading')
<h4 class="fw-bold mb-0">Data Kelas</h4>
@endsection

@section('content')

<div class="card h-100">
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <span class="fw-semibold">Daftar Kelas</span>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateKelas">
                <i class="fa fa-plus-circle"></i> Tambah Data
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="datatable">
                <thead class="table-light">
                    <tr>
                        <th class="text-center align-middle">No</th>
                        <th class="text-center align-middle">Kode Kelas</th>
                        <th class="text-center align-middle">Mata Kuliah</th>
                        <th class="text-center align-middle">SMT</th>
                        <th class="text-center align-middle">Dosen</th>
                        <th class="text-center align-middle">Hari</th>
                        <th class="text-center align-middle">Jam</th>
                        <th class="text-center align-middle">Ruang</th>
                        <th class="text-center align-middle">Kapasitas</th>
                        <th class="text-center align-middle">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kelas as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->kode_kelas }}</td>
                        <td>{{ $item->matakuliah->nama_matakuliah }}</td>
                        <td>{{ $item->matakuliah->semester }}</td>
                        <td>{{ $item->dosen->nama_lengkap }}</td>
                        <td>{{ $item->hari }}</td>
                        <td>{{ $item->jam_mulai }} - {{ $item->jam_selesai }}</td>
                        <td>{{ $item->ruang }}</td>
                        <td class="text-center">{{ $item->kapasitas }}</td>
                        <td class="text-center">

                            <!-- EDIT -->
                            <button class="btn btn-warning btn-sm btn-edit" data-kode="{{ $item->kode_kelas }}"
                                data-mk="{{ $item->matakuliah_kode }}"
                                data-nama-mk="{{ $item->matakuliah->nama_matakuliah }}"
                                data-dosen="{{ $item->dosen_nidn }}" data-nama-dosen="{{ $item->dosen->nama_lengkap }}"
                                data-hari="{{ $item->hari }}" data-mulai="{{ $item->jam_mulai }}"
                                data-selesai="{{ $item->jam_selesai }}" data-ruang="{{ $item->ruang }}"
                                data-kapasitas="{{ $item->kapasitas }}">
                                <i class="fa fa-edit"></i>
                            </button>

                            <!-- DELETE -->
                            <form action="{{ route('kelas.destroy', $item->kode_kelas) }}" method="POST"
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

<div class="modal fade" id="modalCreateKelas" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <form action="{{ route('kelas.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label>Kode Kelas</label>
                            <input type="text" name="kode_kelas" class="form-control" required>
                        </div>

                        <div class="col-md-8 mb-3">
                            <label>Mata Kuliah</label>
                            <div class="input-group">
                                <input type="text" id="matkul_nama" class="form-control" placeholder="Pilih Mata Kuliah"
                                    readonly>
                                <input type="hidden" name="matakuliah_kode" id="matkul_kode">
                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                    data-bs-target="#modalSelectMatkul">Pilih</button>
                            </div>
                        </div>


                        <div class="col-md-6 mb-3">
                            <label>Dosen</label>
                            <div class="input-group">
                                <input type="text" id="dosen_nama" class="form-control" placeholder="Pilih Dosen"
                                    readonly>
                                <input type="hidden" name="dosen_nidn" id="dosen_nidn">
                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                    data-bs-target="#modalSelectDosen">
                                    Pilih
                                </button>
                            </div>
                        </div>


                        <div class="col-md-3 mb-3">
                            <label>Hari</label>
                            <input type="text" name="hari" class="form-control" required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Ruang</label>
                            <input type="text" name="ruang" class="form-control" required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Jam Mulai</label>
                            <input type="time" name="jam_mulai" class="form-control" required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Jam Selesai</label>
                            <input type="time" name="jam_selesai" class="form-control" required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Kapasitas</label>
                            <input type="number" name="kapasitas" class="form-control" required>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">Simpan</button>
                </div>

            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="modalEditKelas" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <form method="POST" id="formEditKelas">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">

                        <!-- KODE KELAS -->
                        <div class="col-md-4 mb-3">
                            <label>Kode Kelas</label>
                            <input type="text" id="edit_kode_kelas" name="kode_kelas" class="form-control" required>
                        </div>

                        <!-- Mata Kuliah -->
                        <div class="col-md-8 mb-3">
                            <label>Mata Kuliah</label>
                            <div class="input-group">
                                <input type="text" id="edit_matkul_nama" class="form-control" readonly>
                                <input type="hidden" name="matakuliah_kode" id="edit_matkul_kode">
                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                    data-bs-target="#modalSelectMatkulEdit">Pilih</button>
                            </div>
                        </div>

                        <!-- DOSEN -->
                        <div class="col-md-6 mb-3">
                            <label>Dosen</label>
                            <div class="input-group">
                                <input type="text" id="edit_dosen_nama" class="form-control" readonly>
                                <input type="hidden" name="dosen_nidn" id="edit_dosen_nidn">
                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                    data-bs-target="#modalSelectDosenEdit">
                                    Pilih
                                </button>
                            </div>
                        </div>

                        <!-- HARI -->
                        <div class="col-md-3 mb-3">
                            <label>Hari</label>
                            <input type="text" id="edit_hari" name="hari" class="form-control">
                        </div>

                        <!-- RUANG -->
                        <div class="col-md-3 mb-3">
                            <label>Ruang</label>
                            <input type="text" id="edit_ruang" name="ruang" class="form-control">
                        </div>

                        <!-- JAM MULAI -->
                        <div class="col-md-3 mb-3">
                            <label>Jam Mulai</label>
                            <input type="time" id="edit_mulai" name="jam_mulai" class="form-control">
                        </div>

                        <!-- JAM SELESAI -->
                        <div class="col-md-3 mb-3">
                            <label>Jam Selesai</label>
                            <input type="time" id="edit_selesai" name="jam_selesai" class="form-control">
                        </div>

                        <!-- KAPASITAS -->
                        <div class="col-md-3 mb-3">
                            <label>Kapasitas</label>
                            <input type="number" id="edit_kapasitas" name="kapasitas" class="form-control">
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">Simpan Perubahan</button>
                </div>

            </form>

        </div>
    </div>
</div>


<div class="modal fade" id="modalSelectMatkul" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Pilih Mata Kuliah</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped" id="datatableMatkul">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Semester</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($matakuliahs as $mk)
                        <tr>
                            <td>{{ $mk->kode_matakuliah }}</td>
                            <td>{{ $mk->nama_matakuliah }}</td>
                            <td>{{ $mk->sks }}</td>
                            <td>{{ $mk->semester }}</td>
                            <td>
                                <button class="btn btn-primary btn-select-mk" data-kode="{{ $mk->kode_matakuliah }}"
                                    data-nama="{{ $mk->nama_matakuliah }}" data-sks="{{ $mk->sks }}"
                                    data-semester="{{ $mk->semester }}">Pilih</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalSelectMatkulEdit" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Pilih Mata Kuliah</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped" id="datatableMatkulEdit">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Semester</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($matakuliahs as $mk)
                        <tr>
                            <td>{{ $mk->kode_matakuliah }}</td>
                            <td>{{ $mk->nama_matakuliah }}</td>
                            <td>{{ $mk->sks }}</td>
                            <td>{{ $mk->semester }}</td>
                            <td>
                                <button class="btn btn-primary btn-select-mk-edit"
                                    data-kode="{{ $mk->kode_matakuliah }}" data-nama="{{ $mk->nama_matakuliah }}"
                                    data-sks="{{ $mk->sks }}" data-semester="{{ $mk->semester }}">Pilih</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalSelectDosen" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Pilih Dosen</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped" id="datatableDosen">
                    <thead>
                        <tr>
                            <th>NIDN</th>
                            <th>Nama Dosen</th>
                            <th>Jenis Kelamin</th>
                            <th>Keahlian</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dosens as $d)
                        <tr>
                            <td>{{ $d->nidn }}</td>
                            <td>{{ $d->nama_lengkap }}</td>
                            <td>{{ $d->jenis_kelamin }}</td>
                            <td>{{ $d->keahlian }}</td>
                            <td>
                                <button class="btn btn-primary btn-select-dosen" data-nidn="{{ $d->nidn }}"
                                    data-nama="{{ $d->nama_lengkap }}">
                                    Pilih
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalSelectDosenEdit" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Pilih Dosen</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped" id="datatableDosenEdit">
                    <thead>
                        <tr>
                            <th>NIDN</th>
                            <th>Nama Dosen</th>
                            <th>Jenis Kelamin</th>
                            <th>Keahlian</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dosens as $d)
                        <tr>
                            <td>{{ $d->nidn }}</td>
                            <td>{{ $d->nama_lengkap }}</td>
                            <td>{{ $d->jenis_kelamin }}</td>
                            <td>{{ $d->keahlian }}</td>
                            <td>
                                <button class="btn btn-primary btn-select-dosen-edit" data-nidn="{{ $d->nidn }}"
                                    data-nama="{{ $d->nama_lengkap }}">
                                    Pilih
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>





@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
    $('#datatable').DataTable();
});

// Saat tombol pilih di modal create matakuliah diklik
$(document).on('click', '.btn-select-mk', function() {
    let kode = $(this).data('kode');
    let nama = $(this).data('nama');
    let sks = $(this).data('sks');
    let semester = $(this).data('semester');

    // Tampilkan di input utama
    $('#matkul_nama').val(nama);
    $('#matkul_kode').val(kode);

    $('#modalSelectMatkul').modal('hide');
    $('#modalCreateKelas').modal('show');

});

// Saat tombol pilih di modal edit matakuliah diklik
$(document).on('click', '.btn-select-mk-edit', function() {
    let kode = $(this).data('kode');
    let nama = $(this).data('nama');
    let sks = $(this).data('sks');
    let semester = $(this).data('semester');

    // Tampilkan di input edit
    $('#edit_matkul_nama').val(nama);
    $('#edit_matkul_kode').val(kode);

    $('#modalSelectMatkulEdit').modal('hide');
    $('#modalEditKelas').modal('show');
});

// Create
$(document).on('click', '.btn-select-dosen', function() {
    let nidn = $(this).data('nidn');
    let nama = $(this).data('nama');

    $('#dosen_nama').val(nama);
    $('#dosen_nidn').val(nidn);

    $('#modalSelectDosen').modal('hide');
    $('#modalCreateKelas').modal('show');
});

// Edit
$(document).on('click', '.btn-select-dosen-edit', function() {
    let nidn = $(this).data('nidn');
    let nama = $(this).data('nama');

    $('#edit_dosen_nama').val(nama);
    $('#edit_dosen_nidn').val(nidn);

    $('#modalSelectDosenEdit').modal('hide');
    $('#modalEditKelas').modal('show');
});



$(document).on('click', '.btn-edit', function () {
    // Matakuliah (nama tampil, kode di hidden)
    $('#edit_matkul_nama').val($(this).data('nama-mk'));
    $('#edit_matkul_kode').val($(this).data('mk'));
    $('#edit_dosen_nama').val($(this).data('nama-dosen'));
    $('#edit_dosen_nidn').val($(this).data('dosen'));

    $('#edit_kode_kelas').val($(this).data('kode'));
    $('#edit_hari').val($(this).data('hari'));
    $('#edit_mulai').val($(this).data('mulai'));
    $('#edit_selesai').val($(this).data('selesai'));
    $('#edit_ruang').val($(this).data('ruang'));
    $('#edit_kapasitas').val($(this).data('kapasitas'));


    $('#formEditKelas').attr('action', '/kelas/' + $(this).data('kode'));
    $('#modalEditKelas').modal('show');
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