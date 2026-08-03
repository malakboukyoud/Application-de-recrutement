<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Gestion des offres | ORMVASM</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

:root{

    --orange:#F97316;
    --green:#15803D;
    --blue:#0284C7;

    --bg:#F5F7F6;
    --white:#FFFFFF;

    --text:#1F2937;
    --text-light:#6B7280;

    --border:#E5E7EB;

    --success:#DCFCE7;
    --danger:#FEE2E2;

    --shadow:0 8px 25px rgba(0,0,0,.06);

}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{

    font-family:"Segoe UI",sans-serif;
    background:var(--bg);
    color:var(--text);

}

a{

    text-decoration:none;

}

img{

    display:block;
    max-width:100%;

}

/* =========================================================
                    TOPBAR ORMVASM
========================================================= */

.topbar {

    position: fixed;

    top: 0;
    left: 0;
    right: 0;

    width: 100%;
    height: 75px;

    background: #FFFFFF;

    display: flex;
    align-items: center;

    padding: 0 30px;

    border-bottom: 1px solid #E5E7EB;

    box-shadow: 0 2px 12px rgba(15, 23, 42, .06);

    z-index: 5000;

}


/* =========================================================
                    LEFT
========================================================= */

.topbar-left{

    display:flex;

    align-items:center;

    gap:15px;

}

.topbar-logo{

    width:60px;

    height:60px;

    object-fit:contain;

}

.topbar-left h5{

    margin:0;

    color:#15803D;

    font-size:17px;

    font-weight:600;

    line-height:1.3;

}

/* =========================================================
   GAUCHE
========================================================= */

.ormvasm-topbar-left{

    display:flex;

    align-items:center;

    gap:13px;

    flex-shrink:0;

    min-width:390px;

}


.ormvasm-brand{

    width:58px;

    height:58px;

    display:flex;

    align-items:center;

    justify-content:center;

    flex-shrink:0;

}


.ormvasm-brand img{

    width:55px;

    height:55px;

    object-fit:contain;

}


.ormvasm-brand-name{

    max-width:300px;

    color:#17324D;

    font-size:13px;

    line-height:1.35;

    font-weight:700;

}


/* =========================================================
                    CENTER
========================================================= */

.topbar-center {

    flex: 1;

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 12px;

    padding: 0 30px;

}


/* =========================================================
                    SEARCH
========================================================= */

.search {

    width: 100%;

    max-width: 380px;

    height: 44px;

    position: relative;

}


.search i {

    position: absolute;

    left: 15px;

    top: 50%;

    transform: translateY(-50%);

    color: #64748B;

    font-size: 16px;

    z-index: 2;

}


.search input {

    width: 100%;

    height: 44px;

    border: 1px solid #E5E7EB;

    border-radius: 11px;

    padding: 0 15px 0 43px;

    outline: none;

    background: #F8FAFC;

    color: #1F2937;

    font-size: 13px;

    transition: all .2s ease;

}


.search input::placeholder {

    color: #94A3B8;

}


.search input:focus {

    background: #FFFFFF;

    border-color: #15803D;

    box-shadow:
        0 0 0 3px rgba(21, 128, 61, .08);

}


/* =========================================================
                    SELECT / FILTRES
========================================================= */

.topbar-center select {

    width: 160px;

    height: 44px;

    padding: 0 13px;

    border-radius: 11px;

    border: 1px solid #E5E7EB;

    background: #F8FAFC;

    color: #475569;

    font-size: 12px;

    outline: none;

    cursor: pointer;

    transition: all .2s ease;

}


.topbar-center select:focus {

    background: #FFFFFF;

    border-color: #15803D;

    box-shadow:
        0 0 0 3px rgba(21, 128, 61, .08);

}


/* =========================================================
                    RIGHT / USER
========================================================= */

.user {

    width: 260px;
    min-width: 260px;

    display: flex;

    align-items: center;

    justify-content: flex-end;

    gap: 15px;

}


/* =========================================================
                    NOTIFICATION
========================================================= */

.notification {

    position: relative;

    width: 43px;
    height: 43px;

    display: flex;

    align-items: center;

    justify-content: center;

    border: 1px solid #E5E7EB;

    border-radius: 11px;

    background: #FFFFFF;

    cursor: pointer;

    transition: all .2s ease;

}


.notification:hover {

    background: #F0FDF4;

    border-color: #15803D;

}


