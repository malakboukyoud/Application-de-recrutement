<?php

namespace App\Console\Commands;

use App\Models\Utilisateur;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

/**
 * Migration ponctuelle : votre table `utilisateurs` contient actuellement
 * des mots de passe en clair (ex. 'admin123', 'rh123'...). Cette commande
 * les remplace par un hash bcrypt, sans toucher aux mots de passe déjà
 * hachés (idempotente : peut être relancée sans risque).
 *
 * Utilisation : php artisan users:hash-passwords
 */
class HashExistingPasswords extends Command
{
    protected $signature = 'users:hash-passwords';

    protected $description = 'Hache les mots de passe en clair existants dans la table utilisateurs';

    public function handle(): int
    {
        $utilisateurs = Utilisateur::all();
        $migres = 0;

        foreach ($utilisateurs as $utilisateur) {
            // Un hash bcrypt Laravel commence toujours par $2y$
            if (str_starts_with($utilisateur->mot_de_passe, '$2y$')) {
                continue;
            }

            $motDePasseClair = $utilisateur->mot_de_passe;

            $utilisateur->mot_de_passe = Hash::make($motDePasseClair);
            $utilisateur->save();

            $migres++;

            $this->line("Migré : {$utilisateur->login} (ancien mot de passe : {$motDePasseClair})");
        }

        $this->info("{$migres} mot(s) de passe migré(s) vers un hash bcrypt.");
        $this->comment('Les identifiants de connexion (login) restent inchangés ; seul le stockage du mot de passe change.');

        return self::SUCCESS;
    }
}
