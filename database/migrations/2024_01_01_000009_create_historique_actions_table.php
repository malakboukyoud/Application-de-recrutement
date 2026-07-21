<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historique_actions', function (Blueprint $table) {
            $table->id('id_historique');
            $table->foreignId('id_utilisateur')
                ->constrained('utilisateurs', 'id_utilisateur')->restrictOnDelete();
            $table->string('action', 100); // ex : 'creation_offre', 'changement_etat'
            $table->string('table_concernee', 50);
            $table->unsignedBigInteger('id_enregistrement');
            $table->timestamp('date_action')->useCurrent();
            $table->text('detail_action')->nullable();

            $table->index(['table_concernee', 'id_enregistrement'], 'idx_historique_table');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historique_actions');
    }
};
