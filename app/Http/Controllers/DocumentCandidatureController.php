<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\DocumentCandidature;
use App\Models\HistoriqueAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentCandidatureController extends Controller
{
    /**
     * Ajouter une pièce jointe à une candidature (§6.4 Gestion des pièces jointes).
     * Formats autorisés : PDF, JPG, PNG, DOCX (§10 Gestion documentaire).
     *
     * Le type de document est une référence vers `referentiels` (id_type_document),
     * et non une chaîne libre : la table `documents_candidature` n'a pas de colonne
     * `type_document`.
     */
    public function store(Request $request, Candidature $candidature): RedirectResponse
    {
        $data = $request->validate([
            'id_type_document' => ['required', 'integer', 'exists:referentiels,id_ref'],
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