<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Paramètre d'utilisateur</title>
 <style>
  /* ==============================
        PAGE PARAMETRES
============================== */

:root {

    /* Couleurs principales ORMVASM */
    --green: #15803D;
    --green-dark: #166534;
    --green-light: #DCFCE7;


    /* Couleurs secondaires */
    --blue: #2563EB;
    --blue-light: #DBEAFE;


    /* Arrière-plans */
    --background: #F8FAFC;
    --white: #FFFFFF;


    /* Texte */
    --text-dark: #1F2937;
    --text-gray: #64748B;


    /* Bordures */
    --border: #E5E7EB;


    /* Ombres */
    --shadow: 0 10px 30px rgba(0,0,0,0.08);

}
/* ==========================
       PARAMETRES SIMPLE
========================== */


.settings-container{

    padding-top:10px;

}



/* TITRE */

.settings-title{

    color: #000000;

    font-size:28px;

    font-weight:700;

    margin-bottom:30px;
    margin-left:30px;

}



/* GRID */

.settings-grid{

    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:30px;
    margin-left:100px;
    margin-right:100px;

}




/* CARTE */

.settings-card{

    background:rgba(255,255,255,0.85);

    border-radius:16px;

    padding:25px;

    border:1px solid rgba(229,231,235,0.8);

    box-shadow:0 5px 15px rgba(0,0,0,0.06);

    transition:.3s;

}



/* HOVER */

.settings-card:hover{

    transform:translateY(-4px);

    box-shadow:0 8px 20px rgba(0,0,0,0.10);

}




/* HEADER */

.settings-header{

    display:flex;

    align-items:center;

    gap:18px;

}




/* ICONES */

.settings-icon{

    width:55px;

    height:55px;

    border-radius:50%;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:24px;

    background:rgba(21,128,61,0.12);

    color:var(--green);

}



/* TITRE CARTE */

.settings-card h5{

    margin:0;

    font-size:18px;

    color:#1F2937;

    font-weight:600;

}



/* DESCRIPTION */

.settings-card p{

    margin-top:15px;

    color:#64748B;

    font-size:14px;

}



/* BOUTON */

.settings-btn{

    margin-top:15px;

    padding:10px 20px;

    border:none;

    border-radius:10px;

    
    background:#DCFCE7;
    color:#16A34A;

    font-size:14px;

    transition:.3s;

}



.settings-btn:hover{

    background:#166534;

}



/* COULEURS DES CARTES */


/* Profil */

.profile .settings-icon{

    background:rgba(37,99,235,0.12);

    color:#2563EB;

}



/* Sécurité */

.security .settings-icon{

    background:rgba(21,128,61,0.12);

    color:#15803D;

}



/* Système */

.system .settings-icon{

    background:rgba(234,179,8,0.15);

    color:#D97706;

}



/* Notifications */

.notification .settings-icon{

    background:rgba(59,130,246,0.12);

    color:#3B82F6;

}




/* RESPONSIVE */

@media(max-width:900px){

.settings-grid{

    grid-template-columns:1fr;

}

}

 </style>
</head>
<body>
@extends('layouts.app')
@include('layouts.topbar')
@section('content')

<div class="settings-container">


    <h2 class="settings-title">
        <i class="bi bi-gear-fill"></i>
        Paramètres
    </h2>



    <div class="settings-grid">



        <!-- Profil utilisateur -->
        <div class="settings-card profile">


            <div class="settings-header">


                <div class="settings-icon">
                    <i class="bi bi-person-circle"></i>
                </div>


                <div>

                    <h5>
                        Profil utilisateur
                    </h5>

                    <p>
                        Modifier les informations personnelles du compte.
                    </p>

                </div>


            </div>



            <button class="settings-btn">
                Modifier le profil
            </button>


        </div>





        <!-- Sécurité -->
        <div class="settings-card security">


            <div class="settings-header">


                <div class="settings-icon">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>


                <div>

                    <h5>
                        Sécurité
                    </h5>

                    <p>
                        Modifier le mot de passe et gérer la connexion.
                    </p>

                </div>


            </div>



            <button class="settings-btn">
                Changer mot de passe
            </button>


        </div>






        <!-- Configuration système -->
        <div class="settings-card system">


            <div class="settings-header">


                <div class="settings-icon">
                    <i class="bi bi-sliders"></i>
                </div>


                <div>

                    <h5>
                        Configuration système
                    </h5>

                    <p>
                        Gérer les paramètres généraux de l'application.
                    </p>

                </div>


            </div>



            <button class="settings-btn">
                Configurer
            </button>


        </div>







        <!-- Notifications -->
        <div class="settings-card notification">


            <div class="settings-header">


                <div class="settings-icon">
                    <i class="bi bi-bell-fill"></i>
                </div>


                <div>

                    <h5>
                        Notifications
                    </h5>

                    <p>
                        Gérer les alertes et notifications.
                    </p>

                </div>


            </div>



            <button class="settings-btn">
                Gérer
            </button>


        </div>



    </div>


</div>

@endsection
</body>
</html>