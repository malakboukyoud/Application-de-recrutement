<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CandidatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // affiner avec des policies/middlewares selon le profil connecté
    }

    public function rules(): array
    {
        // id du candidat en cours d'édition (pour ignorer l'unicité du CIN sur lui-même)
        $idCandidat = $this->route('candidat')?->id_candidat;

        return [
            'nom' => ['required', 'string', 'max:100'],
            'prenom' => ['required', 'string', 'max:100'],
            'sexe' => ['nullable', Rule::in(['M', 'F'])],
            'date_naissance' => ['nullable', 'date', 'before:today'],
            'lieu_naissance' => ['nullable', 'string', 'max:100'],
            'cin' => [
                'required', 'string', 'max:20',
                Rule::unique('candidats', 'cin')->ignore($idCandidat, 'id_candidat'),
            ],
            'adresse' => ['nullable', 'string', 'max:200'],
            'ville' => ['nullable', 'string', 'max:100'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:150'],
            'niveau_etude' => ['nullable', 'string', 'max:100'],
            'id_diplome' => ['nullable', 'string', 'max:100'],
            'id_specialite' => ['nullable', 'string', 'max:100'],
            'etablissement' => ['nullable', 'string', 'max:150'],
            'annee_obtention' => ['nullable', 'integer', 'min:1950', 'max:' . (date('Y') + 1)],
            'experience' => ['nullable', 'string'],
            'situation_actuelle' => ['nullable', 'string', 'max:100'],
            'observations' => ['nullable', 'string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'cin' => 'numéro CIN',
        ];
    }

    public function messages(): array
    {
        return [
            'cin.unique' => 'Ce numéro CIN est déjà utilisé par un autre candidat.',
        ];
    }
}
