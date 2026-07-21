<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('referentiels', function (Blueprint $table) {
            $table->id('id_ref');
            $table->string('type_ref', 50); // 'diplome', 'specialite', 'service', 'type_document'...
            $table->string('libelle', 150);
            $table->boolean('actif')->default(true);
            $table->unique(['type_ref', 'libelle'], 'uq_referentiel');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referentiels');
    }
};
