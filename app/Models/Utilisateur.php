<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Utilisateur extends Authenticatable
{
    use HasFactory, Notifiable;


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
        'actif',
    ];


    protected $hidden = [
        'mot_de_passe'
    ];


    protected $casts = [
        'actif' => 'boolean',
        'date_creation' => 'datetime',
    ];



    // Mot de passe utilisé par Laravel Auth
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }



    // Relation avec le référentiel des profils
    public function profil()
    {
        return $this->belongsTo(
            Referentiel::class,
            'id_profil',
            'id_ref'
        );
    }



    // Offres créées par l'utilisateur
    public function offres()
    {
        return $this->hasMany(
            OffreRecrutement::class,
            'id_createur',
            'id_utilisateur'
        );
    }



    // Documents ajoutés
    public function documentsAjoutes()
    {
        return $this->hasMany(
            DocumentCandidature::class,
            'ajoute_par',
            'id_utilisateur'
        );
    }



    // Vérification administrateur
    public function isAdmin(): bool
    {
        return $this->profil 
            && strtolower($this->profil->libelle) === 'admin';
    }



    // Vérification RH
    public function isRh(): bool
    {
        return $this->profil 
            && in_array(
                strtolower($this->profil->libelle),
                ['admin','rh','responsable rh']
            );
    }
}