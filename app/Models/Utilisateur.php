<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Referentiel;

class Utilisateur extends Model
{
    // Nom de la table
    protected $table = 'utilisateurs';

    // Clé primaire
    protected $primaryKey = 'id_utilisateur';

    // Les champs que Laravel peut remplir
    protected $fillable = [
        'nom',
        'prenom',
        'login',
        'email',
        'mot_de_passe',
        'id_profil',
        'actif'
    ];

    // Laravel gère automatiquement created_at et updated_at.
    // Ta table n'a pas ces colonnes, donc on les désactive.
    public $timestamps = false;
    public function profil()
{
    return $this->belongsTo(Referentiel::class, 'id_profil', 'id_ref');
}
    
}
