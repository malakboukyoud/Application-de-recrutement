<?php

namespace App\Http\Controllers;

use App\Http\Middleware\RoleMiddleware;

abstract class Controller
{

    
    protected function currentUserId(): ?int
    {
        return session('user')->id_utilisateur ?? null;
    }

    /**
     * Vrai si l'utilisateur connecté a le profil Admin ou RH.
     * Utile pour masquer les boutons "Modifier"/"Supprimer" dans les vues Blade
     * ou pour conditionner de la logique métier dans un contrôleur.
     */
    protected function isAdminOuRh(): bool
    {
        return RoleMiddleware::userHasRole(['administrateur', 'rh']);
    }

}