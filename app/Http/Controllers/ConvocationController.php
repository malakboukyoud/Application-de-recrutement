<?php

namespace App\Http\Controllers;

use App\Models\Convocation;
use App\Models\Candidature;
use Illuminate\Http\Request;

class ConvocationController extends Controller
{
    /**
     * Liste des convocations
     */
    public function index(Request $request)
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

        $convocations = $query
            ->orderBy('date_convocation', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view(
            'convocations.index',
            compact('convocations')
        );
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
}