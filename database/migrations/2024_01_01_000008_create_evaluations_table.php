<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id('id_evaluation');
            $table->foreignId('id_candidature')
                ->constrained('candidatures', 'id_candidature')->cascadeOnDelete();
            $table->foreignId('id_convocation')->nullable()
                ->constrained('convocations', 'id_convocation')->nullOnDelete();
            $table->decimal('note_ecrite', 4, 2)->nullable();
            $table->decimal('note_orale', 4, 2)->nullable();
            $table->decimal('note_pratique', 4, 2)->nullable();
            $table->decimal('coefficient_ecrit', 3, 2)->default(1.00);
            $table->decimal('coefficient_oral', 3, 2)->default(1.00);
            $table->decimal('coefficient_pratique', 3, 2)->default(1.00);
            // note_finale : colonne générée, ajoutée juste après via DB::statement
            $table->string('appreciation', 255)->nullable();
            $table->foreignId('saisi_par')
                ->constrained('utilisateurs', 'id_utilisateur')->restrictOnDelete();
            $table->timestamp('date_saisie')->useCurrent();
        });

        $driver = DB::connection()->getDriverName();

        // Notes comprises entre 0 et 20 : déjà validées par EvaluationRequest ;
        // ajoutées en base uniquement sur MySQL/MariaDB (pas d'ALTER ADD CONSTRAINT
        // sous SQLite, utilisé par défaut en local).
        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE evaluations
                ADD CONSTRAINT chk_note_ecrite CHECK (note_ecrite IS NULL OR note_ecrite BETWEEN 0 AND 20)');
            DB::statement('ALTER TABLE evaluations
                ADD CONSTRAINT chk_note_orale CHECK (note_orale IS NULL OR note_orale BETWEEN 0 AND 20)');
            DB::statement('ALTER TABLE evaluations
                ADD CONSTRAINT chk_note_pratique CHECK (note_pratique IS NULL OR note_pratique BETWEEN 0 AND 20)');

            // note_finale = moyenne pondérée des notes disponibles par leurs coefficients
            // (colonne calculée par MySQL, jamais saisie manuellement)
            DB::statement("ALTER TABLE evaluations ADD COLUMN note_finale DECIMAL(5,2) AS (
                ROUND(
                    (
                        IFNULL(note_ecrite, 0)    * IF(note_ecrite    IS NULL, 0, coefficient_ecrit) +
                        IFNULL(note_orale, 0)     * IF(note_orale     IS NULL, 0, coefficient_oral) +
                        IFNULL(note_pratique, 0)  * IF(note_pratique  IS NULL, 0, coefficient_pratique)
                    )
                    /
                    NULLIF(
                        IF(note_ecrite   IS NULL, 0, coefficient_ecrit) +
                        IF(note_orale    IS NULL, 0, coefficient_oral) +
                        IF(note_pratique IS NULL, 0, coefficient_pratique),
                        0
                    ),
                2)
            ) STORED");
        } else {
            // SQLite / autres moteurs : colonne simple, calculée côté application
            // par le modèle Evaluation (voir App\Models\Evaluation::booted()).
            Schema::table('evaluations', function (Blueprint $table) {
                $table->decimal('note_finale', 5, 2)->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
