<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referentiel extends Model
{
    protected $table = 'referentiels';

    protected $primaryKey = 'id_ref';

    public $timestamps = false;

    protected $fillable = [
        'type_ref',
        'libelle',
        'actif'
    ];
}