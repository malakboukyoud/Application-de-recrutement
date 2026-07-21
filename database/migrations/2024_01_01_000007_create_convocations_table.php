<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('convocations', function (Blueprint $table) {
            $table->id('id_convocation');
            $table->foreignId('id_candidature')
                ->constrained('candidatures', 'id_candidature')->cascadeOnDelete();
            $table->enum('type_convocation', [
                'entretien_oral', 'concours_ecrit', 'test_pratique', 'examen_medical', 'autre',
            ]);
            $table->date('date_convocation');
            $table->time('heure_convocation')->nullable();
            $table->string('lieu_convocation', 150)->nullable();
            $table->enum('statut_presence', ['convoque', 'present', 'absent', 'excuse'])->default('convoque');
            $table->text('observation')->nullable();

            $table->index('date_convocation', 'idx_convocation_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('convocations');
    }
};
