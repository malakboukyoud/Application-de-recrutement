<?php
// Destination : app/Models/ParametreOrganisme.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParametreOrganisme extends Model
{
    protected $table = 'parametres_organisme';

    protected $fillable = [
        'nom_organisme', 'sigle', 'adresse', 'telephone', 'email', 'logo_path',
    ];

    /**
     * Cette table ne contient qu'une seule ligne (paramètres globaux de l'organisme).
     * Cette méthode la récupère, ou la crée si elle n'existe pas encore.
     */
    public static function instance(): self
    {
        return static::query()->first() ?? static::create([]);
    }
}
