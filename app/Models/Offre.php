<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offre extends Model
{
    protected $table = 'offres_recrutement';

    protected $primaryKey = 'id_offre';

    public $timestamps = false;

    protected $fillable = [
        'reference_offre',
        'intitule_poste',
        'type_recrutement',
        'nombre_postes',
        'service_concerne',
        'lieu_affectation',
        'id_diplome_exigee',
        'id_specialite_exigee',
        'experience_exigee',
        'date_publication',
        'date_limite_depot',
        'statut',
        'description_poste',
        'conditions_participation',
        'observations',
    ];

    public function candidatures()
    {
        return $this->hasMany(
            Candidature::class,
            'id_offre',
            'id_offre'
        );
    }
}