.notification i {

    font-size: 19px;

    color: #475569;

    transition: all .2s ease;

}


.notification:hover i {

    color: #15803D;

}


/* =========================================================
                NOTIFICATION BADGE
========================================================= */

.notification-badge {

    position: absolute;

    top: -5px;
    right: -5px;

    min-width: 19px;
    height: 19px;

    padding: 0 5px;

    border-radius: 20px;

    display: flex;

    align-items: center;
    justify-content: center;

    background: #DC2626;

    color: #FFFFFF;

    border: 2px solid #FFFFFF;

    font-size: 9px;

    font-weight: 700;

}


/* =========================================================
                    USER INFO
========================================================= */

.user-info {

    display: flex;

    flex-direction: column;

    align-items: flex-end;

    line-height: 1.3;

}


.user-info small {

    margin: 0;

    color: #6B7280;

    font-size: 10px;

}


.user-info strong {

    margin-top: 3px;

    color: #1F2937;

    font-size: 12px;

    font-weight: 700;

}


/* =========================================================
                    AVATAR
========================================================= */

.avatar {

    width: 43px;
    height: 43px;

    min-width: 43px;

    border-radius: 50%;

    background: #15803D;

    color: #FFFFFF;

    display: flex;

    align-items: center;
    justify-content: center;

    font-size: 12px;

    font-weight: 700;

    cursor: pointer;

    transition: all .2s ease;

}


.avatar:hover {

    background: #166534;

    transform: scale(1.04);

    box-shadow:
        0 5px 15px rgba(21, 128, 61, .20);

}


/* =========================================================
                    RESPONSIVE
========================================================= */

@media(max-width: 1200px) {

    .topbar-left {

        width: 280px;
        min-width: 280px;

    }

    .topbar-left h5 {

        font-size: 11px;

    }

    .topbar-center {

        padding: 0 15px;

    }

    .search {

        max-width: 300px;

    }

    .topbar-center select {

        width: 135px;

    }

}


/* =========================================================
                    TABLETTE
========================================================= */

@media(max-width: 1000px) {

    .topbar-left {

        width: auto;
        min-width: auto;

    }

    .topbar-left h5 {

        display: none;

    }

    .topbar-center {

        padding: 0 15px;

    }

    .search {

        max-width: 300px;

    }

    .user {

        width: auto;
        min-width: auto;

    }

}


/* =========================================================
                    MOBILE
========================================================= */

@media(max-width: 800px) {

    .topbar {

        padding: 0 15px;

    }

    .topbar-center {

        display: none;

    }

    .user {

        width: auto;
        min-width: auto;

    }

    .user-info {

        display: none;

    }

}


/* =========================================================
                    PETIT MOBILE
========================================================= */

@media(max-width: 500px) {

    .topbar {

        height: 70px;

        padding: 0 12px;

    }

    .topbar-logo {

        width: 48px;
        height: 48px;

    }

    .notification {

        width: 40px;
        height: 40px;

    }

    .avatar {

        width: 40px;
        height: 40px;

        min-width: 40px;

    }

}
/*==================================================
                    CONTENU
==================================================*/

.content{

    max-width:1300px;

    margin:auto;

    padding:35px;

    padding-top:95px;

}

.page-title{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:30px;

    flex-wrap:wrap;

    gap:15px;

}

.page-title h2{

    font-size:32px;

    font-weight:700;

}

.page-title p{

    color:var(--text-light);

}

.btn-add{

    background:var(--orange);

    color:#fff;

    padding:12px 22px;

    border-radius:10px;

    font-weight:600;

    transition:.3s;

}

.btn-add:hover{

    background:#df650e;

    color:#fff;

}

.card{

    border:none;

    border-radius:15px;

    box-shadow:var(--shadow);

    padding:20px;

}

.table{

    margin:0;

}

.table thead{

    background:#F8FAFC;

}

.table th{

    font-weight:600;

    white-space:nowrap;

}

.table th,
.table td{

    padding:15px;

    vertical-align:middle;

}

.badge-open{

    background:#DCFCE7;

    color:#166534;

    padding:7px 15px;

    border-radius:20px;

}

.badge-close{

    background:#FEE2E2;

    color:#991B1B;

    padding:7px 15px;

    border-radius:20px;

}

.action{

    display:flex;

    gap:10px;

}

