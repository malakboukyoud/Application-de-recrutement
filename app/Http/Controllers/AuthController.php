<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            ->where('utilisateurs.mot_de_passe', $request->password)
            ->first();
            

        if ($user) {

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
            'mot_de_passe' => $request->password
        ]);

        return redirect()->route('login.form')
                         ->with('success', 'Compte créé avec succès.');
    }
    
}