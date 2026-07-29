<?php

namespace App\Exports;

use App\Models\Candidature;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ResultatsAdmisExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Candidature::with(['candidat', 'offre', 'evaluations'])
            ->whereHas('evaluations', function ($query) {
                $query->where('decision_finale', 'admis');
            })
            ->get()
            ->sortBy(fn ($c) => $c->evaluations->first()->classement ?? PHP_INT_MAX)
            ->values()
            ->map(function ($candidature) {

                return [

                    'Classement' => $candidature->classement ?? '-',

                    'Nom' => $candidature->candidat->nom ?? '',

                    'Prénom' => $candidature->candidat->prenom ?? '',

                    'CIN' => $candidature->candidat->cin ?? '',

                    'Email' => $candidature->candidat->email ?? '',

                    'Téléphone' => $candidature->candidat->telephone ?? '',

                    'Offre' => $candidature->offre->intitule_poste ?? '',

                    'Référence offre' => $candidature->offre->reference_offre ?? '',

                    'Avis de la commission' => $candidature->observation_commission ?? '',

                ];

            });
    }

    public function headings(): array
    {
        return [

            'Classement',
            'Nom',
            'Prénom',
            'CIN',
            'Email',
            'Téléphone',
            "Titre de l'offre",
            'Référence offre',
            'Avis de la commission',

        ];
    }
}
