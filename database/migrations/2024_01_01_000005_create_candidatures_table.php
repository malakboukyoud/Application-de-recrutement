<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidatures', function (Blueprint $table) {
            $table->id('id_candidature');
            $table->string('numero_candidature', 50)->unique();
            $table->foreignId('id_candidat')
                ->constrained('candidats', 'id_candidat')->restrictOnDelete();
            $table->foreignId('id_offre')
                ->constrained('offres_recrutement', 'id_offre')->restrictOnDelete();
            $table->date('date_depot');
            $table->enum('mode_depot', ['papier', 'email', 'plateforme', 'courrier', 'autre']);
            $table->enum('etat_candidature', [
                'recue', 'incomplete', 'complete', 'en_etude', 'preselectionnee',
                'rejetee', 'convoquee', 'admise', 'liste_attente', 'non_admise', 'archivee',
            ])->default('recue');
            $table->boolean('dossier_complet')->default(false);
            $table->text('motif_rejet')->nullable();
            $table->integer('classement')->nullable();
            $table->enum('decision_finale', ['admis', 'liste_attente', 'non_admis', 'absent'])->nullable();
            $table->text('observation_rh')->nullable();
            $table->text('observation_commission')->nullable();
            $table->timestamps();

            // un même candidat ne peut postuler qu'une fois à une même offre
            $table->unique(['id_candidat', 'id_offre'], 'uq_candidat_offre');
            $table->index('etat_candidature', 'idx_candidature_etat');
            $table->index('id_offre', 'idx_candidature_offre');
        });

        // règle de gestion : motif de rejet obligatoire si la candidature est rejetée.
        // Déjà appliquée par CandidatureRequest et Candidature::changerEtat() ;
        // ajoutée en base uniquement sur MySQL/MariaDB (SQLite ne supporte pas
        // "ALTER TABLE ... ADD CONSTRAINT").
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE candidatures
                ADD CONSTRAINT chk_motif_rejet
                CHECK (etat_candidature <> 'rejetee' OR motif_rejet IS NOT NULL)");
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('candidatures');
    }
};