.action a,
.action button{

    width:38px;

    height:38px;

    border:none;

    border-radius:8px;

    background:#F8FAFC;

    display:flex;

    justify-content:center;

    align-items:center;

    transition:.25s;

}

.text-show{

    color:#16A34A;

}

.text-edit{

    color:#0284C7;

}

.text-delete{

    color:#DC2626;

}

.action a:hover,
.action button:hover{

    background:#EEF2F7;

    transform:scale(1.08);

}

.pagination{

    justify-content:center;

    margin-top:25px;

}

@media(max-width:1200px){

.topbar-center{

display:none;

}

}

@media(max-width:768px){

.topbar{

padding:15px;

height:auto;

flex-wrap:wrap;

gap:15px;

}

.topbar-left h5{

display:none;

}

.content{

padding:20px;

}


.page-title{

flex-direction:column;

align-items:flex-start;

}

.btn-add{

width:100%;
text-align:center;

}

}
.main{

    margin-left:260px;

    width:calc(100% - 260px);

}
.action {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
}

/* Toutes les icônes */
.action a,
.action button {
    width: 36px;
    height: 36px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border: none;
    background: transparent;

    padding: 0;
    margin: 0;

    border-radius: 8px;

    font-size: 18px;
    cursor: pointer;

    text-decoration: none;

    transition: all 0.2s ease;
}

.ormvasm-topbar-right{

    display:flex;

    align-items:center;

    justify-content:flex-end;

    gap:18px;

    flex-shrink:0;

    min-width:250px;

}


/* =========================================================
   NOTIFICATION
========================================================= */

.ormvasm-notification{

    position:relative;

}


.ormvasm-notification-btn{

    position:relative;

    width:44px;

    height:44px;

    border:1px solid #E5E7EB;

    background:#FFFFFF;

    border-radius:11px;

    display:flex;

    align-items:center;

    justify-content:center;

    cursor:pointer;

    color:#475569;

    transition:.2s ease;

}


.ormvasm-notification-btn:hover{

    color:#15803D;

    border-color:#15803D;

    background:#F0FDF4;

}


.ormvasm-notification-btn i{

    font-size:19px;

}


.ormvasm-notification-badge{

    position:absolute;

    top:-5px;

    right:-5px;

    min-width:19px;

    height:19px;

    padding:0 5px;

    border-radius:20px;

    display:flex;

    align-items:center;

    justify-content:center;

    background:#DC2626;

    color:#FFFFFF;

    border:2px solid #FFFFFF;

    font-size:9px;

    font-weight:700;

}


/* =========================================================
   PANNEAU NOTIFICATIONS
========================================================= */

.ormvasm-notification-panel{

    position:absolute;

    top:55px;

    right:0;

    width:390px;

    max-height:560px;

    background:#FFFFFF;

    border:1px solid #E5E7EB;

    border-radius:15px;

    box-shadow:0 15px 45px rgba(15,23,42,.15);

    overflow:hidden;

    opacity:0;

    visibility:hidden;

    transform:translateY(-8px);

    transition:.2s ease;

    z-index:6000;

}


.ormvasm-user-menu.active{

    opacity:1;

    visibility:visible;

    transform:translateY(0);

}
/* NOTIFICATIONS OUVERTES */
.ormvasm-notification-panel.active {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}


