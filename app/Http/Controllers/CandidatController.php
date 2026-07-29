<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidatRequest;
use App\Models\Candidat;
use App\Models\HistoriqueAction;
use App\Models\Referentiel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CandidatController extends Controller
{
    /**
     * Liste des candidats — recherche par nom, CIN, diplôme ou ville (§15 Interfaces attendues).
     */
    public function index(Request $request): View
    {
        $candidats = Candidat::query()
            ->with(['diplome', 'specialite'])
            ->recherche($request->query('q'))
            ->when($request->query('ville'), fn ($q, $v) => $q->where('ville', $v))
            ->when($request->query('id_diplome'), fn ($q, $v) => $q->where('id_diplome', $v))
            ->withCount('candidatures')
            ->orderBy('nom')
            ->paginate(15)
            ->withQueryString();

        $villes = Candidat::query()->distinct()->orderBy('ville')->pluck('ville')->filter();
        $diplomes = Referentiel::where('type_ref', 'DIPLOME')->where('actif', true)->orderBy('libelle')->get();

        return view('candidats.index', compact('candidats', 'villes', 'diplomes'));
    }

    public function create(): View
    {
        $diplomes = Referentiel::where('type_ref', 'DIPLOME')->where('actif', true)->orderBy('libelle')->get();
        $specialites = Referentiel::where('type_ref', 'SPECIALITE')->where('actif', true)->orderBy('libelle')->get();

        return view('candidats.create', ['candidat' => new Candidat(), 'diplomes' => $diplomes, 'specialites' => $specialites]);
    }

    public function store(CandidatRequest $request): RedirectResponse
    {
        $candidat = Candidat::create($request->validated());

        HistoriqueAction::enregistrer('creation_candidat', 'candidats', $candidat->id_candidat);

        return redirect()
            ->route('candidats.show', $candidat)
            ->with('success', 'Candidat créé avec succès.');
    }

    public function show(Candidat $candidat): View
    {
        $candidat->load(['candidatures.offre', 'diplome', 'specialite']);

        return view('candidats.show', compact('candidat'));
    }

    public function edit(Candidat $candidat): View
    {
        $diplomes = Referentiel::where('type_ref', 'DIPLOME')->where('actif', true)->orderBy('libelle')->get();
        $specialites = Referentiel::where('type_ref', 'SPECIALITE')->where('actif', true)->orderBy('libelle')->get();

        return view('candidats.edit', compact('candidat', 'diplomes', 'specialites'));
    }

    public function update(CandidatRequest $request, Candidat $candidat): RedirectResponse
    {
        $candidat->update($request->validated());

        HistoriqueAction::enregistrer('modification_candidat', 'candidats', $candidat->id_candidat);

        return redirect()
            ->route('candidats.show', $candidat)
            ->with('success', 'Candidat mis à jour avec succès.');
    }

    public function destroy(Candidat $candidat): RedirectResponse
    {
        if ($candidat->candidatures()->exists()) {
            return back()->with('error', 'Impossible de supprimer ce candidat : des candidatures y sont liées.');
        }

        $id = $candidat->id_candidat;
        $candidat->delete();

        HistoriqueAction::enregistrer('suppression_candidat', 'candidats', $id);

        return redirect()->route('candidats.index')->with('success', 'Candidat supprimé.');
    }
}