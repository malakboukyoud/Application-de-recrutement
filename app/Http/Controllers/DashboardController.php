<?php

namespace App\Http\Controllers;

use App\Models\Offre;
use App\Models\Utilisateur;
use App\Models\Referentiel;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Vérifier la connexion
        if (!session()->has('user')) {
            return redirect()->route('login.form');
        }

        /*
        |--------------------------------------------------------------------------
        | OFFRES
        |--------------------------------------------------------------------------
        */

        $totalOffres = Offre::count();

        $offresOuvertes = Offre::where('statut', 'Ouverte')->count();

        $offresCloturees = Offre::where('statut', 'Fermée')->count();

        $dernieresOffres = Offre::orderBy('id_offre', 'desc')
                                ->take(5)
                                ->get();

        $offresExpiration = Offre::whereDate(
                'date_limite_depot',
                '<=',
                Carbon::today()->addDays(7)
            )
            ->where('statut', 'Ouverte')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | UTILISATEURS
        |--------------------------------------------------------------------------
        */

        $totalUtilisateurs = Utilisateur::count();

        $utilisateursActifs = Utilisateur::where('actif', 1)->count();

        $derniersUtilisateurs = Utilisateur::with('profil')
                                ->orderBy('id_utilisateur', 'desc')
                                ->take(5)
                                ->get();


        /*
        |--------------------------------------------------------------------------
        | REFERENTIELS
        |--------------------------------------------------------------------------
        */

        $totalReferentiels = Referentiel::count();

        $profils = Utilisateur::join(
                'referentiels',
                'utilisateurs.id_profil',
                '=',
                'referentiels.id_ref'
            )
            ->selectRaw('referentiels.libelle, COUNT(*) as total')
            ->groupBy('referentiels.libelle')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | MODULES NON ENCORE CRÉÉS
        |--------------------------------------------------------------------------
        */

        $totalCandidats = 0;

        $totalCandidatures = 0;

        $totalConvocations = 0;

        $totalDocuments = 0;

        $dossiersComplets = 0;

        $dossiersIncomplets = 0;

        $preselectionnes = 0;

        $rejetes = 0;

        $admis = 0;

        $recrutementsFinalises = 0;

        $candidaturesAttente = 0;

        $convocationsAVenir = 0;

        $dossiersArchivage = 0;

        $candidaturesParOffre = 0;


        /*
        |--------------------------------------------------------------------------
        | RETOUR
        |--------------------------------------------------------------------------
        */
        
    // Total notifications
    $notifications = $totalCandidatures;


        return view('dashboard.index', compact(

            'totalOffres',
            'offresOuvertes',
            'offresCloturees',
            'offresExpiration',
            'dernieresOffres',

            'totalUtilisateurs',
            'utilisateursActifs',
            'derniersUtilisateurs',

            'totalReferentiels',
            'profils',

            'totalCandidats',
            'totalCandidatures',
            'totalConvocations',
            'totalDocuments',

            'dossiersComplets',
            'dossiersIncomplets',

            'preselectionnes',
            'rejetes',
            'admis',

            'recrutementsFinalises',

            'candidaturesAttente',
            'convocationsAVenir',

            'dossiersArchivage',
            'notifications',

            'candidaturesParOffre'
        ));
    }
}