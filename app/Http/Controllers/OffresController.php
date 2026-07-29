<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offre;
use App\Models\Referentiel;

class OffresController extends Controller
{
    /**
     * Afficher la liste des offres
     */
    public function index(Request $request)
{
    $query = Offre::query();

    // Recherche par référence, intitulé ou service
    if ($request->filled('search')) {

        $search = $request->search;

        $query->where(function ($q) use ($search) {

            $q->where('reference_offre', 'like', "%{$search}%")
              ->orWhere('intitule_poste', 'like', "%{$search}%")
              ->orWhere('service_concerne', 'like', "%{$search}%");

        });

    }

    // Filtre par type
    if ($request->filled('type_recrutement')) {

        $query->where('type_recrutement', $request->type_recrutement);

    }

    // Filtre par statut
    if ($request->filled('statut')) {

        $query->where('statut', $request->statut);

    }

    $offres = $query
        ->orderBy('date_publication', 'desc')
        ->paginate(10)
        ->withQueryString();

    return view('offres.index', compact('offres'));
}
    /**
     * Afficher le formulaire d'ajout
     */
    public function create()
    {
        $diplomes = Referentiel::where('type_ref', 'DIPLOME')->get();

        $specialites = Referentiel::where('type_ref', 'SPECIALITE')->get();

        return view('offres.create', compact('diplomes', 'specialites'));
    }

    /**
     * Enregistrer une nouvelle offre
     */
    public function store(Request $request)
    {
        $request->validate([
            'reference_offre'          => 'required|max:50',
            'intitule_poste'           => 'required|max:255',
            'type_recrutement'         => 'required',
            'nombre_postes'            => 'required|integer|min:1',
            'service_concerne'         => 'required|max:255',
            'lieu_affectation'         => 'required|max:255',
            'id_diplome_exigee'        => 'nullable|integer',
            'id_specialite_exigee'     => 'nullable|integer',
            'experience_exigee'        => 'nullable|max:255',
            'date_publication'         => 'required|date',
            'date_limite_depot'        => 'required|date|after_or_equal:date_publication',
            'statut'                   => 'required',
            'description_poste'        => 'nullable',
            'conditions_participation' => 'nullable',
            'observations'             => 'nullable'
        ]);

        Offre::create($request->all());

        return redirect()
                ->route('offres.index')
                ->with('success', 'Offre ajoutée avec succès.');
    }

    /**
     * Afficher une offre
     */
    public function show($id)
    {
        $offre = Offre::findOrFail($id);

        return view('offres.show', compact('offre'));
    }

    /**
     * Formulaire de modification
     */
    public function edit($id)
{
    $offre = Offre::findOrFail($id);

    $diplomes = Referentiel::where('type_ref', 'DIPLOME')->get();

    $specialites = Referentiel::where('type_ref', 'SPECIALITE')->get();

    return view('offres.edit', compact(
        'offre',
        'diplomes',
        'specialites'
    ));
}

    /**
     * Mettre à jour une offre
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'reference_offre'          => 'required|max:50',
            'intitule_poste'           => 'required|max:255',
            'type_recrutement'         => 'required',
            'nombre_postes'            => 'required|integer|min:1',
            'service_concerne'         => 'required|max:255',
            'lieu_affectation'         => 'required|max:255',
            'id_diplome_exigee'        => 'nullable|integer',
            'id_specialite_exigee'     => 'nullable|integer',
            'experience_exigee'        => 'nullable|max:255',
            'date_publication'         => 'required|date',
            'date_limite_depot'        => 'required|date|after_or_equal:date_publication',
            'statut'                   => 'required',
            'description_poste'        => 'nullable',
            'conditions_participation' => 'nullable',
            'observations'             => 'nullable'
        ]);

        $offre = Offre::findOrFail($id);

        $offre->update($request->all());

        return redirect()
                ->route('offres.index')
                ->with('success', 'Offre modifiée avec succès.');
    }
  

    /**
     * Supprimer une offre
     */
    /**
 * Supprimer une offre
 */
public function destroy($id)
{
    $offre = Offre::findOrFail($id);

    // Vérifier si l'offre possède des candidatures
    if ($offre->candidatures()->exists()) {

        return redirect()
            ->route('offres.index')
            ->with(
                'error',
                'Impossible de supprimer cette offre car elle possède déjà des candidatures.'
            );
    }

    // Si aucune candidature n'est liée à l'offre
    $offre->delete();

    return redirect()
        ->route('offres.index')
        ->with(
            'success',
            'Offre supprimée avec succès.'
        );
}
}