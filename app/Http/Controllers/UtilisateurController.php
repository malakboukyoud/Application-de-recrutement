<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateur;
use App\Models\Referentiel;

class UtilisateurController extends Controller
{
    /**
     * Liste des utilisateurs
     */
    public function index()
    {
        $utilisateurs = Utilisateur::with('profil')
            ->orderBy('nom')
            ->paginate(10);

        return view('utilisateurs.index', compact('utilisateurs'));
    }

    /**
     * Formulaire d'ajout
     */
    public function create()
    {
        $profils = Referentiel::where('type_ref', 'Profil')->get();

        return view('utilisateurs.create', compact('profils'));
    }

    /**
     * Enregistrer un utilisateur
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|max:100',
            'prenom' => 'required|max:100',
            'login' => 'required|max:100|unique:utilisateurs,login',
            'email' => 'required|email|unique:utilisateurs,email',
            'mot_de_passe' => 'required|min:6',
            'id_profil' => 'required'
        ]);

        Utilisateur::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'login' => $request->login,
            'email' => $request->email,
            'mot_de_passe' => bcrypt($request->mot_de_passe),
            'id_profil' => $request->id_profil,
            'actif' => 1
        ]);

        return redirect()
            ->route('utilisateurs.index')
            ->with('success', 'Utilisateur ajouté avec succès.');
    }

    /**
     * Afficher un utilisateur
     */
    public function show($id)
    {
        $utilisateur = Utilisateur::with('profil')
            ->findOrFail($id);

        return view('utilisateurs.show', compact('utilisateur'));
    }

    /**
     * Formulaire de modification
     */
    public function edit($id)
    {
        $utilisateur = Utilisateur::findOrFail($id);

        $profils = Referentiel::where('type_ref', 'Profil')->get();

        return view('utilisateurs.edit', compact('utilisateur', 'profils'));
    }

    /**
     * Modifier un utilisateur
     */
    public function update(Request $request, $id)
    {
        $utilisateur = Utilisateur::findOrFail($id);

        $request->validate([
            'nom' => 'required|max:100',
            'prenom' => 'required|max:100',
            'login' => 'required|max:100|unique:utilisateurs,login,' . $id . ',id_utilisateur',
            'email' => 'required|email|unique:utilisateurs,email,' . $id . ',id_utilisateur',
            'id_profil' => 'required'
        ]);

        $utilisateur->nom = $request->nom;
        $utilisateur->prenom = $request->prenom;
        $utilisateur->login = $request->login;
        $utilisateur->email = $request->email;
        $utilisateur->id_profil = $request->id_profil;

        if ($request->filled('mot_de_passe')) {
            $utilisateur->mot_de_passe = bcrypt($request->mot_de_passe);
        }

        $utilisateur->save();

        return redirect()
            ->route('utilisateurs.index')
            ->with('success', 'Utilisateur modifié avec succès.');
    }

    /**
     * Supprimer
     */
    public function destroy($id)
    {
        $utilisateur = Utilisateur::findOrFail($id);

        $utilisateur->delete();

        return redirect()
            ->route('utilisateurs.index')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }

    /**
     * Activer
     */
    public function activer($id)
    {
        $utilisateur = Utilisateur::findOrFail($id);

        $utilisateur->actif = 1;

        $utilisateur->save();

        return redirect()
            ->back()
            ->with('success', 'Utilisateur activé.');
    }

    /**
     * Désactiver
     */
    public function desactiver($id)
    {
        $utilisateur = Utilisateur::findOrFail($id);

        $utilisateur->actif = 0;

        $utilisateur->save();

        return redirect()
            ->back()
            ->with('success', 'Utilisateur désactivé.');
    }
}