<?php

namespace App\Http\Controllers;

use App\Http\Requests\EvaluationRequest;
use App\Models\Candidature;
use App\Models\Evaluation;
use App\Models\HistoriqueAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EvaluationController extends Controller
{
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
        $evaluation = $candidature->evaluations()->create($request->validated() + [
            'saisi_par' => auth()->id() ?? \App\Models\Utilisateur::query()->value('id_utilisateur'),
        ]);

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
