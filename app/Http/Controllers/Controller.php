<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function currentUserId(): ?int
    {
        return session('user')->id_utilisateur ?? null;
    }

    /**
     * Libellé du profil de l'utilisateur connecté (ex : 'Administrateur').
     */
    protected function currentProfil(): string
    {
        return session('user')->profil ?? '';
    }

    /**
     * Vrai si le profil connecté fait partie de la liste donnée.
     * L'Administrateur est toujours autorisé.
     * Utile pour des vérifications fines à l'intérieur d'une méthode de
     * contrôleur (ex : masquer certains champs), en complément du middleware
     * `profil:...` posé sur la route.
     */
    protected function profilAutorise(array $profilsAutorises): bool
    {
        $profil = strtolower(trim($this->currentProfil()));

        if ($profil === 'administrateur') {
            return true;
        }

        return in_array($profil, array_map('strtolower', $profilsAutorises), true);
    }
}