/* MENU UTILISATEUR OUVERT */
.ormvasm-user-menu.active {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.ormvasm-notification-header{

    padding:18px 20px;

    border-bottom:1px solid #E5E7EB;

}


.ormvasm-notification-title{

    color:#17324D;

    font-size:15px;

    font-weight:700;

}


.ormvasm-notification-subtitle{

    margin-top:4px;

    color:#6B7280;

    font-size:11px;

}


.ormvasm-notification-list{

    max-height:420px;

    overflow-y:auto;

}


.ormvasm-notification-item{

    display:flex;

    gap:12px;

    padding:15px 18px;

    border-bottom:1px solid #F1F5F9;

    transition:.2s;

}


.ormvasm-notification-item:hover{

    background:#F8FAFC;

}


.ormvasm-notification-icon{

    width:38px;

    height:38px;

    min-width:38px;

    border-radius:10px;

    display:flex;

    align-items:center;

    justify-content:center;

}


.ormvasm-notification-icon.orange{

    background:#FFEDD5;

    color:#F97316;

}


.ormvasm-notification-icon.blue{

    background:#E0F2FE;

    color:#0284C7;

}


.ormvasm-notification-icon.red{

    background:#FEE2E2;

    color:#DC2626;

}


.ormvasm-notification-icon.green{

    background:#DCFCE7;

    color:#15803D;

}


.ormvasm-notification-content{

    min-width:0;

}


.ormvasm-notification-content strong{

    display:block;

    color:#1F2937;

    font-size:12px;

}


.ormvasm-notification-content p{

    margin:4px 0;

    color:#6B7280;

    font-size:11px;

    line-height:1.4;

}


.ormvasm-notification-time{

    color:#94A3B8;

    font-size:10px;

}


.ormvasm-notification-footer{

    padding:13px 18px;

    border-top:1px solid #E5E7EB;

    text-align:center;

}


.ormvasm-notification-footer a{

    color:#15803D;

    font-size:11px;

    font-weight:600;

}


/* =========================================================
   UTILISATEUR
========================================================= */

.ormvasm-user{

    position:relative;

    display:flex;

    align-items:center;

    gap:10px;

    cursor:pointer;

    padding:5px 7px;

    border-radius:11px;

}


.ormvasm-user:hover{

    background:#F8FAFC;

}


.ormvasm-user-label{

    display:flex;

    flex-direction:column;

    align-items:flex-end;

    line-height:1.3;

}


.ormvasm-user-label strong{

    color:#1F2937;

    font-size:12px;

    font-weight:700;

}


.ormvasm-user-label span{

    margin-top:3px;

    color:#6B7280;

    font-size:10px;

}


.ormvasm-user-avatar{

    width:43px;

    height:43px;

    border-radius:50%;

    display:flex;

    align-items:center;

    justify-content:center;

    background:#15803D;

    color:#FFFFFF;

    font-size:13px;

    font-weight:700;

}


/* =========================================================
   MENU UTILISATEUR
========================================================= */

.ormvasm-user-menu{

    position:absolute;

    top:56px;

    right:0;

    width:230px;

    background:#FFFFFF;

    border:1px solid #E5E7EB;

    border-radius:13px;

    box-shadow:0 15px 40px rgba(15,23,42,.14);

    padding:8px;

    opacity:0;

    visibility:hidden;

    transform:translateY(-8px);

    transition:.2s ease;

    z-index:6000;

}


.ormvasm-notification-panel.active{

    opacity:1;

    visibility:visible;

    transform:translateY(0);

}


.ormvasm-user-menu a,

.ormvasm-user-menu button{

    width:100%;

    min-height:42px;

    display:flex;

    align-items:center;

    gap:10px;

    padding:0 12px;

    border:0;

    border-radius:9px;

    background:transparent;

    color:#334155;

    font-size:12px;

    text-align:left;

    cursor:pointer;

}


.ormvasm-user-menu a:hover,

.ormvasm-user-menu button:hover{

    background:#F0FDF4;

    color:#15803D;

}


.ormvasm-user-menu i{

    width:18px;

    text-align:center;

    font-size:15px;

}


.ormvasm-user-menu hr{

    border:0;

    border-top:1px solid #E5E7EB;

    margin:7px 0;

}


/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width:1100px){

    .ormvasm-topbar-left{

        min-width:300px;

    }

    .ormvasm-brand-name{

        max-width:220px;

        font-size:11px;

    }

    .ormvasm-topbar-center{

        padding:0 20px;

    }

}


@media(max-width:850px){

    .ormvasm-topbar{

        padding:0 15px;

    }

    .ormvasm-topbar-left{

        min-width:auto;

    }

    .ormvasm-brand-name{

        display:none;

    }

    .ormvasm-topbar-center{

        padding:0 15px;

    }

    .ormvasm-user-label{

        display:none;

    }

}


@media(max-width:600px){

    .ormvasm-topbar{

        height:72px;

    }

    .ormvasm-brand{

        width:45px;

        height:45px;

    }

    .ormvasm-brand img{

        width:43px;

        height:43px;

    }

    .ormvasm-topbar-center{

        padding:0 8px;

    }

    .ormvasm-search{

        max-width:none;

        height:40px;

    }

    .ormvasm-topbar-right{

        min-width:auto;

        gap:7px;

    }

    .ormvasm-notification-btn{

        width:40px;

        height:40px;

    }

    .ormvasm-user-avatar{

        width:40px;

        height:40px;

    }

    .ormvasm-notification-panel{

        position:fixed;

        top:80px;

        left:10px;

        right:10px;

        width:auto;

    }

    .ormvasm-user-menu{

        right:0;

    }

}


