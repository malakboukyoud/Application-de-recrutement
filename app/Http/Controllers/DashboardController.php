<?php

namespace App\Http\Controllers;

use App\Models\OffreRecrutement;
use App\Models\Candidat;
use App\Models\Candidature;
use App\Models\Convocation;
use App\Models\Evaluation;
use App\Exports\DashboardExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        /*
        |--------------------------------------------------------------------------
        | OFFRES DE RECRUTEMENT
        |--------------------------------------------------------------------------
        */

        $totalOffres = OffreRecrutement::count();

        $offresOuvertes = OffreRecrutement::where(
            'statut',
            'Ouverte'
        )->count();

        $offresFermees = OffreRecrutement::where(
            'statut',
            'Fermée'
        )->count();

        $offresExpirentBientot = OffreRecrutement::where(
                'statut',
                'Ouverte'
            )
            ->whereBetween(
                'date_limite_depot',
                [
                    $today,
                    $today->copy()->addDays(7)
                ]
            )
            ->count();

        $prochaineExpiration = OffreRecrutement::where(
                'statut',
                'Ouverte'
            )
            ->whereDate(
                'date_limite_depot',
                '>=',
                $today
            )
            ->orderBy('date_limite_depot')
            ->first();

        $offresRecentes = OffreRecrutement::orderBy(
                'date_publication',
                'desc'
            )
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | CANDIDATS
        |--------------------------------------------------------------------------
        */

        $totalCandidats = Candidat::count();

        /*
         | Si ta table candidats ne possède pas created_at,
         | cette statistique restera à 0.
         */

        $nouveauxCandidats = 0;

        if (
            \Schema::hasColumn(
                'candidats',
                'created_at'
            )
        ) {

            $nouveauxCandidats = Candidat::whereDate(
                'created_at',
                $today
            )->count();
        }

        /*
        |--------------------------------------------------------------------------
        | DOSSIERS DE CANDIDATURE
        |--------------------------------------------------------------------------
        */

        $dossiersComplets = Candidature::where(
            'dossier_complet',
            true
        )->count();

        $dossiersIncomplets = Candidature::where(
            'dossier_complet',
            false
        )->count();

        $dossiersAArchiver = Candidature::where(
            'etat_candidature',
            'Archivée'
        )->count();
                /*
        |--------------------------------------------------------------------------
        | CANDIDATURES
        |--------------------------------------------------------------------------
        */

        $totalCandidatures = Candidature::count();

        $candidaturesEnAttente = Candidature::where(
            'etat_candidature',
            "En cours d'étude"
        )->count();

        $candidaturesValidees = Candidature::where(
            'etat_candidature',
            'Admise'
        )->count();

        $candidaturesRejetees = Candidature::where(
            'etat_candidature',
            'Rejetée'
        )->count();

        $preselectionnes = Candidature::where(
            'etat_candidature',
            'Présélectionnée'
        )->count();

        $convoques = Candidature::where(
            'etat_candidature',
            'Convoquée'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | CANDIDATURES RÉCENTES
        |--------------------------------------------------------------------------
        */

        $candidaturesRecentes = Candidature::with([
                'candidat',
                'offre'
            ])
            ->orderBy('date_depot', 'desc')
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | CONVOCATIONS
        |--------------------------------------------------------------------------
        */

        $totalConvocations = Convocation::count();

        $convocationsAujourdhui = Convocation::whereDate(
            'date_convocation',
            $today
        )->count();

        $convocationsSemaine = Convocation::whereBetween(
            'date_convocation',
            [
                $today,
                $today->copy()->addDays(7)
            ]
        )->count();

        $convocationsAVenir = Convocation::whereDate(
            'date_convocation',
            '>',
            $today
        )->count();

        /*
        |--------------------------------------------------------------------------
        | ÉVALUATIONS
        |--------------------------------------------------------------------------
        */

        $totalEvaluations = Evaluation::count();

        /*
         | La table evaluations ne contient pas
         | decision_finale.
         | On récupère donc ces statistiques
         | depuis la table candidatures.
         */

        $admis = Candidature::where(
            'etat_candidature',
            'Admise'
        )->count();

        $listeAttente = Candidature::where(
            'etat_candidature',
            "Liste d'attente"
        )->count();

        $nonAdmis = Candidature::where(
            'etat_candidature',
            'Non admise'
        )->count();

        $rejetes = $candidaturesRejetees;

        $recrutementsFinalises =
            $admis +
            $nonAdmis;

        /*
        |--------------------------------------------------------------------------
        | NOTIFICATIONS
        |--------------------------------------------------------------------------
        */

        $nbNotifications =
            $candidaturesEnAttente
            + $dossiersIncomplets
            + $offresExpirentBientot
            + $convocationsAVenir;
                    /*
        |--------------------------------------------------------------------------
        | GRAPHIQUE 1 : CANDIDATURES PAR MOIS
        |--------------------------------------------------------------------------
        */

        $candidaturesParMois = Candidature::select(
                DB::raw('MONTH(date_depot) as mois'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy(DB::raw('MONTH(date_depot)'))
            ->orderBy(DB::raw('MONTH(date_depot)'))
            ->pluck('total', 'mois')
            ->toArray();

        $labels = [];
        $data = [];

        for ($i = 1; $i <= 12; $i++) {

            $labels[] = Carbon::create()
                ->month($i)
                ->locale('fr')
                ->translatedFormat('M');

            $data[] = $candidaturesParMois[$i] ?? 0;
        }

        /*
        |--------------------------------------------------------------------------
        | GRAPHIQUE 2 : ÉTAT DES CANDIDATS
        |--------------------------------------------------------------------------
        */

        $repartitionCandidatures = [

            $preselectionnes,
            $rejetes,
            $convoques,
            $admis

        ];

        /*
        |--------------------------------------------------------------------------
        | RETOUR DE LA VUE
        |--------------------------------------------------------------------------
        */

        return view('dashboard.index', compact(

            // OFFRES
            'totalOffres',
            'offresOuvertes',
            'offresFermees',
            'offresExpirentBientot',
            'prochaineExpiration',
            'offresRecentes',

            // CANDIDATS
            'totalCandidats',
            'nouveauxCandidats',

            // DOSSIERS
            'dossiersComplets',
            'dossiersIncomplets',
            'dossiersAArchiver',

            // CANDIDATURES
            'totalCandidatures',
            'candidaturesEnAttente',
            'candidaturesValidees',
            'candidaturesRejetees',
            'candidaturesRecentes',

            'preselectionnes',
            'convoques',
            'rejetes',

            // CONVOCATIONS
            'totalConvocations',
            'convocationsAujourdhui',
            'convocationsSemaine',
            'convocationsAVenir',

            // ÉVALUATIONS
            'totalEvaluations',
            'admis',
            'listeAttente',
            'nonAdmis',
            'recrutementsFinalises',

            // NOTIFICATIONS
            'nbNotifications',

            // GRAPHIQUES
            'labels',
            'data',
            'repartitionCandidatures'

        ));
    }
        /*
    |--------------------------------------------------------------------------
    | EXPORT EXCEL
    |--------------------------------------------------------------------------
    */

    public function exportExcel()
    {
        return Excel::download(
            new DashboardExport(),
            'dashboard_recrutement.xlsx'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT PDF
    |--------------------------------------------------------------------------
    */

    public function exportPdf()
    {
        $candidatures = Candidature::with([
                'candidat',
                'offre'
            ])
            ->orderBy('date_depot', 'desc')
            ->get();

        $pdf = Pdf::loadView(
            'dashboard.pdf',
            compact('candidatures')
        );

        return $pdf->download(
            'rapport_recrutement.pdf'
        );
    }
}