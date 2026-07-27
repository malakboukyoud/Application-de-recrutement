<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentCandidature extends Model
{
    protected $table = 'documents_candidature';
    protected $primaryKey = 'id_document';
    public $timestamps = false;

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
        'id_candidature', 'type_document', 'nom_fichier', 'chemin_fichier',
        'ajoute_par', 'observation',
    ];

    protected $casts = [
        'date_ajout' => 'datetime',
    ];

    public function candidature()
    {
        return $this->belongsTo(Candidature::class, 'id_candidature', 'id_candidature');
    }

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'ajoute_par', 'id_utilisateur');
    }
    public function typeDocument()
    {
    return $this->belongsTo(Referentiel::class, 'id_type_document', 'id_ref');
    }
}
