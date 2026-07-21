<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents_candidature', function (Blueprint $table) {
            $table->id('id_document');
            $table->foreignId('id_candidature')
                ->constrained('candidatures', 'id_candidature')->cascadeOnDelete();
            $table->enum('type_document', [
                'cv', 'lettre_motivation', 'cin', 'diplome', 'equivalence',
                'attestation_travail', 'releve_notes', 'photo',
                'demande_manuscrite', 'autorisation', 'autre',
            ]);
            $table->string('nom_fichier', 255);
            $table->string('chemin_fichier', 500);
            $table->timestamp('date_ajout')->useCurrent();
            $table->foreignId('ajoute_par')
                ->constrained('utilisateurs', 'id_utilisateur')->restrictOnDelete();
            $table->text('observation')->nullable();

            $table->index('id_candidature', 'idx_document_candidature');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents_candidature');
    }
};
