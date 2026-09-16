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

        // Admin is the internal superuser, while every non-admin role remains
        // limited to the route groups explicitly assigned to it.
        if ($user->role === 'admin' || in_array($user->role, $roles, true)) {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}
