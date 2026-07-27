<?php
// Destination : database/migrations/2026_07_27_000000_create_parametres_organisme_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parametres_organisme', function (Blueprint $table) {
            $table->id();
            $table->string('nom_organisme', 150)->nullable();
            $table->string('sigle', 20)->nullable();
            $table->string('adresse', 255)->nullable();
            $table->string('telephone', 30)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('logo_path', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parametres_organisme');
    }
};
