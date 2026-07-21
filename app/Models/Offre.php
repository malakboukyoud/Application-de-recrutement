<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offre extends Model
{
    // Nom de la table dans MySQL
    protected $table = 'offres_recrutement';

    // Clé primaire
    protected $primaryKey = 'id_offre';

    // Laravel ne doit pas chercher created_at / updated_at
    public $timestamps = false;

    // Champs autorisés pour create() et update()
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
        'observations'
    ];
}