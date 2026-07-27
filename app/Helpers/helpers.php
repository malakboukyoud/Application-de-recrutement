<?php


function hasPermission($permission)
{

    $user = auth()->user();


    if(!$user)
    {
        return false;
    }


    $profil = $user->profil->libelle;


    $permissions = config("roles.$profil", []);


    return in_array($permission,$permissions);

}