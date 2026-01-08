<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterControllerWeb extends Controller
{
    /**
     * Tampilkan halaman register
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Proses register
     */
    public function register(Request $request)
    {
        // =========================
        // VALIDASI
        // =========================
        $request->validate([
            'nobp'           => 'required|unique:mahasiswas,nobp',
            'nama_lengkap'   => 'required|string|max:100',
            'name'           => 'required|string|max:100|unique:users,name',
            'email'          => 'required|email|unique:users,email',
            'password'       => 'required|min:8',

            'jenis_kelamin'  => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir'   => 'nullable|string|max:50',
            'tanggal_lahir'  => 'nullable|date',
            'alamat'         => 'nullable|string',
            'no_hp'          => 'nullable|string|max:20',
            'prodi'          => 'required|string|max:50',
            'angkatan'       => 'required|digits:4',
        ]);

        DB::beginTransaction();

        try {
            // =========================
            // SIMPAN USER
            // =========================
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'mahasiswa',
            ]);

            // =========================
            // SIMPAN MAHASISWA
            // =========================
            Mahasiswa::create([
                'nobp'           => $request->nobp,
                'nama_lengkap'   => $request->nama_lengkap,
                'user_id'        => $user->id,
                'jenis_kelamin'  => $request->jenis_kelamin,
                'tempat_lahir'   => $request->tempat_lahir,
                'tanggal_lahir'  => $request->tanggal_lahir,
                'alamat'         => $request->alamat,
                'no_hp'          => $request->no_hp,
                'prodi'          => $request->prodi,
                'angkatan'       => $request->angkatan,
                'status'         => 'aktif',
            ]);

            DB::commit();

            // ⛔ TIDAK AUTO LOGIN
            return redirect()->route('login')
                ->with('success', 'Registrasi berhasil, silakan login menggunakan akun Anda.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Registrasi gagal, silakan coba lagi.');
        }
    }
}
