<?php

namespace App\Http\Controllers;

use App\Models\Krs;
use App\Models\DetailKrs;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class KRSMahasiswaControllerWeb extends Controller
{
    /**
     * =========================
     * INDEX (HALAMAN KRS MAHASISWA)
     * =========================
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role !== 'mahasiswa') {
            abort(403, 'Akses ditolak');
        }

        $krs = Krs::with([
            'mahasiswa.user',
            'detailKrs.kelas.matakuliah',
            'detailKrs.kelas.dosen'
        ])
            ->whereHas('mahasiswa.user', function ($q) use ($user) {
                $q->where('id', $user->id);
            })
            ->first();

        $kelasList = Kelas::with(['matakuliah', 'dosen'])->get();

        return view('krs_mahasiswa.index', compact('krs', 'kelasList'));
    }


    /**
     * =========================
     * STORE DETAIL KRS (TAMBAH KELAS)
     * =========================
     */
    public function storeDetail(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'mahasiswa') {
            abort(403, 'Akses ditolak');
        }

        $request->validate([
            'kelas_kode' => 'required|exists:kelas,kode_kelas',
        ]);

        $mahasiswa = $user->mahasiswa;

        /**
         * 🔹 Ambil atau buat KRS otomatis
         * status = pending (DI CONTROLLER)
         */
        $krs = Krs::firstOrCreate(
            ['mahasiswa_nobp' => $mahasiswa->nobp],
            [
                'kode_krs' => 'KRS-' . strtoupper(Str::random(8)),
                'status'   => 'pending',
            ]
        );

        /**
         * 🔹 Cegah penambahan jika KRS sudah approved
         */
        if ($krs->status === 'approved') {
            return back()->with('error', 'KRS sudah disetujui dan tidak bisa diubah');
        }

        /**
         * 🔹 Simpan ke detail_krs
         * (unique constraint sudah jaga duplikasi)
         */
        DetailKrs::create([
            'krs_kode'   => $krs->kode_krs,
            'kelas_kode' => $request->kelas_kode,
        ]);

        return back()->with('success', 'Mata kuliah berhasil ditambahkan ke KRS');
    }

    /**
     * =========================
     * HAPUS KELAS DARI KRS
     * =========================
     */
    public function destroyDetail($id)
    {
        $detail = DetailKrs::findOrFail($id);

        if ($detail->krs->status === 'approved') {
            return back()->with('error', 'KRS sudah disetujui dan tidak bisa diubah');
        }

        $detail->delete();

        return back()->with('success', 'Mata kuliah berhasil dihapus dari KRS');
    }
}
