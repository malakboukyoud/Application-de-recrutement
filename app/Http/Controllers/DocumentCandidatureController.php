<?php
// Destination : app/Http/Controllers/DocumentCandidatureController.php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Candidature;
use App\Models\DocumentCandidature;
use App\Models\HistoriqueAction;
use App\Models\OffreRecrutement;
use App\Models\Referentiel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DocumentCandidatureController extends Controller
{
    /**
     * Liste globale des documents déposés, toutes candidatures / offres confondues.
     * Filtrable par offre, candidat (nom/prénom/CIN), diplôme et type de document.
     * Triable par date d'ajout ou nom de fichier.
     */
    public function index(Request $request): View
    {
        $filtres = array_merge(
            ['id_offre' => null, 'id_diplome' => null, 'candidat' => null, 'id_type_document' => null, 'tri' => 'date_ajout', 'direction' => 'desc'],
            $request->only(['id_offre', 'id_diplome', 'candidat', 'id_type_document', 'tri', 'direction'])
        );

        // Colonnes autorisées pour le tri, afin d'éviter toute injection via le paramètre "tri"
        $colonnesTriables = ['date_ajout', 'nom_fichier'];
        $tri = in_array($filtres['tri'], $colonnesTriables, true) ? $filtres['tri'] : 'date_ajout';
        $direction = $filtres['direction'] === 'asc' ? 'asc' : 'desc';
        $filtres['tri'] = $tri;
        $filtres['direction'] = $direction;

        $documents = DocumentCandidature::query()
            ->with(['candidature.candidat', 'candidature.offre', 'typeDocument'])
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
            ->when($filtres['id_type_document'], fn ($q, $v) => $q->where('id_type_document', $v))
            ->orderBy($tri, $direction)
            ->paginate(15)
            ->withQueryString();

        $offres = OffreRecrutement::orderBy('intitule_poste')->get(['id_offre', 'reference_offre', 'intitule_poste']);
        $diplomes = Candidat::query()->distinct()->orderBy('id_diplome')->pluck('id_diplome')->filter();
        $typesDocument = Referentiel::where('type_ref', 'TYPE_DOCUMENT')
            ->where('actif', 1)
            ->orderBy('libelle')
            ->get(['id_ref', 'libelle']);

        return view('documents.index', compact('documents', 'offres', 'diplomes', 'typesDocument', 'filtres'));
    }

    /**
     * Ajouter une pièce jointe à une candidature (§6.4 Gestion des pièces jointes).
     * Formats autorisés : PDF, JPG, PNG, DOCX (§10 Gestion documentaire).
     *
     * Le type de document est une référence vers `referentiels` (id_type_document),
     * catégorie `TYPE_DOCUMENT` (photo, CV, copie CIN, diplôme...).
     */
    public function store(Request $request, Candidature $candidature): RedirectResponse
    {
        $data = $request->validate([
            'id_type_document' => [
                'required', 'integer',
                Rule::exists('referentiels', 'id_ref')->where('type_ref', 'TYPE_DOCUMENT')->where('actif', 1),
            ],
            'fichier' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png,docx', 'max:10240'],
            'observation' => ['nullable', 'string'],
        ]);

        $nomOriginal = $data['fichier']->getClientOriginalName();
        $chemin = $data['fichier']->store(
            "candidatures/{$candidature->id_candidature}",
            'local' // stockage privé : accès limité aux dossiers de candidature (§17 Sécurité)
        );

        $document = $candidature->documents()->create([
            'id_type_document' => $data['id_type_document'],
            'nom_fichier' => $nomOriginal,
            'chemin_fichier' => $chemin,
            'ajout_par' => $this->currentUserId(),
            'observation' => $data['observation'] ?? null,
        ]);

        // Mise à jour automatique de l'indicateur "dossier complet / incomplet"
        $manquantes = $candidature->fresh(['documents', 'offre'])->piecesManquantes();
        $candidature->update(['dossier_complet' => empty($manquantes)]);

        HistoriqueAction::enregistrer('ajout_document', 'documents_candidature', $document->id_document,
            "Type de document (référentiel) : {$data['id_type_document']}");

        return back()->with('success', 'Document ajouté avec succès.');
    }

    public function destroy(Candidature $candidature, DocumentCandidature $document): RedirectResponse
    {
        Storage::disk('local')->delete($document->chemin_fichier);

        $id = $document->id_document;
        $document->delete();

        HistoriqueAction::enregistrer('suppression_document', 'documents_candidature', $id);

        $manquantes = $candidature->fresh(['documents', 'offre'])->piecesManquantes();
        $candidature->update(['dossier_complet' => empty($manquantes)]);

        return back()->with('success', 'Document supprimé.');
    }

    public function download(Candidature $candidature, DocumentCandidature $document)
    {
        return Storage::disk('local')->download($document->chemin_fichier, $document->nom_fichier);
    }
}