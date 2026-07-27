<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidatureRequest;
use App\Models\Candidat;
use App\Models\Candidature;
use App\Models\HistoriqueAction;
use App\Models\OffreRecrutement;
use App\Models\Referentiel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CandidatureController extends Controller
{
    /**
     * Liste des candidatures — filtres par offre, état, dossier complet/incomplet,
     * recherche par candidat (§6.6 Présélection / §15 Interfaces attendues).
     */
    public function index(Request $request): View
    {
        $filtres = array_merge(
            ['id_offre' => null, 'etat_candidature' => null, 'dossier_complet' => null, 'recherche' => null],
            $request->only(['id_offre', 'etat_candidature', 'dossier_complet', 'recherche'])
        );

        $candidatures = Candidature::query()
            ->with(['candidat', 'offre'])
            ->filtrer($filtres)
            ->orderByDesc('date_depot')
            ->paginate(15)
            ->withQueryString();

        $offres = OffreRecrutement::orderBy('intitule_poste')->get(['id_offre', 'reference_offre', 'intitule_poste']);
        $etats = Candidature::ETATS;

        return view('candidatures.index', compact('candidatures', 'offres', 'etats', 'filtres'));
    }

    public function create(Request $request): View
    {
        $candidature = new Candidature([
            'id_offre' => $request->query('id_offre'),
            'id_candidat' => $request->query('id_candidat'),
        ]);
        $candidats = Candidat::orderBy('nom')->get(['id_candidat', 'nom', 'prenom', 'cin']);

        // Seules les offres encore ouvertes acceptent de nouvelles candidatures
        // (référentiel STATUT_OFFRE : 'Ouverte' / 'Fermée').
        $offres = OffreRecrutement::where('statut', 'Ouverte')
            ->orderBy('intitule_poste')->get(['id_offre', 'reference_offre', 'intitule_poste']);

        return view('candidatures.create', compact('candidature', 'candidats', 'offres'));
    }

    public function store(CandidatureRequest $request): RedirectResponse
    {
        $candidature = Candidature::create($request->validated());

        HistoriqueAction::enregistrer('creation_candidature', 'candidatures', $candidature->id_candidature);

        return redirect()
            ->route('candidatures.show', $candidature)
            ->with('success', 'Candidature enregistrée avec succès.');
    }

    public function show(Candidature $candidature): View
    {
        $candidature->load(['candidat', 'offre', 'documents.typeDocument', 'convocations', 'evaluations']);
        $piecesManquantes = $candidature->piecesManquantes();

        $typesDocument = Referentiel::where('type_ref', 'TYPE_DOCUMENT')
            ->where('actif', 1)
            ->orderBy('libelle')
            ->get(['id_ref', 'libelle']);

        return view('candidatures.show', compact('candidature', 'piecesManquantes', 'typesDocument'));
    }

    public function edit(Candidature $candidature): View
    {
        $candidats = Candidat::orderBy('nom')->get(['id_candidat', 'nom', 'prenom', 'cin']);
        $offres = OffreRecrutement::orderBy('intitule_poste')->get(['id_offre', 'reference_offre', 'intitule_poste']);

        return view('candidatures.edit', compact('candidature', 'candidats', 'offres'));
    }

    public function update(CandidatureRequest $request, Candidature $candidature): RedirectResponse
    {
        $ancienEtat = $candidature->etat_candidature;

        $candidature->update($request->validated());

        if ($ancienEtat !== $candidature->etat_candidature) {
            HistoriqueAction::enregistrer(
                'changement_etat',
                'candidatures',
                $candidature->id_candidature,
                "État : {$ancienEtat} -> {$candidature->etat_candidature}"
            );
        } else {
            HistoriqueAction::enregistrer('modification_candidature', 'candidatures', $candidature->id_candidature);
        }

        return redirect()
            ->route('candidatures.show', $candidature)
            ->with('success', 'Candidature mise à jour avec succès.');
    }

    /**
     * Archivage au lieu de suppression définitive (§11 Sécurité et confidentialité).
     */
    public function destroy(Candidature $candidature): RedirectResponse
    {
        $candidature->etat_candidature = 'archivee';
        $candidature->save();

        HistoriqueAction::enregistrer('archivage_candidature', 'candidatures', $candidature->id_candidature);

        return redirect()->route('candidatures.index')->with('success', 'Candidature archivée.');
    }

    /**
     * Changement rapide d'état depuis la liste (présélection, rejet, convocation...) — §6.6.
     */
    public function changerEtat(Request $request, Candidature $candidature): RedirectResponse
    {
        $data = $request->validate([
            'etat_candidature' => ['required', Rule::in(array_keys(Candidature::ETATS))],
            'motif_rejet' => ['nullable', 'string', 'required_if:etat_candidature,rejetee'],
        ]);

        try {
            $candidature->changerEtat($data['etat_candidature'], $data['motif_rejet'] ?? null);
        } catch (\InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }

        HistoriqueAction::enregistrer(
            'changement_etat',
            'candidatures',
            $candidature->id_candidature,
            "Nouvel état : {$data['etat_candidature']}"
        );

        return back()->with('success', 'État de la candidature mis à jour.');
    }
}