<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
{
    $credentials = $request->only('username', 'password');

    if (Auth::attempt($credentials)) {
        // Jika login sukses, arahkan ke dashboard
        return redirect()->intended('/dashboard');
    }

    // Jika gagal, kembali ke halaman login dengan pesan error
    return back()->withErrors(['username' => 'username atau password salah.']);

    $remember = $request->has('remember');

    if (Auth::attempt([
        'username' => $request->username,
        'password' => $request->password
    ], $remember)) {
        return redirect()->intended('/dashboard');
    }
}
}
