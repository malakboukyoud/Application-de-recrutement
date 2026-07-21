<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OffreRecrutement extends Model
{
    protected $table = 'offres_recrutement';
    protected $primaryKey = 'id_offre';
    public $timestamps = false;

    protected $fillable = [
        'reference_offre', 'intitule_poste', 'type_recrutement', 'nombre_postes',
        'service_concerne', 'lieu_affectation', 'id_diplome_exige', 'id_specialite_exigee',
        'experience_exigee', 'date_publication', 'date_limite_depot', 'statut',
        'description_poste', 'conditions_participation', 'pieces_exigees', 'observations',
        'id_createur',
    ];

    protected $casts = [
        'date_publication' => 'date',
        'date_limite_depot' => 'date',
    ];

    public function createur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_createur', 'id_utilisateur');
    }

    public function diplomeExige()
    {
        return $this->belongsTo(Referentiel::class, 'id_diplome_exige', 'id_ref');
    }

    public function specialiteExigee()
    {
        return $this->belongsTo(Referentiel::class, 'id_specialite_exigee', 'id_ref');
    }

    public function candidatures()
    {
        return $this->hasMany(Candidature::class, 'id_offre', 'id_offre');
    }
}
