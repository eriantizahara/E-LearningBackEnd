<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ModulControllerMobile extends Controller
{
    public function getDataModul(Request $request)
    {
        $user = $request->user();
        $kodeMatkul = $request->query('kode_matakuliah');

        if (!$kodeMatkul) {
            return response()->json([
                'message' => 'kode_matakuliah wajib dikirim'
            ], 400);
        }

        // ambil mahasiswa
        $mahasiswa = DB::table('mahasiswas')
            ->where('user_id', $user->id)
            ->first();

        if (!$mahasiswa) {
            return response()->json([
                'message' => 'Mahasiswa tidak ditemukan'
            ], 404);
        }

        // ambil modul sesuai MATKUL
        $moduls = DB::table('krs')
            ->join('detail_krs', 'krs.kode_krs', '=', 'detail_krs.krs_kode')
            ->join('kelas', 'detail_krs.kelas_kode', '=', 'kelas.kode_kelas')
            ->join('matakuliahs', 'kelas.matakuliah_kode', '=', 'matakuliahs.kode_matakuliah')
            ->join('moduls', 'kelas.kode_kelas', '=', 'moduls.kelas_kode')
            ->where('krs.mahasiswa_nobp', $mahasiswa->nobp)
            ->where('matakuliahs.kode_matakuliah', $kodeMatkul)
            ->select(
                'moduls.id',
                'moduls.judul',
                'moduls.file_modul',
                'moduls.created_at'
            )
            ->distinct()
            ->orderBy('moduls.created_at', 'desc')
            ->get();

        // ubah ke URL publik
        $moduls->transform(function ($item) {
            $item->file_url = asset('storage/' . $item->file_modul);
            return $item;
        });

        return response()->json([
            'data' => $moduls
        ]);
    }
}
