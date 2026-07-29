<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class AdmisController extends Controller
{

    public function index()
    {

        $admis = DB::table('evaluations')

            ->join(
                'candidatures',
                'evaluations.id_candidature',
                '=',
                'candidatures.id_candidature'
            )

            ->join(
                'candidats',
                'candidatures.id_candidat',
                '=',
                'candidats.id_candidat'
            )

            ->join(
                'offres_recrutement',
                'candidatures.id_offre',
                '=',
                'offres_recrutement.id_offre'
            )


            // candidats admis
            ->where(
                'evaluations.decision_finale',
                'Admis'
            )


            ->select(

    'candidats.nom',
    'candidats.prenom',
    'candidats.email',
    'candidats.created_at',
    'offres_recrutement.intitule_poste',

    'evaluations.note_finale',

    'evaluations.classement',

    'evaluations.observation_commission'
)
            ->orderBy(
                'evaluations.classement',
                'asc'
            )


            ->get();



        return view(
            'admis.index',
            compact('admis')
        );

    }

}