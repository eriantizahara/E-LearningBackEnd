<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matakuliah;

class MatakuliahControllerWeb extends Controller
{
     /**
     * Tampilkan daftar matakuliah
     */
    public function index()
    {
        $matakuliahs = Matakuliah::all();
        return view('matakuliah.index', compact('matakuliahs'));
    }

    /**
     * Simpan matakuliah baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_matakuliah' => 'required|string|max:20|unique:matakuliahs,kode_matakuliah',
            'nama_matakuliah' => 'required|string|max:100',
            'sks' => 'required|integer|min:0',
            'semester' => 'required|integer|min:1',
        ]);

        Matakuliah::create([
            'kode_matakuliah' => $request->kode_matakuliah,
            'nama_matakuliah' => $request->nama_matakuliah,
            'sks' => $request->sks,
            'semester' => $request->semester,
        ]);

        return redirect()->route('matakuliahs.index')->with('success', 'Data Matakuliah berhasil ditambahkan!');
    }

    /**
     * Update matakuliah
     */
    public function update(Request $request, $kode_matakuliah)
    {
        $request->validate([
            'kode_matakuliah' => 'required|string|max:20|unique:matakuliahs,kode_matakuliah,' . $kode_matakuliah . ',kode_matakuliah',
            'nama_matakuliah' => 'required|string|max:100',
            'sks' => 'required|integer|min:0',
            'semester' => 'required|integer|min:1',
        ]);

        $matakuliah = Matakuliah::findOrFail($kode_matakuliah);
        $matakuliah->update([
            'kode_matakuliah' => $request->kode_matakuliah,
            'nama_matakuliah' => $request->nama_matakuliah,
            'sks' => $request->sks,
            'semester' => $request->semester,
        ]);

        return redirect()->route('matakuliahs.index')->with('success', 'Data Matakuliah berhasil diperbarui!');
    }

    /**
     * Hapus matakuliah
     */
    public function destroy($kode_matakuliah)
    {
        $matakuliah = Matakuliah::findOrFail($kode_matakuliah);
        $matakuliah->delete();

        return redirect()->route('matakuliahs.index')->with('success', 'Data Matakuliah berhasil dihapus!');
    }
}
