<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminSessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $lastActivity = session('admin_last_activity');
            $timeout = 86400; // 1 day in seconds

            if ($lastActivity && (time() - $lastActivity > $timeout)) {
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->with('error', 'Sesi Anda telah berakhir.');
            }

            session(['admin_last_activity' => time()]);
        }

        return $next($request);
    }
}
