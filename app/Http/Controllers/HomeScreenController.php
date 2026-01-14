<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeScreenController extends Controller
{
    public function matakuliahSaya()
    {
        $user = Auth::user();

        if ($user->role !== 'mahasiswa') {
            return response()->json([
                'message' => 'Tidak punya akses'
            ], 403);
        }

        $mahasiswa = DB::table('mahasiswas')
            ->where('user_id', $user->id)
            ->first();

        if (!$mahasiswa) {
            return response()->json([
                'message' => 'Mahasiswa tidak ditemukan'
            ], 404);
        }

        $matakuliah = DB::table('krs')
            ->join('detail_krs', 'krs.kode_krs', '=', 'detail_krs.krs_kode')
            ->join('kelas', 'detail_krs.kelas_kode', '=', 'kelas.kode_kelas')
            ->join('matakuliahs', 'kelas.matakuliah_kode', '=', 'matakuliahs.kode_matakuliah')
            ->where('krs.mahasiswa_nobp', $mahasiswa->nobp)
            ->select(
                'matakuliahs.kode_matakuliah',
                'matakuliahs.nama_matakuliah'
            )
            ->distinct()
            ->get();

        return response()->json([
            'matkul' => $matakuliah
        ]);
    }
}
