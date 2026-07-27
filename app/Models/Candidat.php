<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidat extends Model
{
    protected $table = 'candidats';
    protected $primaryKey = 'id_candidat';

    protected $fillable = [
        'nom', 'prenom', 'sexe', 'date_naissance', 'lieu_naissance', 'cin',
        'adresse', 'ville', 'telephone', 'email', 'niveau_etude', 'diplome',
        'specialite', 'etablissement', 'annee_obtention', 'experience',
        'situation_actuelle', 'observations',
    ];

    protected $casts = [
        'date_naissance' => 'date',
    ];

    public function candidatures()
    {
        return $this->hasMany(Candidature::class, 'id_candidat', 'id_candidat');
    }

    public function getNomCompletAttribute(): string
    {
        return trim("{$this->prenom} {$this->nom}");
    }

    // Recherche par nom, prénom, CIN, diplôme ou ville (interface "Liste des candidats")
    public function scopeRecherche($query, ?string $terme)
    {
        if (! $terme) {
            return $query;
        }

        return $query->where(function ($q) use ($terme) {
            $q->where('nom', 'like', "%{$terme}%")
                ->orWhere('prenom', 'like', "%{$terme}%")
                ->orWhere('cin', 'like', "%{$terme}%")
                ->orWhere('diplome', 'like', "%{$terme}%")
                ->orWhere('ville', 'like', "%{$terme}%");
        });
    }
}
