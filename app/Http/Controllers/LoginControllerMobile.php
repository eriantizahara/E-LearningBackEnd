<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginControllerMobile extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {

            $user = Auth::user();

            // 🔒 CEK ROLE MAHASISWA
            if ($user->role !== 'mahasiswa') {
                Auth::logout();

                return response()->json([
                    'message' => 'Kamu tidak punya akses'
                ], 403);
            }

            // simpan info device
            $user->ip_address = $request->ip();
            $user->user_agent = $request->header('User-Agent');
            $user->save();

            // 🔑 Buat token (Sanctum)
            $token = $user->createToken('auth_token_mobile')->plainTextToken;

            return response()->json([
                'message' => 'Login berhasil',
                'token' => $token,
                'user' => $user
            ], 200);
        }

        return response()->json([
            'message' => 'Email atau password salah'
        ], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'Logged out successfully!']);
    }

    public function dataPengguna(Request $request)
    {
        $user = $request->user()->load('mahasiswa');

        return response()->json([
            'user' => $user,
            'mahasiswa' => $user->mahasiswa
        ], 200);
    }
}
