<?php

namespace Database\Seeders;

use App\Models\Utilisateur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UtilisateurSeeder extends Seeder
{
    /**
     * Crée un utilisateur admin par défaut, nécessaire tant que
     * l'authentification (§11 du cahier des charges) n'est pas branchée :
     * le journal d'audit (historique_actions) a besoin d'au moins un
     * utilisateur existant en base pour pouvoir tracer les actions.
     */
    public function run(): void
    {
        Utilisateur::firstOrCreate(
            ['email' => 'admin@ormvasm.ma'],
            [
                'nom' => 'Admin',
                'prenom' => 'RH',
                'login' => 'admin',
                'mot_de_passe' => Hash::make('password'),
                'id_profil' => 1,
                'actif' => true,
            ]
        );
    }
}
