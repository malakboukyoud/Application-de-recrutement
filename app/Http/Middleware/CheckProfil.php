<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Contrôle d'accès par profil (§11 du cahier des charges — Gestion des
 * utilisateurs et droits d'accès).
 *
 * Usage dans routes/web.php :
 *
 *   Route::get('/utilisateurs', ...)->middleware('profil:Administrateur');
 *   Route::get('/offres/create', ...)->middleware('profil:Administrateur,Service RH');
 *
 * L'Administrateur a toujours accès à tout (super-profil), même s'il n'est
 * pas explicitement listé dans les paramètres du middleware.
 *
 * IMPORTANT : cette classe protège uniquement les ROUTES (le back-end).
 * Elle doit être complétée par un masquage des liens/menus côté vue
 * (déjà fait dans index_blade.php) — l'un ne remplace pas l'autre, car un
 * utilisateur peut toujours taper une URL directement.
 */
class CheckProfil
{
    public function handle(Request $request, Closure $next, string ...$profilsAutorises): Response
    {
        $user = session('user');

        if (! $user) {
            return redirect()
                ->route('login.form')
                ->with('error', 'Veuillez vous connecter.');
        }

        $profilUtilisateur = $this->normaliser($user->profil ?? '');

        // L'Administrateur garde toujours accès.
        if ($profilUtilisateur === 'administrateur') {
            return $next($request);
        }

        $autorises = array_map([$this, 'normaliser'], $profilsAutorises);

        if (in_array($profilUtilisateur, $autorises, true)) {
            return $next($request);
        }

        abort(403, "Vous n'avez pas les droits nécessaires pour accéder à cette page.");
    }

    private function normaliser(string $profil): string
    {
        return strtolower(trim($profil));
    }
}
