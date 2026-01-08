<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Matakuliah;
use App\Models\Dosen;
use Illuminate\Http\Request;

class KelasControllerWeb extends Controller
{
    /**
     * Tampilkan daftar kelas
     */
    public function index()
    {
        // ambil kelas + relasi
        $kelas = Kelas::with(['matakuliah', 'dosen'])->get();

        // data master
        $matakuliahs = Matakuliah::all();
        $dosens = Dosen::all();

        return view('kelas.index', compact('kelas', 'matakuliahs', 'dosens'));
    }

    /**
     * Simpan data kelas baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_kelas'        => 'required|string|max:20|unique:kelas,kode_kelas',
            'matakuliah_kode'   => 'required|exists:matakuliahs,kode_matakuliah',
            'dosen_nidn'        => 'required|exists:dosens,nidn',
            'hari'              => 'required|string|max:20',
            'jam_mulai'         => 'required',
            'jam_selesai'       => 'required',
            'ruang'             => 'required|string|max:20',
            'kapasitas'         => 'required|integer|min:1',
        ]);

        Kelas::create($request->all());

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Data kelas berhasil ditambahkan');
    }

    /**
     * Update data kelas
     */
    public function update(Request $request, $kode_kelas)
    {
        $kelas = Kelas::findOrFail($kode_kelas);

        $request->validate([
            'matakuliah_kode' => 'required|exists:matakuliahs,kode_matakuliah',
            'dosen_nidn'      => 'required|exists:dosens,nidn',
            'hari'            => 'required|string|max:20',
            'jam_mulai'       => 'required',
            'jam_selesai'     => 'required',
            'ruang'           => 'required|string|max:20',
            'kapasitas'       => 'required|integer|min:1',
        ]);

        $kelas->update($request->all());

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Data kelas berhasil diperbarui');
    }

    /**
     * Hapus data kelas
     */
    public function destroy($kode_kelas)
    {
        $kelas = Kelas::findOrFail($kode_kelas);
        $kelas->delete();

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Data kelas berhasil dihapus');
    }
}