</style>
<body>

@php

    /*
    |--------------------------------------------------------------------------
    | UTILISATEUR CONNECTÉ
    |--------------------------------------------------------------------------
    */

    $user = session('user');

    $profil = $user->profil ?? '';


    /*
    |--------------------------------------------------------------------------
    | NOM UTILISATEUR
    |--------------------------------------------------------------------------
    */

    $prenom = $user->prenom ?? '';
    $nom = $user->nom ?? '';

    $userName = trim($prenom . ' ' . $nom);

    if ($userName === '') {
        $userName = 'Utilisateur';
    }


    /*
    |--------------------------------------------------------------------------
    | RÔLE
    |--------------------------------------------------------------------------
    */

    $userRole = $user->profil ?? 'Utilisateur';


    /*
    |--------------------------------------------------------------------------
    | INITIALES
    |--------------------------------------------------------------------------
    */

    $userInitials =
        strtoupper(substr($prenom, 0, 1)) .
        strtoupper(substr($nom, 0, 1));

    if ($userInitials === '') {
        $userInitials = 'U';
    }


    /*
    |--------------------------------------------------------------------------
    | PROFILS
    |--------------------------------------------------------------------------
    */

    $admin = $profil === 'Administrateur';

    $serviceRH = $profil === 'RH';

    $commission = $profil === 'Commission';

    $responsableService =
        $profil === 'Responsable de service';

    $consultation =
        $profil === 'Consultation';


    /*
    |--------------------------------------------------------------------------
    | NOTIFICATIONS
    |--------------------------------------------------------------------------
    */

    $candidaturesEnAttente =
        $candidaturesEnAttente ?? 0;

    $dossiersIncomplets =
        $dossiersIncomplets ?? 0;

    $offresExpirentBientot =
        $offresExpirentBientot ?? 0;

    $convocationsAVenir =
        $convocationsAVenir ?? 0;

    $nbNotifications =
        $nbNotifications ?? 0;

@endphp

 <div>
    @include('layouts.sidebar')
        </div>
<div class="main">

    <!-- ===========================
                TOPBAR
    ============================ -->

    <div class="topbar">

        <div class="topbar-left">

            <img src="{{ asset('image/ormvaa.png') }}" class="topbar-logo">

            <h5>
                Office Régional de Mise en Valeur Agricole
                du Souss Massa
            </h5>

        </div>

        <div class="topbar-center">

            <div class="search">

                <i class="bi bi-search"></i>

                <input
                    type="text"
                    id="tableSearch"
                    placeholder="Rechercher une offre...">

            </div>

            <select id="typeFilter" class="form-select">

                <option value="">Tous les types</option>
                <option value="Interne">Interne</option>
                <option value="Externe">Externe</option>

            </select>

            <select id="statutFilter" class="form-select">

                <option value="">Tous les statuts</option>
                <option value="Ouverte">Ouverte</option>
                <option value="Fermée">Fermée</option>

            </select>

        </div>
        <div class="ormvasm-topbar-right">

        {{-- =================================================
             NOTIFICATIONS
        ================================================== --}}

        <div class="ormvasm-notification">


            <button
    type="button"
    class="ormvasm-notification-btn"
    id="notificationButton"
    title="Notifications"
>
    <i class="bi bi-bell"></i>

    @if($nbNotifications > 0)

        <span
            class="ormvasm-notification-badge"
            id="notificationBadge"
        >
            {{ $nbNotifications > 99 ? '99+' : $nbNotifications }}
        </span>

    @endif

