<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TugasControllerWeb extends Controller
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

        // Ambil semua tugas berdasarkan kelas yang diampu dosen
        $tugas = Tugas::with('kelas.matakuliah')
            ->whereHas('kelas', function ($q) use ($user) {
                $q->where('dosen_nidn', $user->dosen->nidn);
            })
            ->get();

        // Dropdown kelas dosen
        $kelasList = Kelas::with('matakuliah')
            ->where('dosen_nidn', $user->dosen->nidn)
            ->get();

        return view('tugas.index', compact('tugas', 'kelasList'));
    }

    // =====================
    // STORE
    // =====================
    public function store(Request $request)
    {
        $request->validate([
            'kelas_kode'        => 'required|exists:kelas,kode_kelas',
            'judul'             => 'required|string|max:255',
            'deskripsi'         => 'nullable|string',
            'upload_file_tugas' => 'nullable|file|mimes:pdf,doc,docx,zip',
            'deadline'          => 'required|date',
        ]);

        $fileName = null;

        if ($request->hasFile('upload_file_tugas')) {
            $fileName = time() . '_' . $request->file('upload_file_tugas')->getClientOriginalName();
            $request->file('upload_file_tugas')->storeAs('tugas', $fileName, 'public');
        }

        Tugas::create([
            'kode_tugas'        => 'TGS-' . strtoupper(Str::random(8)),
            'kelas_kode'        => $request->kelas_kode,
            'judul'             => $request->judul,
            'deskripsi'         => $request->deskripsi,
            'upload_file_tugas' => $fileName,
            'deadline'          => $request->deadline,
        ]);

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil ditambahkan');
    }

    // =====================
    // UPDATE
    // =====================
    public function update(Request $request, $kode_tugas)
    {
        $tugas = Tugas::where('kode_tugas', $kode_tugas)->firstOrFail();

        $request->validate([
            'kelas_kode'        => 'required|exists:kelas,kode_kelas',
            'judul'             => 'required|string|max:255',
            'deskripsi'         => 'nullable|string',
            'upload_file_tugas' => 'nullable|file|mimes:pdf,doc,docx,zip',
            'deadline'          => 'required|date',
        ]);

        if ($request->hasFile('upload_file_tugas')) {
            if ($tugas->upload_file_tugas) {
                Storage::disk('public')->delete('tugas/' . $tugas->upload_file_tugas);
            }

            $fileName = time() . '_' . $request->file('upload_file_tugas')->getClientOriginalName();
            $request->file('upload_file_tugas')->storeAs('tugas', $fileName, 'public');
            $tugas->upload_file_tugas = $fileName;
        }

        $tugas->update([
            'kelas_kode' => $request->kelas_kode,
            'judul'      => $request->judul,
            'deskripsi'  => $request->deskripsi,
            'deadline'   => $request->deadline,
        ]);

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil diperbarui');
    }

    // =====================
    // DESTROY
    // =====================
    public function destroy($kode_tugas)
    {
        $tugas = Tugas::where('kode_tugas', $kode_tugas)->firstOrFail();

        if ($tugas->upload_file_tugas) {
            Storage::disk('public')->delete('tugas/' . $tugas->upload_file_tugas);
        }

        $tugas->delete();

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil dihapus');
    }
}
