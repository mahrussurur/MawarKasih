<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Proses login menggunakan username + password.
     * (Bukan email seperti default Breeze)
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input dari form login
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Coba autentikasi menggunakan username & password
        if (! Auth::attempt(
            $request->only('username', 'password'),
            $request->boolean('remember')
        )) {
            // Jika gagal, kembalikan error
            return back()->withErrors([
                'username' => 'Username atau password yang kamu masukkan salah.',
            ])->onlyInput('username');
        }

        // Regenerate session agar aman (mencegah session fixation attack)
        $request->session()->regenerate();

        // Redirect ke halaman dashboard setelah login berhasil
        return redirect()->intended(route('dashboard'));
    }

    /**
     * Proses logout - hapus sesi pengguna.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}