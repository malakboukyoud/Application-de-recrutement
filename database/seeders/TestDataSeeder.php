<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {

        /*
        |--------------------------------------------------------------------------
        | Profils
        |--------------------------------------------------------------------------
        */

        DB::table('profils')->insert([
            [
                'libelle' => 'Administrateur',
                'description' => 'Accès total au système',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'libelle' => 'RH',
                'description' => 'Gestion recrutement',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'libelle' => 'Commission',
                'description' => 'Evaluation des candidatures',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Utilisateurs
        |--------------------------------------------------------------------------
        */

        DB::table('utilisateurs')->insert([

            [
                'nom' => 'Admin',
                'prenom' => 'System',
                'email' => 'admin@ormvasm.ma',
                'mot_de_passe' => Hash::make('123456'),
                'id_profil' => 1,
                'statut' => 'Actif',
                'created_at' => now(),
                'updated_at' => now(),
            ],


            [
                'nom' => 'Bennani',
                'prenom' => 'Sara',
                'email' => 'sara.rh@ormvasm.ma',
                'mot_de_passe' => Hash::make('123456'),
                'id_profil' => 2,
                'statut' => 'Actif',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);



        /*
        |--------------------------------------------------------------------------
        | Candidats
        |--------------------------------------------------------------------------
        */

        DB::table('candidats')->insert([

            [
                'nom' => 'Alaoui',
                'prenom' => 'Yassine',
                'email' => 'yassine@gmail.com',
                'telephone' => '0600000000',
                'created_at' => now(),
                'updated_at' => now(),
            ],


            [
                'nom' => 'Amrani',
                'prenom' => 'Sara',
                'email' => 'sara@gmail.com',
                'telephone' => '0611111111',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);



        /*
        |--------------------------------------------------------------------------
        | Offres
        |--------------------------------------------------------------------------
        */

        DB::table('offres_recrutement')->insert([

            [
                'titre' => 'Développeur Laravel',
                'description' => 'Développement application RH',
                'etat_offre' => 'Ouverte',
                'created_at' => now(),
                'updated_at' => now(),
            ],


            [
                'titre' => 'Ingénieur Réseau',
                'description' => 'Administration réseau',
                'etat_offre' => 'Ouverte',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);

    }
}