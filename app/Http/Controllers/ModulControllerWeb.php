<?php

namespace App\Http\Controllers;

use App\Models\Modul;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ModulControllerWeb extends Controller
{
    // =====================
    // INDEX
    // =====================
    public function index()
    {
        $user = Auth::user();

        if ($user->role !== 'dosen') {
            abort(403, 'Akses ditolak');
        }

        // Ambil semua modul berdasarkan kelas yang diampu dosen
        $moduls = Modul::with('kelas.matakuliah')
            ->whereHas('kelas', function ($q) use ($user) {
                $q->where('dosen_nidn', $user->dosen->nidn);
            })
            ->get();

        // Dropdown kelas dosen
        $kelasList = Kelas::with('matakuliah')
            ->where('dosen_nidn', $user->dosen->nidn)
            ->get();

        return view('moduls.index', compact('moduls', 'kelasList'));
    }

    // =====================
    // STORE
    // =====================
    public function store(Request $request)
    {
        $request->validate([
            'kelas_kode' => 'required|exists:kelas,kode_kelas',
            'judul'      => 'required|string|max:255',
            'file_modul' => 'nullable|file|mimes:pdf,doc,docx',
        ]);

        $fileName = null;
        if ($request->hasFile('file_modul')) {
            $fileName = time() . '_' . $request->file('file_modul')->getClientOriginalName();
            $request->file('file_modul')->storeAs('moduls', $fileName, 'public');
        }

        Modul::create([
            'kelas_kode' => $request->kelas_kode,
            'judul'      => $request->judul,
            'file_modul' => $fileName,
        ]);

        return redirect()->route('moduls.index')->with('success', 'Modul berhasil ditambahkan');
    }

    // =====================
    // UPDATE
    // =====================
    public function update(Request $request, Modul $modul)
    {
        $request->validate([
            'kelas_kode' => 'required|exists:kelas,kode_kelas',
            'judul'      => 'required|string|max:255',
            'file_modul' => 'nullable|file|mimes:pdf,doc,docx',
        ]);

        if ($request->hasFile('file_modul')) {
            if ($modul->file_modul) {
                Storage::disk('public')->delete('moduls/' . $modul->file_modul);
            }
            $fileName = time() . '_' . $request->file('file_modul')->getClientOriginalName();
            $request->file('file_modul')->storeAs('moduls', $fileName, 'public');
            $modul->file_modul = $fileName;
        }

        $modul->update([
            'kelas_kode' => $request->kelas_kode,
            'judul'      => $request->judul,
        ]);

        return redirect()->route('moduls.index')->with('success', 'Modul berhasil diperbarui');
    }

    // =====================
    // DESTROY
    // =====================
    public function destroy(Modul $modul)
    {
        if ($modul->file_modul) {
            Storage::disk('public')->delete('moduls/' . $modul->file_modul);
        }

        $modul->delete();

        return redirect()->route('moduls.index')->with('success', 'Modul berhasil dihapus');
    }
}
