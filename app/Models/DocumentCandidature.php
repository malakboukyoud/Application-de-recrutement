<?php
// Destination : app/Models/DocumentCandidature.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentCandidature extends Model
{
    protected $table = 'documents_candidature';
    protected $primaryKey = 'id_document';
    public $timestamps = false;

    // Types de documents désormais gérés via la table `referentiels`
    // (type_ref = 'TYPE_DOCUMENT') — voir la relation typeDocument() ci-dessous.
    // Cette constante n'est plus utilisée par le formulaire, mais laissée ici
    // au cas où vous vous en serviez ailleurs.
    public const TYPES = [
        'cv' => 'CV',
        'lettre_motivation' => 'Lettre de motivation',
        'cin' => 'Copie CIN',
        'diplome' => 'Diplôme',
        'equivalence' => 'Équivalence du diplôme',
        'attestation_travail' => 'Attestation de travail',
        'releve_notes' => 'Relevé de notes',
        'photo' => 'Photo',
        'demande_manuscrite' => 'Demande manuscrite',
        'autorisation' => 'Autorisation administrative',
        'autre' => 'Autre',
    ];

    protected $fillable = [
        'id_candidature', 'id_type_document', 'nom_fichier', 'chemin_fichier',
        'ajout_par', 'observation',
    ];

    protected $casts = [
        'date_ajout' => 'datetime',
    ];

    public function candidature()
    {
        return $this->belongsTo(\App\Models\Candidature::class, 'id_candidature', 'id_candidature');
    }

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'ajout_par', 'id_utilisateur');
    }

    public function typeDocument()
    {
        return $this->belongsTo(\App\Models\Referentiel::class, 'id_type_document', 'id_ref');
    }
}