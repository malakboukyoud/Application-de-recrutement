<?php

namespace App\Http\Controllers;

abstract class Controller
{

    
    protected function currentUserId(): ?int
    {
        return session('user')->id_utilisateur ?? null;
    }

}