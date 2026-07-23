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
        'profil',
        'id_profil',
        'actif',
    ];

    protected $hidden = ['mot_de_passe'];

    protected $casts = [
        'actif' => 'boolean',
        'date_creation' => 'datetime',
    ];

    // Laravel utilise "password" pour l'authentification : on mappe sur mot_de_passe
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    // Relation avec le profil (Référentiel)
    public function profil()
    {
        return $this->belongsTo(
            Referentiel::class,
            'id_profil',
            'id_ref'
        );
    }

    public function offres()
    {
        return $this->hasMany(OffreRecrutement::class, 'id_createur', 'id_utilisateur');
    }

    public function documentsAjoutes()
    {
        return $this->hasMany(DocumentCandidature::class, 'ajoute_par', 'id_utilisateur');
    }

    public function isAdmin(): bool
    {
        return $this->profil === 'admin';
    }

    public function isRh(): bool
    {
        return in_array($this->profil, ['admin', 'rh']);
    }
}