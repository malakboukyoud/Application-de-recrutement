<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EvaluationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $candidature = $this->route('candidature'); // présent uniquement sur "store"

        return [
            'id_convocation' => [
                'nullable',
                Rule::exists('convocations', 'id_convocation')
                    ->where(fn ($q) => $q->when($candidature, fn ($qq) => $qq->where('id_candidature', $candidature->id_candidature))),
            ],
            // notes entre 0 et 20 (règle de gestion §6.7)
            'note_ecrite' => ['nullable', 'numeric', 'between:0,20'],
            'note_orale' => ['nullable', 'numeric', 'between:0,20'],
            'note_pratique' => ['nullable', 'numeric', 'between:0,20'],
            'coefficient_ecrit' => ['required', 'numeric', 'between:0,9.99'],
            'coefficient_oral' => ['required', 'numeric', 'between:0,9.99'],
            'coefficient_pratique' => ['required', 'numeric', 'between:0,9.99'],
            'appreciation' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'note_ecrite.between' => 'La note écrite doit être comprise entre 0 et 20.',
            'note_orale.between' => "La note orale doit être comprise entre 0 et 20.",
            'note_pratique.between' => 'La note pratique doit être comprise entre 0 et 20.',
        ];
    }
}
