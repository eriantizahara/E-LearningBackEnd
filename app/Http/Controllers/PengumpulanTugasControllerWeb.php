<?php

namespace App\Http\Controllers;

use App\Models\PengumpulanTugas;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengumpulanTugasControllerWeb extends Controller
{
    // =====================
    // INDEX
    // =====================
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'dosen') {
            abort(403, 'Akses ditolak');
        }

        // Daftar kelas yang diampu dosen
        $kelasList = Kelas::with('matakuliah')
            ->where('dosen_nidn', $user->dosen->nidn)
            ->get();

        $selectedKelas = $request->kelas_kode ?? null;
        $selectedMahasiswa = $request->mahasiswa_nobp ?? null;

        // Ambil semua mahasiswa untuk dropdown
        $mahasiswaList = Mahasiswa::all();

        $jawabanList = [];

        if ($selectedKelas && $selectedMahasiswa) {
            // Ambil jawaban mahasiswa untuk kelas dan mahasiswa tertentu
            $jawabanList = PengumpulanTugas::whereHas('tugas', function($q) use ($selectedKelas) {
                    $q->where('kelas_kode', $selectedKelas);
                })
                ->where('mahasiswa_nobp', $selectedMahasiswa)
                ->with('tugas', 'mahasiswa')
                ->get();
        }

        return view('pengumpulan_tugas.index', compact(
            'kelasList',
            'mahasiswaList',
            'jawabanList',
            'selectedKelas',
            'selectedMahasiswa'
        ));
    }

    // =====================
    // UPDATE NILAI
    // =====================
    public function update(Request $request, $id)
    {
        $request->validate([
            'nilai' => 'nullable|numeric|min:0|max:100',
        ]);

        $pengumpulan = PengumpulanTugas::findOrFail($id);
        $pengumpulan->nilai = $request->nilai;
        $pengumpulan->save();

        return redirect()->route('pengumpulan_tugas.index', [
            'kelas_kode' => $request->kelas_kode,
            'mahasiswa_nobp' => $request->mahasiswa_nobp
        ])->with('success', 'Nilai berhasil diperbarui');
    }
}
