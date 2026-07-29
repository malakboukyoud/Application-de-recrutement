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

    /*
    |--------------------------------------------------------------------------
    | Profils (référentiel type_ref = 'PROFIL') — §11 du cahier des charges
    |--------------------------------------------------------------------------
    | Ces libellés correspondent EXACTEMENT aux valeurs de votre table
    | `referentiels` (id_ref 1 à 5, type_ref = 'PROFIL') :
    |   1 Administrateur | 2 RH | 3 Commission | 4 Consultation
    |   5 Responsable de service
    */
    public const PROFIL_ADMINISTRATEUR = 'Administrateur';
    public const PROFIL_RH = 'RH';
    public const PROFIL_COMMISSION = 'Commission';
    public const PROFIL_RESPONSABLE_SERVICE = 'Responsable de service';
    public const PROFIL_CONSULTATION = 'Consultation';

    public const PROFILS = [
        self::PROFIL_ADMINISTRATEUR,
        self::PROFIL_RH,
        self::PROFIL_COMMISSION,
        self::PROFIL_RESPONSABLE_SERVICE,
        self::PROFIL_CONSULTATION,
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

    /*
    |--------------------------------------------------------------------------
    | Vérifications de profil
    |--------------------------------------------------------------------------
    | Fonctionnent aussi bien sur un modèle Eloquent Utilisateur (relation
    | `profil()`) que sur l'objet stdClass stocké en session par AuthController
    | (qui expose déjà `profil` comme chaîne via le join utilisateurs+référentiels).
    */

    private function libelleProfil(): string
    {
        // Cas objet session (stdClass avec ->profil = libellé texte)
        if (is_string($this->profil ?? null)) {
            return strtolower(trim($this->profil));
        }

        // Cas modèle Eloquent (relation ->profil vers Referentiel)
        return strtolower(trim($this->profil?->libelle ?? ''));
    }

    public function isAdmin(): bool
    {
        return $this->libelleProfil() === strtolower(self::PROFIL_ADMINISTRATEUR);
    }

    public function isRh(): bool
    {
        return $this->isAdmin() || $this->libelleProfil() === strtolower(self::PROFIL_RH);
    }

    public function isCommission(): bool
    {
        return $this->isAdmin() || $this->libelleProfil() === strtolower(self::PROFIL_COMMISSION);
    }

    public function isResponsableService(): bool
    {
        return $this->isAdmin() || $this->libelleProfil() === strtolower(self::PROFIL_RESPONSABLE_SERVICE);
    }

    public function isConsultation(): bool
    {
        return $this->isAdmin() || $this->libelleProfil() === strtolower(self::PROFIL_CONSULTATION);
    }

    /**
     * Vrai si le profil de l'utilisateur fait partie de la liste donnée.
     * L'Administrateur est toujours inclus.
     */
    public function aUnProfilParmi(array $profils): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        $profils = array_map('strtolower', $profils);

        return in_array($this->libelleProfil(), $profils, true);
    }

    /**
     * Vrai si l'utilisateur peut voir les données personnelles sensibles des
     * candidats (CIN, adresse, téléphone, email...) — §17 : "Les données
     * personnelles des candidats doivent être consultées uniquement par les
     * utilisateurs autorisés."
     * Seuls Administrateur et RH ont un accès complet ; les autres profils
     * voient une fiche candidat allégée (nom, diplôme, état du dossier)
     * sans coordonnées personnelles.
     */
    public function peutVoirDonneesPersonnelles(): bool
    {
        return $this->isAdmin() || $this->isRh();
    }
}