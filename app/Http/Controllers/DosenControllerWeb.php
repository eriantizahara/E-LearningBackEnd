<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class DosenControllerWeb extends Controller
{
    public function index()
    {
        $dosens = Dosen::with('user')->get();
        return view('dosen.index', compact('dosens'));

        // $dosens = Dosen::all();
        // return view('dosen.index', compact('dosens'));
    }

    public function store(Request $request)
    {
        // 1️⃣ VALIDASI
        $request->validate([
            'nidn'          => 'required|unique:dosens,nidn',
            'nama_lengkap'  => 'required|string|max:150',
            'name'          => 'required|string|max:100',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:8',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir'  => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat'        => 'nullable|string',
            'no_hp'         => 'nullable|string|max:20',
            'keahlian'      => 'nullable|string|max:100',
            'status'        => 'required|in:aktif,nonaktif',
        ]);

        // 2️⃣ TRANSAKSI SIMPAN
        DB::transaction(function () use ($request) {

            // SIMPAN USER
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'dosen',
            ]);

            // SIMPAN DOSEN
            Dosen::create([
                'user_id'       => $user->id,
                'nidn'          => $request->nidn,
                'nama_lengkap'  => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir'  => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat'        => $request->alamat,
                'no_hp'         => $request->no_hp,
                'keahlian'      => $request->keahlian,
                'status'        => $request->status,
            ]);
        });

        return redirect()->back()->with('success', 'Data dosen berhasil ditambahkan');
    }

    public function update(Request $request, $nidn)
    {
        $dosen = Dosen::findOrFail($nidn);
        $user  = $dosen->user;

        // VALIDASI
        $request->validate([
            'nidn' => [
                'required',
                Rule::unique('dosens')->ignore($dosen->nidn, 'nidn')
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
            'keahlian'      => 'nullable|string|max:100',
            'status'        => 'required|in:aktif,nonaktif',
        ]);

        DB::transaction(function () use ($request, $user, $dosen) {

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
            $dosen->update([
                'nidn'          => $request->nidn,
                'nama_lengkap'  => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir'  => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat'        => $request->alamat,
                'no_hp'         => $request->no_hp,
                'keahlian'      => $request->keahlian,
                'status'        => $request->status,
            ]);
        });

        return redirect()->back()->with('success', 'Data dosen berhasil diperbarui');
    }


    public function destroy($nidn)
    {
        DB::transaction(function () use ($nidn) {

            $dosen = Dosen::findOrFail($nidn);

            // hapus user dulu (kalau tidak pakai cascade)
            $dosen->user()->delete();

            // kalau migration sudah cascadeOnDelete(), baris di bawah boleh dihapus
            $dosen->delete();
        });

        return redirect()->back()->with('success', 'Data dosen berhasil dihapus');
    }
}
