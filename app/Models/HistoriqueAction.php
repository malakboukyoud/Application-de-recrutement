<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriqueAction extends Model
{
    protected $table = 'historique_actions';
    protected $primaryKey = 'id_historique';
    public $timestamps = false;

    protected $fillable = [
        'id_utilisateur', 'action', 'table_concernee', 'id_enregistrement', 'detail_action',
    ];

    protected $casts = [
        'date_action' => 'datetime',
    ];

    /**
     * Enregistre une action dans le journal d'audit (§12 du cahier des charges).
     * Ne doit jamais faire échouer l'action métier appelante : si aucun
     * utilisateur authentifié n'existe (auth non encore branchée) et
     * qu'aucun utilisateur par défaut n'est disponible en base, ou si
     * l'insertion échoue pour toute autre raison, on journalise l'erreur
     * dans les logs applicatifs et on continue silencieusement.
     */
    public static function enregistrer(string $action, string $table, int $idEnregistrement, ?string $detail = null): void
    {
        $idUtilisateur = auth()->id() ?? Utilisateur::query()->value('id_utilisateur');

        if (! $idUtilisateur) {
            \Log::warning("Historique non enregistré (aucun utilisateur disponible) : {$action} sur {$table}#{$idEnregistrement}");

            return;
        }

        try {
            self::create([
                'id_utilisateur' => $idUtilisateur,
                'action' => $action,
                'table_concernee' => $table,
                'id_enregistrement' => $idEnregistrement,
                'detail_action' => $detail,
            ]);
        } catch (\Throwable $e) {
            \Log::warning("Échec de l'enregistrement dans l'historique : {$e->getMessage()}");
        }
    }

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur', 'id_utilisateur');
    }
}
