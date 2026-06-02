<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Donatur;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class DonaturPasswordResetController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function createLinkRequest(): View
    {
        return view('auth.forgot-password', [
            'submitUrl' => route('public.donasi.password.email'),
            'loginUrl' => route('public.donasi.login'),
        ]);
    }

    /**
     * Handle an incoming password reset link request.
     */
    public function storeLinkRequest(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::broker('donaturs')->sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }

    /**
     * Display the password reset view.
     */
    public function createReset(Request $request): View
    {
        return view('auth.reset-password', [
            'request' => $request,
            'token' => $request->route('token'),
            'submitUrl' => route('public.donasi.password.update'),
            'loginUrl' => route('public.donasi.login'),
        ]);
    }

    /**
     * Handle an incoming new password request.
     */
    public function storeReset(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::broker('donaturs')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (Donatur $user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('public.donasi.login')->with('success', 'Password berhasil direset. Silakan login dengan password baru.')
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}
