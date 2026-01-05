<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class MahasiswaControllerWeb extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::with('user')->get();
        return view('mahasiswa.index', compact('mahasiswas'));
    }

    public function store(Request $request)
    {
        // 1️⃣ VALIDASI
        $request->validate([
            'nobp'          => 'required|unique:mahasiswas,nobp',
            'nama_lengkap'  => 'required|string|max:150',
            'name'          => 'required|string|max:100',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:8',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir'  => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat'        => 'nullable|string',
            'no_hp'         => 'nullable|string|max:20',
            'prodi'      => 'nullable|string|max:100',
            'angkatan' => 'nullable|digits:4',
            'status'        => 'required|in:aktif,cuti,lulus',
        ]);

        // 2️⃣ TRANSAKSI SIMPAN
        DB::transaction(function () use ($request) {

            // SIMPAN USER
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'mahasiswa',
            ]);

            // SIMPAN MAHASISWA
            Mahasiswa::create([
                'user_id'       => $user->id,
                'nobp'          => $request->nobp,
                'nama_lengkap'  => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir'  => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat'        => $request->alamat,
                'no_hp'         => $request->no_hp,
                'prodi'         => $request->prodi,
                'angkatan'      => $request->angkatan,
                'status'        => $request->status,
            ]);
        });

        return redirect()->back()->with('success', 'Data Mahasiswa berhasil ditambahkan');
    }

    public function update(Request $request, $nobp)
    {
        $mahasiswa = Mahasiswa::findOrFail($nobp);
        $user  = $mahasiswa->user;

        // VALIDASI
        $request->validate([
            // 'nobp'          => 'required|unique:mahasiswas,nobp,' . $mahasiswa->nobp,
            'nobp' => [
                'required',
                Rule::unique('mahasiswas')->ignore($mahasiswa->nobp, 'nobp')
            ],
            'nama_lengkap'  => 'required|string|max:150',
            'name'          => 'required|string|max:100',
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'password'      => 'nullable|min:8',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir'  => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat'        => 'nullable|string',
            'no_hp'         => 'nullable|string|max:20',
            'prodi'      => 'nullable|string|max:100',
            'angkatan' => 'nullable|digits:4',
            'status'        => 'required|in:aktif,cuti,lulus',
        ]);

        DB::transaction(function () use ($request, $user, $mahasiswa) {

            // UPDATE USER
            $user->update([
                'name'  => $request->name,
                'email' => $request->email,
            ]);

            if ($request->filled('password')) {
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
            }

            // UPDATE DOSEN
            $mahasiswa->update([
                'nobp'          => $request->nobp,
                'nama_lengkap'  => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir'  => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat'        => $request->alamat,
                'no_hp'         => $request->no_hp,
                'prodi'      => $request->prodi,
                'angkatan'      => $request->angkatan,
                'status'        => $request->status,
            ]);
        });

        return redirect()->back()->with('success', 'Data mahasiswa berhasil diperbarui');
    }


    public function destroy($nobp)
    {
        DB::transaction(function () use ($nobp) {

            $mahasiswa = Mahasiswa::findOrFail($nobp);

            // hapus user dulu (kalau tidak pakai cascade)
            $mahasiswa->user()->delete();

            // kalau migration sudah cascadeOnDelete(), baris di bawah boleh dihapus
            $mahasiswa->delete();
        });

        return redirect()->back()->with('success', 'Data mahasiswa berhasil dihapus');
    }
}
