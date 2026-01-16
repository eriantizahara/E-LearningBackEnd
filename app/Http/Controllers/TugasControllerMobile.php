<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;

class TugasControllerMobile extends Controller
{
    public function getDataTugas(Request $request)
    {
        // 🔐 ambil user dari sanctum
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized - token tidak valid'
            ], 401);
        }

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

        // 2️⃣ ambil tugas
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
                $item->file_tugas_url = asset('storage/tugas/' . $item->upload_file_tugas);
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

        if (!$kodeTugas) {
            return response()->json([
                'message' => 'kode_tugas wajib dikirim'
            ], 422);
        }

        $mahasiswa = DB::table('mahasiswas')
            ->where('user_id', $user->id)
            ->first();

        if (!$mahasiswa) {
            return response()->json([
                'message' => 'Mahasiswa tidak ditemukan'
            ], 404);
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
                'pengumpulan_tugas.upload_foto_video',
                'pengumpulan_tugas.jawaban_text',
                'pengumpulan_tugas.nilai'
            )
            ->first();

        if (!$tugas) {
            return response()->json([
                'message' => 'Tugas tidak ditemukan'
            ], 404);
        }

        // URL file jawaban (jika ada)
        if ($tugas->upload_foto_video) {
            $tugas->jawaban_url = asset('storage/' . $tugas->upload_foto_video);
        } else {
            $tugas->jawaban_url = null;
        }

        return response()->json([
            'data' => $tugas
        ]);
    }

    public function uploadJawaban(Request $request)
    {
        // validasi dasar (tidak wajib semua)
        $request->validate([
            'tugas_kode' => 'required',
            'file' => 'nullable|mimes:pdf,doc,docx,mp4,jpg,jpeg,png|max:51200',
            'jawaban_text' => 'nullable|string'
        ]);


        // 👉 pastikan minimal salah satu ada
        if (!$request->hasFile('file') && !$request->filled('jawaban_text')) {
            return response()->json([
                'message' => 'Harap upload file atau isi jawaban teks'
            ], 422);
        }

        $user = $request->user();

        $mahasiswa = DB::table('mahasiswas')
            ->where('user_id', $user->id)
            ->first();

        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa tidak ditemukan'], 404);
        }

        $tugas = DB::table('tugas')
            ->where('kode_tugas', $request->tugas_kode)
            ->first();

        if (!$tugas) {
            return response()->json(['message' => 'Tugas tidak ditemukan'], 404);
        }

        if (now()->gt($tugas->deadline)) {
            return response()->json(['message' => 'Deadline sudah lewat'], 403);
        }

        $filePath  = null;
        $thumbPath = null;

        // ================= FILE UPLOAD =================
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $ext  = $file->getClientOriginalExtension();
            $filename  = time() . '.' . $ext;
            $thumbName = 'thumb_' . time() . '.' . $ext;

            // simpan file utama
            $filePath = $file->storeAs('jawaban_tugas/original', $filename, 'public');

            // 👉 jika file gambar, buat thumbnail
            if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                $thumbDir = public_path('storage/jawaban_tugas/thumbnail');

                if (!File::exists($thumbDir)) {
                    File::makeDirectory($thumbDir, 0755, true);
                }

                $image = Image::read($file);
                $image->scaleDown(width: 300);
                $image->save($thumbDir . '/' . $thumbName);

                $thumbPath = 'jawaban_tugas/thumbnail/' . $thumbName;
            }
        }

        // ================= SIMPAN DB =================
        $existing = DB::table('pengumpulan_tugas')
            ->where('tugas_kode', $request->tugas_kode)
            ->where('mahasiswa_nobp', $mahasiswa->nobp)
            ->first();

        $data = [
            'upload_foto_video' => $filePath,
            'foto_video_thumb' => $thumbPath,
            'jawaban_text'     => $request->jawaban_text,
            'updated_at'       => now()
        ];

        if ($existing) {
            DB::table('pengumpulan_tugas')
                ->where('id', $existing->id)
                ->update($data);
        } else {
            DB::table('pengumpulan_tugas')->insert(array_merge($data, [
                'tugas_kode'        => $request->tugas_kode,
                'mahasiswa_nobp'    => $mahasiswa->nobp,
                'created_at'       => now()
            ]));
        }

        return response()->json([
            'message' => 'Jawaban berhasil disimpan',
            'file_url'  => $filePath ? asset('storage/' . $filePath) : null,
            'thumb_url' => $thumbPath ? asset('storage/' . $thumbPath) : null
        ]);
    }


    public function getTodoTugas(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $mahasiswa = DB::table('mahasiswas')
            ->where('user_id', $user->id)
            ->first();

        if (!$mahasiswa) {
            return response()->json([
                'message' => 'Mahasiswa tidak ditemukan'
            ], 404);
        }

        // optional filter matakuliah
        $kodeMatkul = $request->query('kode_matakuliah');

        $query = DB::table('krs')
            ->join('detail_krs', 'krs.kode_krs', '=', 'detail_krs.krs_kode')
            ->join('kelas', 'detail_krs.kelas_kode', '=', 'kelas.kode_kelas')
            ->join('matakuliahs', 'kelas.matakuliah_kode', '=', 'matakuliahs.kode_matakuliah')
            ->join('tugas', 'kelas.kode_kelas', '=', 'tugas.kelas_kode')
            ->leftJoin('pengumpulan_tugas', function ($join) use ($mahasiswa) {
                $join->on('tugas.kode_tugas', '=', 'pengumpulan_tugas.tugas_kode')
                    ->where('pengumpulan_tugas.mahasiswa_nobp', $mahasiswa->nobp);
            })
            ->where('krs.mahasiswa_nobp', $mahasiswa->nobp)

            // 👉 BELUM DIKUMPULKAN
            ->whereNull('pengumpulan_tugas.id')

            // 👉 BELUM LEWAT DEADLINE
            ->where('tugas.deadline', '>=', now())

            ->select(
                'tugas.kode_tugas',
                'tugas.judul',
                'tugas.deskripsi',
                'tugas.deadline',
                'tugas.upload_file_tugas',
                'matakuliahs.nama_matakuliah'
            )
            ->orderBy('tugas.deadline', 'asc')
            ->distinct();

        if ($kodeMatkul) {
            $query->where('matakuliahs.kode_matakuliah', $kodeMatkul);
        }

        $tugas = $query->get();

        // URL file tugas
        $tugas->transform(function ($item) {
            $item->file_tugas_url = $item->upload_file_tugas
                ? asset('storage/tugas/' . $item->upload_file_tugas)
                : null;

            return $item;
        });

        return response()->json([
            'data' => $tugas
        ]);
    }
}
