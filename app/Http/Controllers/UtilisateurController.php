<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateur;
use App\Models\Referentiel;
use App\Models\Candidature;
use App\Models\OffreRecrutement;
use App\Models\Convocation;
use Illuminate\Support\Facades\Hash;

class UtilisateurController extends Controller
{
    /**
     * Liste des utilisateurs
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | UTILISATEURS
        |--------------------------------------------------------------------------
        */

        $utilisateurs = Utilisateur::with('profil')
            ->paginate(10);


        /*
        |--------------------------------------------------------------------------
        | STATISTIQUES UTILISATEURS
        |--------------------------------------------------------------------------
        */

        $totalUtilisateurs = Utilisateur::count();

        $totalActifs = Utilisateur::where('actif', 1)->count();

        $totalInactifs = Utilisateur::where('actif', 0)->count();

        $totalAdministrateurs = Utilisateur::where('id_profil', 1)->count();


        /*
        |--------------------------------------------------------------------------
        | NOTIFICATIONS
        |--------------------------------------------------------------------------
        */

        // Nouvelles candidatures reçues
        $candidaturesEnAttente = Candidature::where(
            'etat_candidature',
            'Reçue'
        )->count();


        // Dossiers incomplets
        $dossiersIncomplets = Candidature::where(
            'dossier_complet',
            0
        )->count();


        // Offres qui expirent dans les 7 prochains jours
        $offresExpirentBientot = OffreRecrutement::whereBetween(
    'date_limite_depot',
    [
        now()->toDateString(),
        now()->addDays(7)->toDateString()
    ]
)->count();


        // Convocations à venir
        $convocationsAVenir = Convocation::where(
            'date_convocation',
            '>=',
            now()
        )->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL NOTIFICATIONS
        |--------------------------------------------------------------------------
        */

        $nbNotifications =
            $candidaturesEnAttente
            + $dossiersIncomplets
            + $offresExpirentBientot
            + $convocationsAVenir;


        /*
        |--------------------------------------------------------------------------
        | RETOUR VUE
        |--------------------------------------------------------------------------
        */

        return view(
            'utilisateurs.index',
            compact(
                'utilisateurs',

                // Statistiques
                'totalUtilisateurs',
                'totalActifs',
                'totalInactifs',
                'totalAdministrateurs',

                // Notifications
                'candidaturesEnAttente',
                'dossiersIncomplets',
                'offresExpirentBientot',
                'convocationsAVenir',
                'nbNotifications'
            )
        );
    }


    /**
     * Formulaire création utilisateur
     */
    public function create()
    {
        $profils = Referentiel::type('profil')->get();

        return view(
            'utilisateurs.create',
            compact('profils')
        );
    }


    /**
     * Enregistrer utilisateur
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'login' => 'required|unique:utilisateurs,login',
            'email' => 'required|email|unique:utilisateurs,email',
            'mot_de_passe' => 'required|min:6',
            'id_profil' => 'required|integer',
            'actif' => 'required'
        ]);


        Utilisateur::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'login' => $request->login,
            'email' => $request->email,
            'mot_de_passe' => Hash::make(
                $request->mot_de_passe
            ),
            'id_profil' => $request->id_profil,
            'actif' => $request->actif
        ]);


        return redirect()
            ->route('utilisateurs.index')
            ->with(
                'success',
                'Utilisateur ajouté avec succès'
            );
    }


    /**
     * Afficher utilisateur
     */
    public function show($id)
    {
        $utilisateur = Utilisateur::with('profil')
            ->findOrFail($id);

        return view(
            'utilisateurs.show',
            compact('utilisateur')
        );
    }


    /**
     * Modifier utilisateur
     */
    public function edit($id)
    {
        $utilisateur = Utilisateur::findOrFail($id);

        $profils = Referentiel::type('profil')->get();

        return view(
            'utilisateurs.edit',
            compact(
                'utilisateur',
                'profils'
            )
        );
    }


    /**
     * Mise à jour utilisateur
     */
    public function update(Request $request, $id)
    {
        $utilisateur = Utilisateur::findOrFail($id);


        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email',
            'id_profil' => 'required|integer',
            'actif' => 'required'
        ]);


        $utilisateur->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'id_profil' => $request->id_profil,
            'actif' => $request->actif
        ]);


        return redirect()
            ->route('utilisateurs.index')
            ->with(
                'success',
                'Utilisateur modifié avec succès'
            );
    }


    /**
     * Supprimer utilisateur
     */
    public function destroy($id)
    {
        Utilisateur::findOrFail($id)->delete();

        return redirect()
            ->route('utilisateurs.index')
            ->with(
                'success',
                'Utilisateur supprimé avec succès'
            );
    }



}
