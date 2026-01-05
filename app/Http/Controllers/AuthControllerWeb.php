<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthControllerWeb extends Controller
{
    public function showFormLogin()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function logout(Request $request)
    {
        // Auth::logout();
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
        return redirect('/login');
    }
}
