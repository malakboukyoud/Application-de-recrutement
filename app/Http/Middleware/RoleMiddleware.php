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

        if (! self::userHasRole($roles)) {
            // Au lieu d'un abort(403) (page d'erreur), on reste sur la page précédente
            // avec un message flash. Nécessite que le layout affiche session('error')
            // (ex : @if (session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif).
            return back()->with('error', "Accès interdit : vous n'avez pas les droits nécessaires pour effectuer cette action.");
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
     *
     * Valeurs réelles en base (table `referentiels`, type_ref = 'PROFIL') :
     *   id_ref 1 -> "Administrateur"        -> normalisé "administrateur"
     *   id_ref 2 -> "RH"                     -> normalisé "rh"
     *   id_ref 3 -> "Commission"             -> normalisé "commission"
     *   id_ref 4 -> "Consultation"           -> normalisé "consultation"
     *   id_ref 5 -> "Responsable de service" -> normalisé "responsable de service"
     *
     * Utilisez ces valeurs normalisées dans les middlewares de routes, ex :
     *   Route::middleware('role:administrateur,rh')->group(...)
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