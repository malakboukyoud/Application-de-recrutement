<?php

namespace App\Http\Requests;

use App\Models\Candidature;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CandidatureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $idCandidature = $this->route('candidature')?->id_candidature;

        return [
            'id_candidat' => ['required', 'exists:candidats,id_candidat'],
            'id_offre' => [
                'required', 'exists:offres_recrutement,id_offre',
                // règle de gestion : un même candidat ne postule qu'une fois à la même offre
                Rule::unique('candidatures', 'id_offre')
                    ->where(fn ($q) => $q->where('id_candidat', $this->input('id_candidat')))
                    ->ignore($idCandidature, 'id_candidature'),
            ],
            'date_depot' => ['required', 'date', 'before_or_equal:today'],
            'mode_depot' => ['required', Rule::in(Candidature::MODES_DEPOT)],
            'etat_candidature' => ['required', Rule::in(array_keys(Candidature::ETATS))],
            'dossier_complet' => ['nullable', 'boolean'],
            // motif de rejet obligatoire si l'état est "rejetee"
            'motif_rejet' => ['required_if:etat_candidature,rejetee', 'nullable', 'string'],
            'classement' => ['nullable', 'integer', 'min:1'],
            'decision_finale' => ['nullable', Rule::in(Candidature::DECISIONS)],
            'observation_rh' => ['nullable', 'string'],
            'observation_commission' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'id_offre.unique' => 'Ce candidat a déjà postulé à cette offre.',
            'motif_rejet.required_if' => 'Le motif de rejet est obligatoire pour une candidature rejetée.',
        ];
    }
}
