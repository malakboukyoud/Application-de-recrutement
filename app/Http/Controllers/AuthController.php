<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Afficher la page de connexion
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Traiter la connexion
     */
    public function login(Request $request)
    {
        // Validation
        $request->validate([
            'login' => 'required',
            'password' => 'required'
        ]);

        // Vérification dans la base
        // On ne peut pas comparer un mot de passe hashé directement dans le WHERE SQL :
        // on récupère d'abord l'utilisateur par son login, puis on vérifie le hash.
        $user = DB::table('utilisateurs')
            ->join(
                'referentiels',
                'utilisateurs.id_profil',
                '=',
                'referentiels.id_ref'
            )
            ->select(
                'utilisateurs.*',
                'referentiels.libelle as profil'
            )
            ->where('utilisateurs.login', $request->login)
            ->first();

        if ($user && $this->motDePasseValide($request->password, $user)) {

            // Enregistrer l'utilisateur dans la session
            session([
                'user' => $user
            ]);

            // Redirection vers le Dashboard
            return redirect()->route('dashboard.index');
        }

        // Si identifiants incorrects
        return back()
            ->withInput()
            ->with('error', 'Identifiant ou mot de passe incorrect.');
    }

    /**
     * Déconnexion
     */
    public function logout()
    {
        session()->forget('user');

        return redirect()->route('login.form');
    }

    /**
     * Inscription (facultatif)
     */
    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email',
            'login' => 'required|unique:utilisateurs,login',
            'password' => 'required|min:6',
        ]);

        DB::table('utilisateurs')->insert([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'login' => $request->login,
            'mot_de_passe' => Hash::make($request->password)
        ]);

        return redirect()->route('login.form')
                         ->with('success', 'Compte créé avec succès.');
    }

    /**
     * Vérifie le mot de passe saisi contre celui stocké en base.
     *
     * Certains comptes plus anciens ont pu être créés avant l'utilisation de Hash::make()
     * et ont donc un mot de passe encore stocké en clair. Hash::check() lève une exception
     * dans ce cas (le hash n'est pas au format Bcrypt), donc on gère les deux cas :
     *   - mot de passe déjà haché  -> vérification normale avec Hash::check()
     *   - mot de passe encore en clair -> comparaison directe, puis migration
     *     automatique vers un hash Bcrypt pour que les connexions suivantes
     *     passent par le chemin sécurisé.
     */
    private function motDePasseValide(string $motDePasseSaisi, object $utilisateur): bool
    {
        if (Hash::isHashed($utilisateur->mot_de_passe)) {
            return Hash::check($motDePasseSaisi, $utilisateur->mot_de_passe);
        }

        if (hash_equals((string) $utilisateur->mot_de_passe, $motDePasseSaisi)) {
            // Migration silencieuse vers un mot de passe haché.
            DB::table('utilisateurs')
                ->where('id_utilisateur', $utilisateur->id_utilisateur)
                ->update(['mot_de_passe' => Hash::make($motDePasseSaisi)]);

            return true;
        }

        return false;
    }

}