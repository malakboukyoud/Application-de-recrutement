<?php
// Destination : app/Http/Controllers/EvaluationController.php

namespace App\Http\Controllers;

use App\Http\Requests\EvaluationRequest;
use App\Models\Candidat;
use App\Models\Candidature;
use App\Models\Evaluation;
use App\Models\HistoriqueAction;
use App\Models\OffreRecrutement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EvaluationController extends Controller
{
    /**
     * Liste globale des évaluations, toutes offres confondues.
     * Filtrable par offre, candidat (nom/prénom/CIN) et diplôme.
     * Triable par note écrite / orale / pratique / finale / date de saisie.
     */
    public function index(Request $request): View
    {
        $filtres = array_merge(
            ['id_offre' => null, 'id_diplome' => null, 'candidat' => null, 'tri' => 'id_evaluation', 'direction' => 'desc'],
            $request->only(['id_offre', 'id_diplome', 'candidat', 'tri', 'direction'])
        );

        // Colonnes autorisées pour le tri, afin d'éviter toute injection via le paramètre "tri".
        // La table `evaluations` n'a pas de colonne de date : on utilise id_evaluation
        // (auto-incrément) comme repère de l'ordre de saisie.
        $colonnesTriables = ['note_ecrite', 'note_orale', 'note_pratique', 'note_finale', 'id_evaluation'];
        $tri = in_array($filtres['tri'], $colonnesTriables, true) ? $filtres['tri'] : 'id_evaluation';
        $direction = $filtres['direction'] === 'asc' ? 'asc' : 'desc';
        $filtres['tri'] = $tri;
        $filtres['direction'] = $direction;

        $evaluations = Evaluation::query()
            ->with(['candidature.candidat', 'candidature.offre'])
            ->whereHas('candidature', function ($q) use ($filtres) {
                $q->when($filtres['id_offre'], fn ($qq, $v) => $qq->where('id_offre', $v));

                $q->when($filtres['candidat'], function ($qq, $v) {
                    $qq->whereHas('candidat', function ($qqq) use ($v) {
                        $qqq->where('nom', 'like', "%{$v}%")
                            ->orWhere('prenom', 'like', "%{$v}%")
                            ->orWhere('cin', 'like', "%{$v}%");
                    });
                });

                $q->when($filtres['id_diplome'], function ($qq, $v) {
                    $qq->whereHas('candidat', fn ($qqq) => $qqq->where('id_diplome', $v));
                });
            })
            ->orderBy($tri, $direction)
            ->paginate(15)
            ->withQueryString();

        $offres = OffreRecrutement::orderBy('intitule_poste')->get(['id_offre', 'reference_offre', 'intitule_poste']);
        $diplomes = Candidat::query()->distinct()->orderBy('id_diplome')->pluck('id_diplome')->filter();

        return view('evaluations.index', compact('evaluations', 'offres', 'diplomes', 'filtres'));
    }

    /**
     * Formulaire de saisie d'une évaluation pour une candidature donnée
     * (§6.7 Notes et évaluations du cahier des charges).
     */
    public function create(Candidature $candidature): View
    {
        $convocations = $candidature->convocations;
        $evaluation = new Evaluation(['id_candidature' => $candidature->id_candidature]);

        return view('evaluations.create', compact('candidature', 'convocations', 'evaluation'));
    }

    public function store(EvaluationRequest $request, Candidature $candidature): RedirectResponse
    {
        // La table `evaluations` n'a pas de colonne `saisi_par` : qui a saisi
        // l'évaluation est déjà tracé via HistoriqueAction (id_utilisateur).
        $evaluation = $candidature->evaluations()->create($request->validated());

        HistoriqueAction::enregistrer(
            'creation_evaluation',
            'evaluations',
            $evaluation->id_evaluation,
            "Candidature #{$candidature->id_candidature}"
        );

        return redirect()
            ->route('candidatures.show', $candidature)
            ->with('success', 'Évaluation enregistrée avec succès.');
    }

    public function edit(Evaluation $evaluation): View
    {
        $candidature = $evaluation->candidature;
        $convocations = $candidature->convocations;

        return view('evaluations.edit', compact('evaluation', 'candidature', 'convocations'));
    }

    public function update(EvaluationRequest $request, Evaluation $evaluation): RedirectResponse
    {
        $evaluation->update($request->validated());

        HistoriqueAction::enregistrer(
            'modification_evaluation',
            'evaluations',
            $evaluation->id_evaluation,
            "Candidature #{$evaluation->id_candidature}"
        );

        return redirect()
            ->route('candidatures.show', $evaluation->candidature)
            ->with('success', 'Évaluation mise à jour avec succès.');
    }

    public function destroy(Evaluation $evaluation): RedirectResponse
    {
        $candidature = $evaluation->candidature;
        $id = $evaluation->id_evaluation;
        $evaluation->delete();

        HistoriqueAction::enregistrer('suppression_evaluation', 'evaluations', $id);

        return redirect()
            ->route('candidatures.show', $candidature)
            ->with('success', 'Évaluation supprimée.');
    }
}
