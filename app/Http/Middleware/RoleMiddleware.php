<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = session('user');

        if (!$user) {
            return redirect('/login');
        }

        if (!in_array($user->profil, $roles)) {
            abort(403, 'Accès interdit.');
        }

        return $next($request);
    }
}