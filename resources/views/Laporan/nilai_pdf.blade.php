<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Nilai Mahasiswa</title>
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 12px;
            line-height: 1.6;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h3,
        .header h4 {
            margin: 0;
        }

        .header p {
            margin: 2px 0;
            font-size: 11px;
        }

        .judul-laporan {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .judul-laporan h4 {
            margin: 0;
            text-transform: uppercase;
        }

        .content {
            margin-top: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table,
        th,
        td {
            border: 1px solid #000;
        }

        th,
        td {
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #ffffff;
        }

        .text-left {
            text-align: left;
        }

        .footer {
            margin-top: 60px;
            width: 100%;
        }

        .ttd {
            float: right;
            text-align: center;
        }
    </style>
</head>

<body>

    {{-- KOP SURAT --}}
    <div class="header">
        <h3>UNIVERSITAS ZED</h3>
        <h4>FAKULTAS TEKNOLOGI INFORMASI</h4>
        <p>Jl. Pendidikan No. 123, Kota Padang</p>
        <p>Email: akademik@universitaszed.ac.id | Telp: (0751) 123456</p>
    </div>

    {{-- JUDUL LAPORAN --}}
    <div class="judul-laporan">
        <h4>LAPORAN NILAI MAHASISWA</h4>
    </div>

    <p style="margin-top:50px;">
        <strong>Mata Kuliah :</strong> {{ $matakuliah->nama_matakuliah ?? '-' }}
    </p>


    {{-- ISI --}}
    <div class="content">

        {{-- TABEL NILAI --}}
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kelas</th>
                    <th>Mahasiswa</th>
                    <th>Tugas</th>
                    <th>Tanggal Upload</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengumpulan as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->tugas->kelas->kode_kelas ?? '-' }}</td>
                    <td class="text-left">
                        {{ $row->mahasiswa->nobp ?? '-' }} -
                        {{ $row->mahasiswa->nama_lengkap ?? '-' }}
                    </td>
                    <td class="text-left">{{ $row->tugas->judul ?? '-' }}</td>
                    <td>{{ $row->created_at ? $row->created_at->format('d F Y') : '-' }}</td>
                    <td>{{ $row->nilai ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" class="text-left">
                        <strong>Total Mahasiswa :</strong> {{ $pengumpulan->count() }} Orang
                    </td>
                </tr>
            </tfoot>
        </table>

        {{-- TOTAL MAHASISWA --}}
        {{-- <p style="margin-top:15px;">
            <strong>Total Mahasiswa :</strong> {{ $pengumpulan->count() }} Orang
        </p> --}}

    </div>

    {{-- TANDA TANGAN --}}
    <div class="footer">
        <div class="ttd">
            <p>Padang, {{ date('d F Y') }}</p>
            <p>Dosen Pengampu</p>

            <br><br><br>

            <p style="margin-bottom:0;">
                {{ $dosen->nama_lengkap ?? '' }}
            </p>
            <p style="margin-top:0;">
                <strong>( ____________________ )</strong>
            </p>

            <p>
                NIDN. {{ $dosen->nidn ?? '__________' }}
            </p>
        </div>
    </div>

    {{-- <div class="footer">
        <div class="ttd">
            <p>Padang, {{ date('d F Y') }}</p>
            <p>Dosen Pengampu</p>
            <br><br><br>
            <p>
                <strong>
                    ( {{ $dosen->nama_lengkap ?? '____________________' }} )
                </strong>
            </p>
            <p>
                NIDN. {{ $dosen->nidn ?? '__________' }}
            </p>
        </div>
    </div> --}}

</body>

</html>