<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Evaluation extends Model
{
    protected $table = 'evaluations';
    protected $primaryKey = 'id_evaluation';
    public $timestamps = false;

    // note_finale est une colonne calculée en base : jamais dans $fillable
    protected $fillable = [
    'id_candidature',
    'id_convocation',
    'note_ecrite',
    'note_orale',
    'note_pratique',
    'coefficient_ecrit',
    'coefficient_oral',
    'coefficient_pratique',
    'appreciation',
    'decision_finale',
    'saisi_par',
];

    protected $casts = [
        'date_saisie' => 'datetime',
    ];

    protected static function booted(): void
    {
        // Sous MySQL/MariaDB, note_finale est une colonne générée par la base
        // (voir la migration) : on ne la recalcule pas ici pour ne pas entrer
        // en conflit avec la colonne STORED. Sous les autres moteurs (SQLite
        // en développement, PostgreSQL...), on la calcule côté application
        // pour reproduire fidèlement la même règle de gestion.
        static::saving(function (Evaluation $evaluation) {
            if (DB::connection()->getDriverName() === 'mysql') {
                return;
            }

            $composantes = [
                [$evaluation->note_ecrite, $evaluation->coefficient_ecrit ?? 1],
                [$evaluation->note_orale, $evaluation->coefficient_oral ?? 1],
                [$evaluation->note_pratique, $evaluation->coefficient_pratique ?? 1],
            ];

            $sommePonderee = 0;
            $sommeCoefficients = 0;

            foreach ($composantes as [$note, $coefficient]) {
                if ($note !== null) {
                    $sommePonderee += $note * $coefficient;
                    $sommeCoefficients += $coefficient;
                }
            }

            $evaluation->note_finale = $sommeCoefficients > 0
                ? round($sommePonderee / $sommeCoefficients, 2)
                : null;
        });
    }

    public function candidature()
    {
        return $this->belongsTo(Candidature::class, 'id_candidature', 'id_candidature');
    }

    public function convocation()
    {
        return $this->belongsTo(Convocation::class, 'id_convocation', 'id_convocation');
    }

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'saisi_par', 'id_utilisateur');
    }
}
