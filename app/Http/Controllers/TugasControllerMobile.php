<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TugasControllerMobile extends Controller
{
    public function getDataTugas(Request $request)
    {
        $user = $request->user();
        $kodeMatkul = $request->query('kode_matakuliah');

        if (!$kodeMatkul) {
            return response()->json([
                'message' => 'kode_matakuliah wajib dikirim'
            ], 400);
        }

        // 1️⃣ ambil mahasiswa
        $mahasiswa = DB::table('mahasiswas')
            ->where('user_id', $user->id)
            ->first();

        if (!$mahasiswa) {
            return response()->json([
                'message' => 'Mahasiswa tidak ditemukan'
            ], 404);
        }

        // 2️⃣ ambil tugas sesuai matakuliah + status pengumpulan
        $tugas = DB::table('krs')
            ->join('detail_krs', 'krs.kode_krs', '=', 'detail_krs.krs_kode')
            ->join('kelas', 'detail_krs.kelas_kode', '=', 'kelas.kode_kelas')
            ->join('matakuliahs', 'kelas.matakuliah_kode', '=', 'matakuliahs.kode_matakuliah')
            ->join('tugas', 'kelas.kode_kelas', '=', 'tugas.kelas_kode')
            ->leftJoin('pengumpulan_tugas', function ($join) use ($mahasiswa) {
                $join->on('tugas.kode_tugas', '=', 'pengumpulan_tugas.tugas_kode')
                    ->where('pengumpulan_tugas.mahasiswa_nobp', $mahasiswa->nobp);
            })
            ->where('krs.mahasiswa_nobp', $mahasiswa->nobp)
            ->where('matakuliahs.kode_matakuliah', $kodeMatkul)
            ->select(
                'tugas.kode_tugas',
                'tugas.judul',
                'tugas.deskripsi',
                'tugas.upload_file_tugas',
                'tugas.deadline',
                'pengumpulan_tugas.nilai',
                DB::raw('CASE 
                    WHEN pengumpulan_tugas.id IS NULL THEN 0 
                    ELSE 1 
                END as sudah_kumpul')
            )
            ->orderBy('tugas.deadline', 'asc')
            ->distinct()
            ->get();

        // 3️⃣ buat URL file tugas
        $tugas->transform(function ($item) {
            if ($item->upload_file_tugas) {
                $item->file_tugas_url = asset('storage/' . $item->upload_file_tugas);
            } else {
                $item->file_tugas_url = null;
            }
            return $item;
        });

        return response()->json([
            'data' => $tugas
        ]);
    }

    public function detailTugas(Request $request)
    {
        $user = $request->user();
        $kodeTugas = $request->query('kode_tugas');

        $mahasiswa = DB::table('mahasiswas')
            ->where('user_id', $user->id)
            ->first();

        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa tidak ditemukan'], 404);
        }

        $tugas = DB::table('tugas')
            ->leftJoin('pengumpulan_tugas', function ($join) use ($mahasiswa) {
                $join->on('tugas.kode_tugas', '=', 'pengumpulan_tugas.tugas_kode')
                    ->where('pengumpulan_tugas.mahasiswa_nobp', $mahasiswa->nobp);
            })
            ->where('tugas.kode_tugas', $kodeTugas)
            ->select(
                'tugas.kode_tugas',
                'tugas.judul',
                'tugas.deskripsi',
                'tugas.deadline',
                'pengumpulan_tugas.upload_file_jawaban',
                'pengumpulan_tugas.nilai'
            )
            ->first();

        if (!$tugas) {
            return response()->json(['message' => 'Tugas tidak ditemukan'], 404);
        }

        if ($tugas->upload_file_jawaban) {
            $tugas->jawaban_url = asset('storage/' . $tugas->upload_file_jawaban);
        }

        return response()->json(['data' => $tugas]);
    }

    public function uploadJawaban(Request $request)
    {
        $request->validate([
            'kode_tugas' => 'required',
            'file' => 'required|mimes:pdf,doc,docx|max:5120'
        ]);

        $user = $request->user();

        $mahasiswa = DB::table('mahasiswas')
            ->where('user_id', $user->id)
            ->first();

        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa tidak ditemukan'], 404);
        }

        $tugas = DB::table('tugas')
            ->where('kode_tugas', $request->kode_tugas)
            ->first();

        if (!$tugas) {
            return response()->json(['message' => 'Tugas tidak ditemukan'], 404);
        }

        // ❌ cek deadline
        if (now()->gt($tugas->deadline)) {
            return response()->json(['message' => 'Deadline sudah lewat'], 403);
        }

        // simpan file
        $path = $request->file('file')
            ->store('jawaban_tugas', 'public');

        // cek sudah pernah upload
        $existing = DB::table('pengumpulan_tugas')
            ->where('tugas_kode', $request->kode_tugas)
            ->where('mahasiswa_nobp', $mahasiswa->nobp)
            ->first();

        if ($existing) {
            DB::table('pengumpulan_tugas')
                ->where('id', $existing->id)
                ->update([
                    'upload_file_jawaban' => $path,
                    'updated_at' => now()
                ]);
        } else {
            DB::table('pengumpulan_tugas')->insert([
                'tugas_kode' => $request->kode_tugas,
                'mahasiswa_nobp' => $mahasiswa->nobp,
                'upload_file_jawaban' => $path,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return response()->json([
            'message' => 'Jawaban berhasil diupload'
        ]);
    }
}
