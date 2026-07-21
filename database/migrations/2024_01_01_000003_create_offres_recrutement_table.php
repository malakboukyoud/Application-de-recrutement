<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offres_recrutement', function (Blueprint $table) {
            $table->id('id_offre');
            $table->string('reference_offre', 50)->unique();
            $table->string('intitule_poste', 150);
            $table->string('type_recrutement', 50); // concours, contractuel, stage...
            $table->integer('nombre_postes')->default(1);
            $table->string('service_concerne', 100)->nullable();
            $table->string('lieu_affectation', 100)->nullable();
            $table->foreignId('id_diplome_exige')->nullable()
                ->constrained('referentiels', 'id_ref')->nullOnDelete();
            $table->foreignId('id_specialite_exigee')->nullable()
                ->constrained('referentiels', 'id_ref')->nullOnDelete();
            $table->string('experience_exigee', 100)->nullable();
            $table->date('date_publication')->nullable();
            $table->date('date_limite_depot')->nullable();
            $table->enum('statut', [
                'en_preparation', 'publiee', 'cloturee', 'en_traitement', 'finalisee', 'annulee',
            ])->default('en_preparation');
            $table->text('description_poste')->nullable();
            $table->text('conditions_participation')->nullable();
            $table->text('pieces_exigees')->nullable();
            $table->text('observations')->nullable();
            $table->foreignId('id_createur')
                ->constrained('utilisateurs', 'id_utilisateur')->restrictOnDelete();

            $table->index('statut', 'idx_offre_statut');
        });

        // Contrainte de gestion : date_limite_depot >= date_publication.
        // SQLite ne supporte pas "ALTER TABLE ... ADD CONSTRAINT" : la règle
        // est de toute façon appliquée par la validation (OffreRequest) et
        // n'est ajoutée au niveau base que sur MySQL/MariaDB.
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE offres_recrutement
                ADD CONSTRAINT chk_offre_dates
                CHECK (date_limite_depot IS NULL OR date_publication IS NULL OR date_limite_depot >= date_publication)');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('offres_recrutement');
    }
};
