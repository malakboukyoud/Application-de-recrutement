<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id('id_utilisateur');
            $table->string('nom', 100);
            $table->string('prenom', 100);
            $table->string('login', 50)->unique();
            $table->string('mot_de_passe', 255); // toujours un hash (bcrypt/argon2)
            $table->enum('profil', ['admin', 'rh', 'commission', 'responsable_service', 'consultation']);
            $table->string('email', 150)->unique();
            $table->boolean('actif')->default(true);
            $table->timestamp('date_creation')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('utilisateurs');
    }
};
