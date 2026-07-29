<?php

namespace App\Http\Controllers;

use App\Models\Convocation;
use App\Models\Candidature;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ConvocationsExport;
use Illuminate\Http\Request;

class ConvocationController extends Controller
{
    /**
     * Liste des convocations
     */
    public function index(Request $request)
    {
        $convocations = $this->convocationsFiltrees($request)
            ->paginate(10)
            ->withQueryString();

        return view(
            'convocations.index',
            compact('convocations')
        );
    }

    /**
     * Requête des convocations avec les mêmes filtres (recherche, statut de
     * présence) que la page liste — réutilisée par index() et les exports,
     * pour que les fichiers exportés correspondent à ce qui est affiché.
     */
    private function convocationsFiltrees(Request $request)
    {
        $query = Convocation::with([
            'candidature.candidat',
            'candidature.offre'
        ]);

        // Recherche
        if ($request->filled('search')) {

            $search = $request->search;

            $query->whereHas('candidature.candidat', function ($q) use ($search) {

                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%");

            });

        }

        // Filtre présence
        if ($request->filled('statut_presence')) {

            $query->where(
                'statut_presence',
                $request->statut_presence
            );

        }

        return $query->orderBy('date_convocation', 'desc');
    }

    /**
     * Formulaire création
     */
    public function create()
    {
        $candidatures = Candidature::with([
            'candidat',
            'offre'
        ])->get();

        return view(
            'convocations.create',
            compact('candidatures')
        );
    }

    /**
     * Enregistrer
     */
    public function store(Request $request)
    {
        $request->validate([

            'id_candidature'    => 'required|exists:candidatures,id_candidature',
            'date_convocation'  => 'required|date',
            'heure_convocation' => 'required',
            'type_convocation'  => 'required|max:50',
            'lieu_convocation'  => 'required|max:150',
            'statut_presence'   => 'nullable|max:50',
            'observation'       => 'nullable|max:5000',

        ]);

        Convocation::create($request->all());

        return redirect()
            ->route('convocations.index')
            ->with(
                'success',
                'Convocation ajoutée avec succès.'
            );
    }

    /**
     * Affichage
     */
    public function show($id)
    {
        $convocation = Convocation::with([
            'candidature.candidat',
            'candidature.offre'
        ])->findOrFail($id);

        return view(
            'convocations.show',
            compact('convocation')
        );
    }

    /**
     * Formulaire modification
     */
    public function edit($id)
    {
        $convocation = Convocation::findOrFail($id);

        $candidatures = Candidature::with([
            'candidat',
            'offre'
        ])->get();

        return view(
            'convocations.edit',
            compact(
                'convocation',
                'candidatures'
            )
        );
    }

    /**
     * Mise à jour
     */
    public function update(Request $request, $id)
    {
        $request->validate([

            'id_candidature'    => 'required|exists:candidatures,id_candidature',
            'date_convocation'  => 'required|date',
            'heure_convocation' => 'required',
            'type_convocation'  => 'required|max:50',
            'lieu_convocation'  => 'required|max:150',
            'statut_presence'   => 'nullable|max:50',
            'observation'       => 'nullable|max:5000',

        ]);

        $convocation = Convocation::findOrFail($id);

        $convocation->update($request->all());

        return redirect()
            ->route('convocations.index')
            ->with(
                'success',
                'Convocation modifiée avec succès.'
            );
    }

    /**
     * Suppression
     */
    public function destroy($id)
    {
        $convocation = Convocation::findOrFail($id);

        $convocation->delete();

        return redirect()
            ->route('convocations.index')
            ->with(
                'success',
                'Convocation supprimée avec succès.'
            );
    }

    /**
     * Export Excel de la liste des candidats convoqués (mêmes filtres que la page).
     */
    public function exportExcel(Request $request)
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\ConvocationsExport($request->only(['search', 'statut_presence'])),
            'candidats_convoques.xlsx'
        );
    }

    /**
     * Export PDF de la liste des candidats convoqués (mêmes filtres que la page).
     */
    public function exportPdf(Request $request)
    {
        $convocations = $this->convocationsFiltrees($request)->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            'convocations.pdf',
            compact('convocations')
        );

        return $pdf->download('liste_candidats_convoques.pdf');
    }
}