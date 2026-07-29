<?php

namespace App\Exports;

use App\Models\Convocation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ConvocationsExport implements FromCollection, WithHeadings
{
    /**
     * @param array $filtres ['search' => ..., 'statut_presence' => ...]
     */
    public function __construct(private array $filtres = [])
    {
    }

    public function collection()
    {
        $query = Convocation::with(['candidature.candidat', 'candidature.offre']);

        if (! empty($this->filtres['search'])) {

            $search = $this->filtres['search'];

            $query->whereHas('candidature.candidat', function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%");
            });

        }

        if (! empty($this->filtres['statut_presence'])) {
            $query->where('statut_presence', $this->filtres['statut_presence']);
        }

        return $query
            ->orderBy('date_convocation', 'desc')
            ->get()
            ->map(function ($convocation) {

                return [

                    'Nom' => $convocation->candidature->candidat->nom ?? '',

                    'Prénom' => $convocation->candidature->candidat->prenom ?? '',

                    'CIN' => $convocation->candidature->candidat->cin ?? '',

                    'Offre' => $convocation->candidature->offre->intitule_poste ?? '',

                    'Date' => $convocation->date_convocation,

                    'Heure' => $convocation->heure_convocation,

                    'Type' => $convocation->type_convocation,

                    'Lieu' => $convocation->lieu_convocation,

                    'Statut de présence' => $convocation->statut_presence ?? '-',

                ];

            });
    }

    public function headings(): array
    {
        return [

            'Nom',
            'Prénom',
            'CIN',
            "Titre de l'offre",
            'Date',
            'Heure',
            'Type',
            'Lieu',
            'Statut de présence',

        ];
    }
}
