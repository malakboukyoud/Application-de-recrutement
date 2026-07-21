<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Convocation extends Model
{
    protected $table = 'convocations';
    protected $primaryKey = 'id_convocation';
    public $timestamps = false;

    protected $fillable = [
        'id_candidature', 'type_convocation', 'date_convocation', 'heure_convocation',
        'lieu_convocation', 'statut_presence', 'observation',
    ];

    protected $casts = [
        'date_convocation' => 'date',
    ];

    public function candidature()
    {
        return $this->belongsTo(Candidature::class, 'id_candidature', 'id_candidature');
    }
}
