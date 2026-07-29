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
        $request->validate([
            'login' => 'required',
            'password' => 'required'
        ]);

        // On récupère l'utilisateur par login uniquement : le mot de passe
        // est vérifié à part avec Hash::check (§17 : "les mots de passe
        // doivent être protégés" — ils sont stockés hachés via Hash::make
        // dans UtilisateurController::store/update).
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

        if (! $user || ! Hash::check($request->password, $user->mot_de_passe)) {
            return back()
                ->withInput($request->only('login'))
                ->with('error', 'Identifiant ou mot de passe incorrect.');
        }

        // Compte désactivé par un administrateur (§11 : gestion des comptes)
        if (isset($user->actif) && ! $user->actif) {
            return back()
                ->withInput($request->only('login'))
                ->with('error', 'Votre compte a été désactivé. Contactez un administrateur.');
        }

        // Enregistrer l'utilisateur dans la session
        session([
            'user' => $user
        ]);

        return redirect()->route('dashboard.index');
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
     *
     * Note : la création de comptes est réservée à l'Administrateur
     * (§11 du CDC) et se fait normalement via UtilisateurController::store,
     * qui est déjà protégé par le middleware `profil:Administrateur`.
     * Cette route d'inscription libre reste dangereuse si elle est encore
     * exposée publiquement — voir recommandation dans le README joint.
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
            'mot_de_passe' => Hash::make($request->password),
            'actif' => 1,
        ]);

        return redirect()->route('login.form')
                         ->with('success', 'Compte créé avec succès.');
    }
}