</button>

            {{-- PANEL NOTIFICATIONS --}}

            <div
                class="ormvasm-notification-panel"
                id="notificationPanel"
            >


                <div class="ormvasm-notification-header">

                    <div>

                        <div class="ormvasm-notification-title">

                            Notifications

                        </div>

                        <div class="ormvasm-notification-subtitle">

                            <span id="notificationCount">
                                {{ $nbNotifications }}
                            </span>

                            notifications

                        </div>

                    </div>

                </div>



                <div class="ormvasm-notification-list">


                    {{-- CANDIDATURES --}}

                    @if($candidaturesEnAttente > 0)

                        <a
                            href="{{ url('/candidatures') }}"
                            class="ormvasm-notification-item"
                        >

                            <div class="ormvasm-notification-icon orange">

                                <i class="bi bi-person-plus"></i>

                            </div>


                            <div class="ormvasm-notification-content">

                                <strong>
                                    Nouvelles candidatures
                                </strong>

                                <p>
                                    {{ $candidaturesEnAttente }}
                                    candidature(s) en attente de traitement.
                                </p>

                                <span class="ormvasm-notification-time">
                                    À traiter
                                </span>

                            </div>

                        </a>

                    @endif



                    {{-- DOSSIERS --}}

                    @if($dossiersIncomplets > 0)

                        <a
                            href="{{ url('/candidatures') }}"
                            class="ormvasm-notification-item"
                        >

                            <div class="ormvasm-notification-icon blue">

                                <i class="bi bi-folder-x"></i>

                            </div>


                            <div class="ormvasm-notification-content">

                                <strong>
                                    Dossiers incomplets
                                </strong>

                                <p>
                                    {{ $dossiersIncomplets }}
                                    dossier(s) nécessitent une vérification.
                                </p>

                                <span class="ormvasm-notification-time">
                                    À vérifier
                                </span>

                            </div>

                        </a>

                    @endif



                    {{-- OFFRES --}}

                    @if($offresExpirentBientot > 0)

                        <a
                            href="{{ url('/offres') }}"
                            class="ormvasm-notification-item"
                        >

                            <div class="ormvasm-notification-icon red">

                                <i class="bi bi-clock-history"></i>

                            </div>


                            <div class="ormvasm-notification-content">

                                <strong>
                                    Offres bientôt expirées
                                </strong>

                                <p>
                                    {{ $offresExpirentBientot }}
                                    offre(s) arrivent bientôt à échéance.
                                </p>

                                <span class="ormvasm-notification-time">
                                    Important
                                </span>

                            </div>

                        </a>

                    @endif



                    {{-- CONVOCATIONS --}}

                    @if($convocationsAVenir > 0)

                        <a
                            href="{{ url('/convocations') }}"
                            class="ormvasm-notification-item"
                        >

                            <div class="ormvasm-notification-icon green">

                                <i class="bi bi-calendar-event"></i>

                            </div>


                            <div class="ormvasm-notification-content">

                                <strong>
                                    Convocations à venir
                                </strong>

                                <p>
                                    {{ $convocationsAVenir }}
                                    convocation(s) sont prévues.
                                </p>

                                <span class="ormvasm-notification-time">
                                    À consulter
                                </span>

                            </div>

                        </a>

                    @endif



                    {{-- AUCUNE NOTIFICATION --}}

                    @if($nbNotifications === 0)

                        <div class="ormvasm-empty">

                            <i class="bi bi-check-circle"></i>

                            <p class="mb-0">
                                Aucune notification.
                            </p>

                        </div>

                    @endif


                </div>



                <div class="ormvasm-notification-footer">

                    <a href="{{ url('/candidatures') }}">

                        Voir les candidatures

                        <i class="bi bi-arrow-right"></i>

                    </a>

                </div>


            </div>

        </div>



        {{-- =================================================
             UTILISATEUR
        ================================================== --}}

        <div
            class="ormvasm-user"
            id="userMenuButton"
        >


            <div class="ormvasm-user-label">

                <strong>
                    {{ $userName }}
                </strong>

                <span>
                    {{ $userRole }}
                </span>

            </div>


            <div class="ormvasm-user-avatar">

                {{ $userInitials }}

            </div>



            {{-- MENU UTILISATEUR --}}

            <div
                class="ormvasm-user-menu"
                id="userMenuPanel"
            >


                @if($admin)

                    <a
                        href="{{ route('historique.index') }}"
                    >

                        <i class="bi bi-clock-history"></i>

                        Historique des actions

                    </a>

                    <hr>

                @endif



                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >

                    @csrf

                    <button type="submit">

                        <i class="bi bi-box-arrow-right"></i>

                        Déconnexion

                    </button>

                </form>


            </div>

        </div>


    </div>

        
        
    </div>

    <!-- ===========================
                CONTENU
    ============================ -->

    <div class="content">
        
        <div class="page-title">

            <div>

                <h2>Gestion des offres</h2>

                <p>
                    Liste des offres de recrutement.
                </p>

            </div>
            @if($admin || $serviceRH)
            <a href="{{ route('offres.create') }}" class="btn-add">

                <i class="bi bi-plus-circle"></i>

                Ajouter une offre

            </a>
             @endif
        </div>

        @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

        @endif

        <div class="card">

            <div class="table-responsive">

                <table class="table align-middle" id="offresTable">

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Référence</th>

                            <th>Intitulé</th>

                            <th>Type</th>

                            <th>Postes</th>

                            <th>Date publication</th>

                            <th>Date limite</th>

                            <th>Statut</th>

                            <th width="170">Actions</th>

                        </tr>

                    </thead>

                    <tbody>
                        @forelse($offres as $offre)

