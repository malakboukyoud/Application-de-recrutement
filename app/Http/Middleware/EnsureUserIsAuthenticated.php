<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Vérifie qu'un utilisateur est connecté (session['user']).
 * Remplace le contrôle manuel qui n'était fait que dans DashboardController.
 *
 * Cahier des charges §17 : "accès par login et mot de passe".
 */
class EnsureUserIsAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! session('user')) {
            return redirect()
                ->route('login.form')
                ->with('error', 'Veuillez vous connecter.');
        }

        return $next($request);
    }
}