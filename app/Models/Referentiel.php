<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referentiel extends Model
{
    protected $table = 'referentiels';
    protected $primaryKey = 'id_ref';
    public $timestamps = false;

    protected $fillable = ['type_ref', 'libelle', 'actif'];

    protected $casts = ['actif' => 'boolean'];

    public function scopeType($query, string $type)
    {
        return $query->where('type_ref', $type)->where('actif', true);
    }
}
