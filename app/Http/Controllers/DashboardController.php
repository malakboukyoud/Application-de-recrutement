<?php

namespace App\Http\Controllers;

use App\Models\OffreRecrutement;
use App\Models\Candidat;
use App\Models\Candidature;
use App\Models\Convocation;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DashboardExport;

use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    /**
     * ============================================================
     * DASHBOARD
     * ============================================================
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | OFFRES
        |--------------------------------------------------------------------------
        */

        $totalOffres = OffreRecrutement::count();

        $offresOuvertes = OffreRecrutement::whereIn('statut', [
            'Ouverte',
            'Ouvert',
            'Publiée',
            'Publiee'
        ])->count();

        $offresFermees = OffreRecrutement::whereIn('statut', [
            'Fermée',
            'Fermee',
            'Clôturée',
            'Cloturee',
            'Expirée',
            'Expiree'
        ])->count();


        /*
        |--------------------------------------------------------------------------
        | CANDIDATURES
        |--------------------------------------------------------------------------
        */

        $totalCandidatures = Candidature::count();


        /*
        |--------------------------------------------------------------------------
        | DOSSIERS
        |--------------------------------------------------------------------------
        */

        $dossiersComplets = Candidature::where(
            'dossier_complet',
            1
        )->count();


        $dossiersIncomplets = Candidature::where(
            'dossier_complet',
            0
        )->count();


        /*
        |--------------------------------------------------------------------------
        | CANDIDATURES EN ATTENTE
        |--------------------------------------------------------------------------
        */

        $candidaturesEnAttente = Candidature::whereIn(
            'etat_candidature',
            [
                'En attente',
                'Non traitée',
                'Non traitée',
                'À traiter',
                'A traiter'
            ]
        )->count();


        /*
        |--------------------------------------------------------------------------
        | DOSSIERS À ARCHIVER
        |--------------------------------------------------------------------------
        |
        | Pour l'instant on considère comme à archiver
        | les candidatures rejetées.
        |
        */

        $dossiersAArchiver = Candidature::whereIn(
            'etat_candidature',
            [
                'Rejetée',
                'Rejeté',
                'Refusée',
                'Refusé'
            ]
        )->count();


        /*
        |--------------------------------------------------------------------------
        | SUIVI DES CANDIDATS
        |--------------------------------------------------------------------------
        */

        $preselectionnes = Candidature::whereIn(
            'etat_candidature',
            [
                'Présélectionnée',
                'Présélectionné',
                'Preselectionnee',
                'Preselectionne'
            ]
        )->count();


        $rejetes = Candidature::whereIn(
            'etat_candidature',
            [
                'Rejetée',
                'Rejeté',
                'Refusée',
                'Refusé'
            ]
        )->count();


        $convoques = Candidature::whereIn(
            'etat_candidature',
            [
                'Convoquée',
                'Convoqué',
                'Convoquée pour entretien',
                'Convoqué pour entretien'
            ]
        )->count();


        $admis = Candidature::whereIn(
            'etat_candidature',
            [
                'Admise',
                'Admis',
                'Retenue',
                'Retenu'
            ]
        )->count();


        /*
        |--------------------------------------------------------------------------
        | RECRUTEMENTS FINALISÉS
        |--------------------------------------------------------------------------
        */

        $recrutementsFinalises = Candidature::whereIn(
            'etat_candidature',
            [
                'Recrutée',
                'Recruté',
                'Recrutement finalisé',
                'Recrutement finalisé'
            ]
        )->count();


        /*
        |--------------------------------------------------------------------------
        | OFFRES EXPIRANT BIENTÔT
        |--------------------------------------------------------------------------
        */

        $offresExpirentBientot = OffreRecrutement::whereNotNull(
            'date_limite_depot'
        )
        ->whereDate(
            'date_limite_depot',
            '>=',
            now()->startOfDay()
        )
        ->whereDate(
            'date_limite_depot',
            '<=',
            now()->addDays(7)->endOfDay()
        )
        ->count();


        /*
        |--------------------------------------------------------------------------
        | CONVOCATIONS À VENIR
        |--------------------------------------------------------------------------
        */

        $convocationsAVenir = 0;

        try {

            $convocationsAVenir = Convocation::whereDate(
                'date_convocation',
                '>=',
                now()->startOfDay()
            )
            ->whereDate(
                'date_convocation',
                '<=',
                now()->addDays(30)->endOfDay()
            )
            ->count();

        } catch (\Throwable $e) {

            $convocationsAVenir = 0;

        }


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
        | CANDIDATURES RÉCENTES
        |--------------------------------------------------------------------------
        */

        $candidaturesRecentes = Candidature::with([
            'candidat',
            'offre'
        ])
        ->orderByDesc('date_depot')
        ->limit(5)
        ->get();


        /*
        |--------------------------------------------------------------------------
        | OFFRES RÉCENTES
        |--------------------------------------------------------------------------
        */

        $offresRecentes = OffreRecrutement::orderByDesc(
            'id_offre'
        )
        ->limit(5)
        ->get();


        /*
        |--------------------------------------------------------------------------
        | STATISTIQUES PAR MOIS
        |--------------------------------------------------------------------------
        */

        $labels = [];
        $data = [];

        for ($i = 5; $i >= 0; $i--) {

            $date = now()->subMonths($i);

            $labels[] = ucfirst(
                $date->locale('fr')->translatedFormat('M Y')
            );

            $data[] = Candidature::whereYear(
                'date_depot',
                $date->year
            )
            ->whereMonth(
                'date_depot',
                $date->month
            )
            ->count();
        }


        /*
        |--------------------------------------------------------------------------
        | RETOUR DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view(
            'dashboard.index',
            compact(
                'totalOffres',
                'offresOuvertes',
                'offresFermees',

                'totalCandidatures',

                'dossiersComplets',
                'dossiersIncomplets',
                'candidaturesEnAttente',
                'dossiersAArchiver',

                'preselectionnes',
                'rejetes',
                'convoques',
                'admis',
                'recrutementsFinalises',

                'offresExpirentBientot',
                'convocationsAVenir',
                'nbNotifications',

                'candidaturesRecentes',
                'offresRecentes',

                'labels',
                'data'
            )
        );
    }


    /**
     * ============================================================
     * EXPORT EXCEL
     * ============================================================
     */
    public function exportExcel()
{
    return Excel::download(
        new DashboardExport,
        'candidatures_ormvasm.xlsx'
    );
}


    /**
     * ============================================================
     * EXPORT PDF
     * ============================================================
     */
    public function exportPdf()
{
    $candidatures = Candidature::with([
        'candidat',
        'offre'
    ])
    ->orderByDesc('date_depot')
    ->get();

    $pdf = Pdf::loadView(
        'dashboard.pdf',
        compact('candidatures')
    );

    return $pdf->download('candidatures_ormvasm.pdf');
}
}
