<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Mahasiswa;
use App\Models\Dosen;

class ProfileControllerWeb extends Controller
{
    /* =====================
     | PROFILE
     ===================== */
    public function profile()
    {
        $user = Auth::user();
        $role = $user->role;

        $data = [
            'user'      => $user,
            'mahasiswa' => null,
            'dosen'     => null,
        ];

        if ($role === 'mahasiswa') {
            $data['mahasiswa'] = Mahasiswa::where('user_id', $user->id)->first();
        }

        if ($role === 'dosen') {
            $data['dosen'] = Dosen::where('user_id', $user->id)->first();
        }

        return view('profile.profile', $data);
    }

    /* =====================
     | AKUN
     ===================== */
    public function akun()
    {
        return view('profile.akun', [
            'user' => Auth::user()
        ]);
    }

    /* =====================
     | GANTI PASSWORD
     ===================== */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:8|confirmed',
        ], [
            'password_lama.required' => 'Password lama wajib diisi',
            'password_baru.required' => 'Password baru wajib diisi',
            'password_baru.min' => 'Password baru minimal 8 karakter',
            'password_baru.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);

        $user = Auth::user();

        // ❌ PASSWORD LAMA SALAH
        if (!Hash::check($request->password_lama, $user->password)) {
            return redirect()->route('akun')
                ->with('error', 'Password lama tidak sesuai');
        }

        // ✅ UPDATE PASSWORD
        $user->update([
            'password' => Hash::make($request->password_baru)
        ]);

        // ✅ LOGOUT SETELAH BERHASIL
        Auth::logout();

        return redirect()->route('login')
            ->with('success', 'Password berhasil diperbarui, silakan login ulang');
    }
}
