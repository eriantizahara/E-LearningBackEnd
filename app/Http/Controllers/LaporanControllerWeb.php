<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengumpulanTugas;
use App\Models\Mahasiswa;
use App\Models\Tugas;
use App\Models\Kelas;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class LaporanControllerWeb extends Controller
{
    // ===============================
    // HALAMAN LAPORAN
    // ===============================
    public function nilaiMahasiswa(Request $request)
    {
        $user = Auth::user();

        $mahasiswas = Mahasiswa::orderBy('nama_lengkap')->get();
        $tugas = Tugas::orderBy('kode_tugas')->get();

        // Kelas yang diampu dosen login
        $kelas = Kelas::with('matakuliah')
            ->where('dosen_nidn', $user->dosen->nidn)
            ->orderBy('kode_kelas')
            ->get();

        $pengumpulan = PengumpulanTugas::with(['mahasiswa', 'tugas.kelas.matakuliah'])
            ->when($request->mahasiswa, function ($query) use ($request) {
                $query->where('mahasiswa_nobp', $request->mahasiswa);
            })
            ->when($request->tugas, function ($query) use ($request) {
                $query->where('tugas_kode', $request->tugas);
            })
            ->when($request->kelas, function ($query) use ($request) {
                $query->whereHas('tugas', function ($q) use ($request) {
                    $q->where('kelas_kode', $request->kelas);
                });
            })
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        return view('laporan.laporan_nilai_mhs', compact(
            'pengumpulan',
            'mahasiswas',
            'tugas',
            'kelas'
        ));
    }

    // ===============================
    // DOWNLOAD PDF
    // ===============================
    public function downloadPdf(Request $request)
    {
        $pengumpulan = PengumpulanTugas::with(['mahasiswa', 'tugas.kelas.matakuliah'])
            ->when($request->mahasiswa, function ($q) use ($request) {
                $q->where('mahasiswa_nobp', $request->mahasiswa);
            })
            ->when($request->kelas, function ($q) use ($request) {
                $q->whereHas('tugas.kelas', function ($sub) use ($request) {
                    $sub->where('kode_kelas', $request->kelas);
                });
            })
            ->when($request->tugas, function ($q) use ($request) {
                $q->where('tugas_kode', $request->tugas);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Ambil mata kuliah dari data pertama (jika ada)
        $matakuliah = optional(
            optional(
                optional($pengumpulan->first())->tugas
            )->kelas
        )->matakuliah;

        // Ambil dosen dari data pertama (jika ada)
        $dosen = optional(
            optional(
                optional($pengumpulan->first())->tugas
            )->kelas
        )->dosen;


        $pdf = Pdf::loadView('laporan.nilai_pdf', [
            'pengumpulan' => $pengumpulan,
            'matakuliah'  => $matakuliah,
            'dosen'       => $dosen
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('Laporan Nilai Mahasiswa.pdf');
    }
}
