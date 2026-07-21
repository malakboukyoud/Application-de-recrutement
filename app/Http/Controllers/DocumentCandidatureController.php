<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\DocumentCandidature;
use App\Models\HistoriqueAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DocumentCandidatureController extends Controller
{
    /**
     * Ajouter une pièce jointe à une candidature (§6.4 Gestion des pièces jointes).
     * Formats autorisés : PDF, JPG, PNG, DOCX (§10 Gestion documentaire).
     */
    public function store(Request $request, Candidature $candidature): RedirectResponse
    {
        $data = $request->validate([
            'type_document' => ['required', Rule::in(array_keys(DocumentCandidature::TYPES))],
            'fichier' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png,docx', 'max:10240'],
            'observation' => ['nullable', 'string'],
        ]);

        $nomOriginal = $data['fichier']->getClientOriginalName();
        $chemin = $data['fichier']->store(
            "candidatures/{$candidature->id_candidature}",
            'local' // stockage privé : accès limité aux dossiers de candidature (§17 Sécurité)
        );

        $document = $candidature->documents()->create([
            'type_document' => $data['type_document'],
            'nom_fichier' => $nomOriginal,
            'chemin_fichier' => $chemin,
            'ajoute_par' => auth()->id() ?? 1,
            'observation' => $data['observation'] ?? null,
        ]);

        // Mise à jour automatique de l'indicateur "dossier complet / incomplet"
        $manquantes = $candidature->fresh(['documents', 'offre'])->piecesManquantes();
        $candidature->update(['dossier_complet' => empty($manquantes)]);

        HistoriqueAction::enregistrer('ajout_document', 'documents_candidature', $document->id_document,
            "Type : {$data['type_document']}");

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
