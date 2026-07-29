<?php

namespace App\Exports;

use App\Models\Candidature;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DashboardExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Candidature::with(['candidat', 'offre'])
            ->get()
            ->map(function ($candidature) {

                return [

                    'Nom' => $candidature->candidat->nom ?? '',

                    'Prénom' => $candidature->candidat->prenom ?? '',

                    'CIN' => $candidature->candidat->cin ?? '',

                    'Email' => $candidature->candidat->email ?? '',

                    'Téléphone' => $candidature->candidat->telephone ?? '',

                    'Offre' => $candidature->offre->intitule_poste ?? '',

                    'État' => $candidature->etat_candidature,

                    'Date de dépôt' => $candidature->date_depot,

                    'Dossier complet' => $candidature->dossier_complet ? 'Oui' : 'Non',

                ];

            });
    }

    public function headings(): array
    {
        return [

            'Nom',
            'Prénom',
            'CIN',
            'Email',
            'Téléphone',
            "Titre de l'offre",
            'État de la candidature',
            'Date de dépôt',
            'Dossier complet',

        ];
    }
}
