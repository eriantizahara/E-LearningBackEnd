<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

// Models
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Matakuliah;
use App\Models\Kelas;
use App\Models\Krs;
use App\Models\DetailKrs;
use App\Models\Tugas;
use App\Models\PengumpulanTugas;

class DashboardControllerWeb extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;

        // ================= DEFAULT DATA (AMAN UNTUK BLADE) =================
        $data = [
            // admin
            'totalMahasiswa'     => 0,
            'totalDosen'         => 0,
            'totalMatakuliah'    => 0,
            'totalKelas'         => 0,

            // dosen
            'kelasMengajar'      => 0,
            'matakuliahDosen'    => 0,
            'totalTugas'         => 0,

            // mahasiswa
            'matakuliahDiambil'  => 0,
            'tugasSelesai'       => 0,
            'tugasPending'       => 0,
        ];

        /* =====================================================
         | DASHBOARD ADMIN
         ===================================================== */
        if ($role === 'admin') {
            $data['totalMahasiswa']  = Mahasiswa::count();
            $data['totalDosen']      = Dosen::count();
            $data['totalMatakuliah'] = Matakuliah::count();
            $data['totalKelas']      = Kelas::count();
        }

        /* =====================================================
         | DASHBOARD DOSEN
         ===================================================== */
        if ($role === 'dosen') {

            // dosen terhubung ke users via user_id
            $dosen = Dosen::where('user_id', $user->id)->first();

            if ($dosen) {

                // jumlah kelas yang diajar
                $data['kelasMengajar'] = Kelas::where('dosen_nidn', $dosen->nidn)->count();

                // jumlah matakuliah yang diampu (via kelas)
                $data['matakuliahDosen'] = Kelas::where('dosen_nidn', $dosen->nidn)
                    ->distinct('matakuliah_kode')
                    ->count('matakuliah_kode');

                // jumlah tugas (tugas → kelas)
                $data['totalTugas'] = Tugas::whereIn(
                    'kelas_kode',
                    Kelas::where('dosen_nidn', $dosen->nidn)->pluck('kode_kelas')
                )->count();
            }
        }

        /* =====================================================
         | DASHBOARD MAHASISWA
         ===================================================== */
        if ($role === 'mahasiswa') {

            // mahasiswa terhubung ke users via user_id
            $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

            if ($mahasiswa) {

                // jumlah kelas diambil (detail_krs)
                $data['matakuliahDiambil'] = DetailKrs::whereIn(
                    'krs_kode',
                    Krs::where('mahasiswa_nobp', $mahasiswa->nobp)->pluck('kode_krs')
                )->count();

                // tugas selesai (nilai sudah ada)
                $data['tugasSelesai'] = PengumpulanTugas::where('mahasiswa_nobp', $mahasiswa->nobp)
                    ->whereNotNull('nilai')
                    ->count();

                // tugas pending (belum dinilai)
                $data['tugasPending'] = PengumpulanTugas::where('mahasiswa_nobp', $mahasiswa->nobp)
                    ->whereNull('nilai')
                    ->count();
            }
        }

        return view('layouts.dashboard', $data);
    }
}
