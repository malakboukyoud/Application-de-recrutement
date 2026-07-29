<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Candidature extends Model
{
    protected $table = 'candidatures';
    protected $primaryKey = 'id_candidature';

    public const ETATS = [
        'recue' => 'Reçue',
        'incomplete' => 'Dossier incomplet',
        'complete' => 'Dossier complet',
        'en_etude' => "En cours d'étude",
        'preselectionnee' => 'Présélectionnée',
        'rejetee' => 'Rejetée',
        'convoquee' => 'Convoquée',
        'admise' => 'Admise',
        'liste_attente' => "Liste d'attente",
        'non_admise' => 'Non admise',
        'archivee' => 'Archivée',
    ];

    public const MODES_DEPOT = ['papier', 'email', 'plateforme', 'courrier', 'autre'];

    public const DECISIONS = ['admis', 'liste_attente', 'non_admis', 'absent'];

    protected $fillable = [
        'numero_candidature', 'id_candidat', 'id_offre', 'date_depot', 'mode_depot',
        'etat_candidature', 'dossier_complet', 'motif_rejet', 'classement',
        'decision_finale', 'observation_rh', 'observation_commission',
    ];

    protected $casts = [
        'date_depot' => 'date',
        'dossier_complet' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Candidature $candidature) {
            if (empty($candidature->numero_candidature)) {
                $candidature->numero_candidature = 'CAND-' . now()->format('Y') . '-' . Str::upper(Str::random(6));
            }
        });
    }

    public function candidat()
    {
        return $this->belongsTo(Candidat::class, 'id_candidat', 'id_candidat');
    }

    public function offre()
    {
        return $this->belongsTo(OffreRecrutement::class, 'id_offre', 'id_offre');
    }

    public function documents()
    {
        return $this->hasMany(DocumentCandidature::class, 'id_candidature', 'id_candidature');
    }

    public function convocations()
    {
        return $this->hasMany(Convocation::class, 'id_candidature', 'id_candidature');
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'id_candidature', 'id_candidature');
    }

    /**
     * Pièces exigées par l'offre vs pièces déjà déposées -> permet d'afficher
     * les documents manquants (§6.4 / §10 du cahier des charges).
     */
    public function piecesManquantes(): array
    {
        $exigees = collect(explode(',', (string) optional($this->offre)->pieces_exigees))
            ->map(fn ($p) => trim($p))
            ->filter();

        $deposees = $this->documents->pluck('type_document')->map(fn ($t) => strtolower($t));

        return $exigees->reject(fn ($p) => $deposees->contains(strtolower($p)))->values()->all();
    }

    // Filtres attendus par l'interface "Liste des candidatures"
    public function scopeFiltrer($query, array $filtres)
    {
        return $query
            ->when($filtres['id_offre'] ?? null, fn ($q, $v) => $q->where('id_offre', $v))
            ->when($filtres['etat_candidature'] ?? null, fn ($q, $v) => $q->where('etat_candidature', $v))
            ->when(array_key_exists('dossier_complet', $filtres) && $filtres['dossier_complet'] !== null && $filtres['dossier_complet'] !== '',
                fn ($q) => $q->where('dossier_complet', (bool) $filtres['dossier_complet']))
            ->when($filtres['recherche'] ?? null, function ($q, $terme) {
                $q->whereHas('candidat', function ($qc) use ($terme) {
                    $qc->where('nom', 'like', "%{$terme}%")
                        ->orWhere('prenom', 'like', "%{$terme}%")
                        ->orWhere('cin', 'like', "%{$terme}%");
                });
            });
    }

    /**
     * Règle de gestion : une candidature rejetée doit avoir un motif,
     * une candidature "convoquée" doit avoir au moins une convocation.
     */
    public function changerEtat(string $nouvelEtat, ?string $motifRejet = null): void
    {
        if ($nouvelEtat === 'rejetee' && empty($motifRejet) && empty($this->motif_rejet)) {
            throw new \InvalidArgumentException('Un motif de rejet est obligatoire pour rejeter une candidature.');
        }

        // Un candidat absent ne doit pas être classé comme admis
        if ($nouvelEtat === 'admise' && $this->convocations()->where('statut_presence', 'absent')->exists()) {
            throw new \InvalidArgumentException('Un candidat marqué absent ne peut pas être admis.');
        }

        $this->etat_candidature = $nouvelEtat;
        if ($motifRejet) {
            $this->motif_rejet = $motifRejet;
        }
        $this->save();
    }

    public function libelleEtat(): string
    {
        return self::ETATS[$this->etat_candidature] ?? $this->etat_candidature;
    }
    public function convocation()
{
    return $this->hasOne(
        Convocation::class,
        'id_candidature',
        'id_candidature'
    );
}
}
