@extends('layouts.app')

@section('page-heading')
<h4 class="fw-bold mb-0">Data KRS</h4>
@endsection

@section('content')

<div class="card">
    <div class="card-body">

        <div class="d-flex justify-content-between mb-4">
            <span class="fw-semibold">Daftar KRS Mahasiswa</span>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateKrs">
                <i class="fa fa-plus-circle"></i> Tambah KRS
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="datatable">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Kode KRS</th>
                        <th class="text-center">Mahasiswa</th>
                        <th class="text-center">Jumlah Kelas</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($krs as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->kode_krs }}</td>
                        <td>
                            {{ $item->mahasiswa->nobp }} - {{ $item->mahasiswa->nama_lengkap }}
                        </td>
                        <td class="text-center">
                            {{ $item->detailKrs->count() }}
                        </td>
                        <td class="text-center">
                            <span class="badge bg-{{ $item->status == 'approved' ? 'success' : 'warning' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($item->status == 'pending')
                            <button class="btn btn-sm btn-success btn-approve" data-id="{{ $item->kode_krs }}">
                                <i class="fa fa-check"></i>
                            </button>
                            @else
                            <span class="approved-box" title="Approved"
                                style="color:#85d446">
                                <i class="fa fa-check fa-lg"></i>
                            </span>
                            @endif

                            <button class="btn btn-sm btn-danger btn-hapus" data-id="{{ $item->kode_krs }}"
                                data-nama="{{ $item->mahasiswa->nama_lengkap }}">
                                <i class="fa fa-trash"></i>
                            </button>

                            <form id="form-hapus-{{ $item->kode_krs }}"
                                action="{{ route('krs.destroy', $item->kode_krs) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
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

<div class="modal fade" id="modalCreateKrs" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">

            <form action="{{ route('krs.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah KRS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <!-- PILIH MAHASISWA -->
                    <div class="mb-3">
                        <label>Mahasiswa</label>
                        <div class="input-group">
                            <input type="text" id="nama_mahasiswa" class="form-control" readonly>
                            <input type="hidden" name="mahasiswa_nobp" id="nobp_mahasiswa">
                            <button type="button" class="btn btn-secondary" id="btnOpenMahasiswa">
                                Pilih
                            </button>
                        </div>
                    </div>

                    <hr>

                    <!-- PILIH KELAS -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">Pilih</th>
                                    <th class="text-center">Kode</th>
                                    <th class="text-center">Mata Kuliah</th>
                                    <th class="text-center">Semester</th>
                                    <th class="text-center">Dosen</th>
                                    <th class="text-center">Hari</th>
                                    <th class="text-center">Jam</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kelas as $k)
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" name="kelas_kode[]" value="{{ $k->kode_kelas }}">
                                    </td>
                                    <td>{{ $k->kode_kelas }}</td>
                                    <td>{{ $k->matakuliah->nama_matakuliah }}</td>
                                    <td>{{ $k->matakuliah->semester }}</td>
                                    <td>{{ $k->dosen->nama_lengkap }}</td>
                                    <td>{{ $k->hari }}</td>
                                    <td>{{ $k->jam_mulai }} - {{ $k->jam_selesai }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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

<div class="modal fade" id="modalMahasiswa" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">Pilih Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">NOBP</>
                            <th class="text-center">Nama Lengkap</th>
                            <th class="text-center">Jenis Kelamin</th>
                            <th class="text-center">Prodi</th>
                            <th class="text-center">Angkatan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mahasiswas as $m)
                        <tr>
                            <td>{{ $m->nobp }}</td>
                            <td>{{ $m->nama_lengkap }}</td>
                            <td>{{ $m->jenis_kelamin }}</td>
                            <td>{{ $m->prodi }}</td>
                            <td>{{ $m->angkatan }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary pilih-mahasiswa" data-nobp="{{ $m->nobp }}"
                                    data-nama="{{ $m->nama_lengkap }}">
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

    let modalCreateKrs = new bootstrap.Modal(
    document.getElementById('modalCreateKrs')
);

let modalMahasiswa = new bootstrap.Modal(
    document.getElementById('modalMahasiswa')
);

// BUKA MODAL MAHASISWA
$('#btnOpenMahasiswa').on('click', function () {
    modalCreateKrs.hide();
    modalMahasiswa.show();
});

// PILIH MAHASISWA
$(document).on('click', '.pilih-mahasiswa', function () {
    $('#nobp_mahasiswa').val($(this).data('nobp'));
    $('#nama_mahasiswa').val($(this).data('nama'));

    modalMahasiswa.hide();
    modalCreateKrs.show();
});

// JIKA MODAL MAHASISWA DITUTUP TANPA PILIH
$('#modalMahasiswa').on('hidden.bs.modal', function () {
    if (!$('#nobp_mahasiswa').val()) {
        modalCreateKrs.show();
    }
});

$(document).on('click', '.btn-hapus', function () {
    let kode = $(this).data('id');
    let nama = $(this).data('nama');

    Swal.fire({
        title: 'Yakin hapus KRS?',
        text: 'KRS milik ' + nama + ' akan dihapus permanen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-hapus-' + kode).submit();
        }
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

$(document).on('click', '.btn-approve', function() {
    let kode = $(this).data('id');

    Swal.fire({
        title: 'Yakin ingin approve KRS ini?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, approve',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Buat form sementara untuk POST approve
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '/krs/' + kode + '/approve';

            // Tambah CSRF token
            let csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);

            document.body.appendChild(form);
            form.submit();
        }
    });
});

</script>
@endpush