<tr>

    <td>{{ $offre->id_offre }}</td>

    <td>{{ $offre->reference_offre }}</td>

    <td>{{ $offre->intitule_poste }}</td>

    <td>{{ $offre->type_recrutement }}</td>

    <td>{{ $offre->nombre_postes }}</td>

    <td>{{ $offre->date_publication }}</td>

    <td>{{ $offre->date_limite_depot }}</td>

    <td>

        @if($offre->statut == "Ouverte")

            <span class="badge-open">

                Ouverte

            </span>

        @else

            <span class="badge-close">

                {{ $offre->statut }}

            </span>

        @endif

    </td>

    <td>

        <div class="action">

            <a
                href="{{ route('offres.show',$offre->id_offre) }}"
                class="text-show"
                title="Afficher">

                <i class="bi bi-eye-fill"></i>

            </a>
            @if($admin || $serviceRH)
            <a
                href="{{ route('offres.edit',$offre->id_offre) }}"
                class="text-edit"
                title="Modifier">

                <i class="bi bi-pencil-square"></i>

            </a>
            @endif
            @if($admin)
            <form
                action="{{ route('offres.destroy',$offre->id_offre) }}"
                method="POST"
                style="display:inline;"
                onsubmit="return confirm('Voulez-vous vraiment supprimer cette offre ?')">

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="text-delete"
                    title="Supprimer">

                    <i class="bi bi-trash-fill"></i>

                </button>

            </form>
@endif
        </div>

    </td>

</tr>

@empty

<tr>

    <td colspan="9" class="text-center py-5">

        <i class="bi bi-folder2-open fs-1 text-secondary"></i>

        <br><br>

        Aucune offre disponible.

    </td>

</tr>

@endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-4">

                {{ $offres->links() }}

            </div>

        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* =========================================================
       ELEMENTS
    ========================================================= */

    const notificationButton = document.getElementById('notificationButton');
    const notificationPanel = document.getElementById('notificationPanel');

    const userMenuButton = document.getElementById('userMenuButton');
    const userMenuPanel = document.getElementById('userMenuPanel');


    /* =========================================================
       FONCTIONS
    ========================================================= */

    function openNotifications() {

        if (!notificationPanel) {
            return;
        }

        notificationPanel.classList.add('active');

        if (userMenuPanel) {
            userMenuPanel.classList.remove('active');
        }
    }


    function closeNotifications() {

        if (!notificationPanel) {
            return;
        }

        notificationPanel.classList.remove('active');
    }


    function toggleNotifications() {

        if (!notificationPanel) {
            return;
        }

        const isOpen =
            notificationPanel.classList.contains('active');

        if (isOpen) {

            closeNotifications();

        } else {

            openNotifications();

        }
    }


    function openUserMenu() {

        if (!userMenuPanel) {
            return;
        }

        userMenuPanel.classList.add('active');

        if (notificationPanel) {
            notificationPanel.classList.remove('active');
        }
    }


    function closeUserMenu() {

        if (!userMenuPanel) {
            return;
        }

        userMenuPanel.classList.remove('active');
    }


    function toggleUserMenu() {

        if (!userMenuPanel) {
            return;
        }

        const isOpen =
            userMenuPanel.classList.contains('active');

        if (isOpen) {

            closeUserMenu();

        } else {

            openUserMenu();

        }
    }


    /* =========================================================
       BOUTON NOTIFICATIONS
    ========================================================= */

    if (notificationButton) {

        notificationButton.addEventListener('click', function (event) {

            event.preventDefault();
            event.stopPropagation();

            toggleNotifications();

        });

    }


    /* =========================================================
       PANNEAU NOTIFICATIONS
    ========================================================= */

    if (notificationPanel) {

        notificationPanel.addEventListener('click', function (event) {

            /*
             * Empêche le document de fermer le panneau
             * lorsque l'on clique à l'intérieur.
             */
            event.stopPropagation();

        });

    }


    /* =========================================================
       BOUTON UTILISATEUR
    ========================================================= */

    if (userMenuButton) {

        userMenuButton.addEventListener('click', function (event) {

            event.preventDefault();
            event.stopPropagation();

            toggleUserMenu();

        });

    }


    /* =========================================================
       MENU UTILISATEUR
    ========================================================= */

    if (userMenuPanel) {

        userMenuPanel.addEventListener('click', function (event) {

            /*
             * Empêche la fermeture immédiate du menu
             * lorsqu'on clique à l'intérieur.
             */
            event.stopPropagation();

        });

    }


    /* =========================================================
       CLIC À L'EXTÉRIEUR
    ========================================================= */

    document.addEventListener('click', function (event) {

        /*
         * NOTIFICATIONS
         */

        if (
            notificationPanel &&
            notificationButton &&
            !notificationPanel.contains(event.target) &&
            !notificationButton.contains(event.target)
        ) {

            closeNotifications();

        }


        /*
         * MENU UTILISATEUR
         */

        if (
            userMenuPanel &&
            userMenuButton &&
            !userMenuPanel.contains(event.target) &&
            !userMenuButton.contains(event.target)
        ) {

            closeUserMenu();

        }

    });


    /* =========================================================
       ESCAPE
    ========================================================= */

    document.addEventListener('keydown', function (event) {

        if (event.key === 'Escape') {

            closeNotifications();

            closeUserMenu();

        }

    });


    /* =========================================================
       RECHERCHE OFFRES
    ========================================================= */

    const search = document.getElementById('tableSearch');

    const typeFilter = document.getElementById('typeFilter');

    const statutFilter = document.getElementById('statutFilter');

    const table = document.getElementById('offresTable');


    function filtrerOffres() {

        if (!table) {
            return;
        }

        const texte =
            search
                ? search.value.toLowerCase().trim()
                : '';

        const typeChoisi =
            typeFilter
                ? typeFilter.value.toLowerCase().trim()
                : '';

        const statutChoisi =
            statutFilter
                ? statutFilter.value.toLowerCase().trim()
                : '';


        const rows =
            table.querySelectorAll('tbody tr');


        rows.forEach(function (row) {

            /*
             * Ignorer la ligne "Aucune offre disponible"
             */
            if (row.cells.length < 8) {
                return;
            }


            const contenu =
                row.innerText.toLowerCase();


            /*
             * COLONNE TYPE
             * 0 = ID
             * 1 = Référence
             * 2 = Intitulé
             * 3 = Type
             * 4 = Postes
             * 5 = Date publication
             * 6 = Date limite
             * 7 = Statut
             */

            const typeOffre =
                row.cells[3]
                    ? row.cells[3].innerText
                        .toLowerCase()
                        .trim()
                    : '';


            const statutOffre =
                row.cells[7]
                    ? row.cells[7].innerText
                        .toLowerCase()
                        .trim()
                    : '';


            const okRecherche =
                texte === '' ||
                contenu.includes(texte);


            const okType =
                typeChoisi === '' ||
                typeOffre === typeChoisi;


            const okStatut =
                statutChoisi === '' ||
                statutOffre.includes(statutChoisi);


            if (
                okRecherche &&
                okType &&
                okStatut
            ) {

                row.style.display = '';

            } else {

                row.style.display = 'none';

            }

        });

    }


    /* =========================================================
       RECHERCHE
    ========================================================= */

    if (search) {

        search.addEventListener('input', function () {

            filtrerOffres();

        });

    }


    /* =========================================================
       FILTRE TYPE
    ========================================================= */

    if (typeFilter) {

        typeFilter.addEventListener('change', function () {

            filtrerOffres();

        });

    }


    /* =========================================================
       FILTRE STATUT
    ========================================================= */

    if (statutFilter) {

        statutFilter.addEventListener('change', function () {

            filtrerOffres();

        });

    }


    /* =========================================================
       INITIALISATION
    ========================================================= */

    filtrerOffres();


});
</script>



</body>

</html>