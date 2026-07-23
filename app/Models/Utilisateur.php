<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{

    protected $table = 'utilisateurs';


    protected $primaryKey = 'id_utilisateur';


    public $timestamps = false;



    protected $fillable = [
        'nom',
        'prenom',
        'login',
        'email',
        'mot_de_passe',
        'id_profil',
        'actif'
    ];



    // Relation avec le profil
    public function profil()
    {
        return $this->belongsTo(
            Referentiel::class,
            'id_profil',
            'id_ref'
        );
    }

}