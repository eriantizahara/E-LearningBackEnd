<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Krs;
use App\Models\DetailKrs;
use App\Models\Mahasiswa;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KRSControllerWeb extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $krs = Krs::with([
            'mahasiswa',
            'detailKrs.kelas.matakuliah',
            'detailKrs.kelas.dosen'
        ])->get();

        $mahasiswas = Mahasiswa::orderBy('nama_lengkap')->get();
        $kelas = Kelas::with(['matakuliah', 'dosen'])->get();

        return view('krs.index', compact('krs', 'mahasiswas', 'kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_nobp' => 'required|exists:mahasiswas,nobp|unique:krs,mahasiswa_nobp',
            'kelas_kode'     => 'required|array|min:1',
            'kelas_kode.*'   => 'exists:kelas,kode_kelas',
        ]);

        DB::transaction(function () use ($request) {

            // GENERATE KODE KRS
            $kodeKrs = 'KRS-' . date('Ymd') . '-' . strtoupper(Str::random(4));

            // SIMPAN KRS
            $krs = Krs::create([
                'kode_krs' => $kodeKrs,
                'mahasiswa_nobp' => $request->mahasiswa_nobp,
                'status' => 'pending'
            ]);

            // SIMPAN DETAIL KRS
            foreach ($request->kelas_kode as $kelasKode) {
                DetailKrs::create([
                    'krs_kode' => $krs->kode_krs,
                    'kelas_kode' => $kelasKode
                ]);
            }
        });

        return redirect()->route('krs.index')
            ->with('success', 'KRS berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $kode_krs)
    {
        $krs = Krs::with([
            'mahasiswa',
            'detailKrs.kelas.matakuliah',
            'detailKrs.kelas.dosen'
        ])->findOrFail($kode_krs);

        return view('krs.show', compact('krs'));
    }

    /**
     * Approve KRS
     */
    public function approve($kode_krs)
    {
        $krs = Krs::where('kode_krs', $kode_krs)->firstOrFail();
        $krs->status = 'approved';
        $krs->save();

        return redirect()->back()->with('success', 'KRS berhasil di-approve');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $kode_krs)
    {
        Krs::findOrFail($kode_krs)->delete();

        return redirect()->back()->with('success', 'KRS berhasil dihapus');
    }
}
