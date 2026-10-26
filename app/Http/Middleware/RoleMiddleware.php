<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! auth()->check()) {
            return redirect('login');
        }

        $user = $request->user();

        // Exact role match always succeeds
        if (in_array($user->role, $roles, true)) {
            return $next($request);
        }

        // Admin retains access to existing internal areas, but MUST NOT access ketua-only routes
        if ($user->role === 'admin' && !in_array('ketua', $roles, true)) {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}
