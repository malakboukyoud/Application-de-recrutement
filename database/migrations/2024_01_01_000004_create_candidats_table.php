<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidats', function (Blueprint $table) {
            $table->id('id_candidat');
            $table->string('nom', 100);
            $table->string('prenom', 100);
            $table->enum('sexe', ['M', 'F'])->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('lieu_naissance', 100)->nullable();
            $table->string('cin', 20)->unique(); // règle de gestion : CIN unique
            $table->string('adresse', 200)->nullable();
            $table->string('ville', 100)->nullable();
            $table->string('telephone', 20)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('niveau_etude', 100)->nullable();
            $table->string('diplome', 100)->nullable();
            $table->string('specialite', 100)->nullable();
            $table->string('etablissement', 150)->nullable();
            $table->integer('annee_obtention')->nullable();
            $table->text('experience')->nullable();
            $table->string('situation_actuelle', 100)->nullable();
            $table->text('observations')->nullable();
            $table->timestamps();

            $table->index('cin', 'idx_candidat_cin');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidats');
    }
};
