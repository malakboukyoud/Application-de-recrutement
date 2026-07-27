<?php
// Destination : app/Http/Controllers/ParametreController.php

namespace App\Http\Controllers;

use App\Models\HistoriqueAction;
use App\Models\ParametreOrganisme;
use App\Models\Referentiel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ParametreController extends Controller
{
    /**
     * Catégories de référentiels gérées depuis cette page.
     * Clé = valeur stockée dans `referentiels.type_ref`.
     */
    private const CATEGORIES = [
        'PROFIL' => 'Profils',
        'DIPLOME' => 'Diplômes',
        'SPECIALITE' => 'Spécialités',
        'TYPE_RECRUTEMENT' => 'Types de recrutement',
        'STATUT_OFFRE' => "Statuts d'offre",
        'TYPE_DOCUMENT' => 'Types de document',
    ];

    public function index(Request $request): View
    {
        $categorie = $request->query('categorie', 'DIPLOME');
        if (! array_key_exists($categorie, self::CATEGORIES)) {
            $categorie = 'DIPLOME';
        }

        $referentiels = Referentiel::where('type_ref', $categorie)
            ->orderByDesc('actif')
            ->orderBy('libelle')
            ->get();

        $categories = self::CATEGORIES;
        $organisme = ParametreOrganisme::instance();

        $preferences = [
            'pagination' => (int) session('preference_pagination', 15),
            'densite' => session('preference_densite', 'normal'),
        ];

        return view('parametres.index', compact('referentiels', 'categories', 'categorie', 'organisme', 'preferences'));
    }

    /**
     * Ajouter une valeur à un référentiel (ex : un nouveau diplôme, un nouveau type de document).
     */
    public function storeReferentiel(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'type_ref' => ['required', Rule::in(array_keys(self::CATEGORIES))],
            'libelle' => [
                'required', 'string', 'max:150',
                Rule::unique('referentiels', 'libelle')
                    ->where(fn ($q) => $q->where('type_ref', $request->input('type_ref'))),
            ],
        ]);

        $referentiel = Referentiel::create([
            'type_ref' => $data['type_ref'],
            'libelle' => $data['libelle'],
            'actif' => 1,
        ]);

        HistoriqueAction::enregistrer('creation_referentiel', 'referentiels', $referentiel->id_ref,
            "{$data['type_ref']} : {$data['libelle']}");

        return redirect()
            ->route('parametres.index', ['categorie' => $data['type_ref']])
            ->with('success', 'Valeur ajoutée avec succès.');
    }

    /**
     * Activer / désactiver une valeur de référentiel, plutôt que la supprimer
     * (une valeur peut déjà être utilisée par des enregistrements existants).
     */
    public function toggleReferentiel(Referentiel $referentiel): RedirectResponse
    {
        $referentiel->update(['actif' => ! $referentiel->actif]);

        HistoriqueAction::enregistrer('modification_referentiel', 'referentiels', $referentiel->id_ref,
            $referentiel->actif ? 'Réactivé' : 'Désactivé');

        return redirect()
            ->route('parametres.index', ['categorie' => $referentiel->type_ref])
            ->with('success', 'Statut mis à jour.');
    }

    public function updateOrganisme(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nom_organisme' => ['nullable', 'string', 'max:150'],
            'sigle' => ['nullable', 'string', 'max:20'],
            'adresse' => ['nullable', 'string', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:150'],
        ]);

        ParametreOrganisme::instance()->update($data);

        HistoriqueAction::enregistrer('modification_organisme', 'parametres_organisme', null);

        return back()->with('success', "Informations de l'organisme mises à jour.");
    }

    public function updatePreferences(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'pagination' => ['required', 'integer', Rule::in([10, 15, 25, 50])],
            'densite' => ['required', Rule::in(['normal', 'compacte'])],
        ]);

        session([
            'preference_pagination' => $data['pagination'],
            'preference_densite' => $data['densite'],
        ]);

        return back()->with('success', 'Préférences enregistrées.');
    }
}
