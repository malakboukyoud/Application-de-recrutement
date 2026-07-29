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

    /**
     * Utilisable directement dans les vues Blade pour masquer un bouton :
     *   @if (\App\Http\Middleware\RoleMiddleware::userHasRole(['administrateur', 'rh']))
     *       <a ...>Modifier</a>
     *   @endif
     */
    public static function userHasRole(array $roles): bool
    {
        $user = session('user');

        if (!$user) {
            return false;
        }

        // IMPORTANT : session('user') est un objet stdClass construit par
        // AuthController::login() via une jointure SQL brute :
        //   DB::table('utilisateurs')->join('referentiels', ...)
        //     ->select('utilisateurs.*', 'referentiels.libelle as profil')
        // La colonne `profil` contient donc DÉJÀ le libellé texte (ex: "Administrateur").
        // Ce n'est PAS la relation Eloquent Utilisateur::profil() -> NE PAS faire ->libelle dessus.
        $libelleProfil = $user->profil ?? '';

        $profilUtilisateur = self::normaliser($libelleProfil);
        $profilsAutorises = array_map([self::class, 'normaliser'], $roles);

        return in_array($profilUtilisateur, $profilsAutorises, true);
    }

    /**
     * Normalise pour comparer sans se soucier des accents/majuscules
     * (ex: "Administrateur", "ADMIN", "admin" -> mêmes valeurs comparables).
     */
    private static function normaliser(string $valeur): string
    {
        $valeur = mb_strtolower(trim($valeur));

        return strtr($valeur, [
            'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
            'à' => 'a', 'â' => 'a', 'î' => 'i', 'ï' => 'i',
            'ô' => 'o', 'ù' => 'u', 'û' => 'u', 'ç' => 'c',
        ]);
    }
}
