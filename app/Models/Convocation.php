<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Convocation extends Model
{
    protected $table = 'convocations';

    protected $primaryKey = 'id_convocation';

    public $timestamps = false;

    protected $fillable = [
        'id_candidature',
        'date_convocation',
        'heure_convocation',
        'type_convocation',
        'lieu_convocation',
        'statut_presence',
        'observation',
    ];

    /**
     * Une convocation appartient à une candidature
     */
    public function candidature()
    {
        return $this->belongsTo(
            Candidature::class,
            'id_candidature',
            'id_candidature'
        );
    }
}
