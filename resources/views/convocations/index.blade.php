<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Gestion des convocations | ORMVASM</title>

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

/* Liens : professionnels, jamais soulignes ni bleus, meme visites */
a, a:visited, a:hover, a:active{
    color:inherit;
    text-decoration:none;
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


.main{

    margin-left:260px;
    width:calc(100% - 260px);

}

.content{

    padding:35px;
    padding-top:95px;

}


.page-title{

    display:flex;
    justify-content:space-between;
    align-items:center;

    margin-bottom:30px;

}

.page-title h2{

    font-size:32px;
    font-weight:700;

}

.page-title p{

    color:#6B7280;

}

.btn-add{

    background:var(--orange);
    color:white;

    padding:12px 22px;

    border-radius:10px;

    font-weight:600;

}

.btn-add:hover{

    background:#df650e;
    color:white;

}
.btn-add{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;

    background:var(--orange);
    color:#fff !important;

    padding:12px 22px;

    border:none;
    border-radius:10px;

    font-size:20px;
    font-weight:600;
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;

    text-decoration:none;
    white-space:nowrap;

    cursor:pointer;

    transition:all .25s ease;
}

.btn-add:hover{
    background:#EA580C;
    color:#fff !important;
    transform:translateY(-2px);
    box-shadow:0 8px 20px rgba(249,115,22,.25);
}

.btn-add:active{
    transform:scale(.98);
}

.btn-add i{
    font-size:18px;
}
.btn-export{

    background:white;
    color:var(--green);
    border:1px solid var(--green);

    padding:12px 20px;

    border-radius:10px;

    font-weight:600;

    display:inline-flex;
    align-items:center;
    gap:8px;

}

.btn-export:hover{

    background:var(--green);
    color:white;

}

.page-actions{
    display:flex;
    align-items:center;
    gap:12px;
    flex-wrap:wrap;
}

.card{

    border:none;

    border-radius:15px;

    box-shadow:var(--shadow);

    padding:20px;

}

.table{
    width:100%;
    border-collapse:collapse;
    background:#fff;
    border-radius:18px;
    overflow:hidden;
}

.table thead th{
    padding:18px 20px;
    font-size:17px;
    font-weight:700;
    color:#374151;
    background:#FFFFFF;
    border-bottom:1px solid #E5E7EB;
    white-space:nowrap;
}

.table tbody td{
    padding:18px 20px;
    font-size:16px;
    font-weight:500;
    color:#1F2937;
    vertical-align:middle;
    border-bottom:1px solid #F1F5F9;
}

.table tbody tr:hover{
    background:#F9FAFB;
}
.table th:nth-child(1),
.table td:nth-child(1){
    width:220px;
}

.table th:nth-child(2),
.table td:nth-child(2){
    width:240px;
}

.table th:nth-child(3),
.table td:nth-child(3){
    width:120px;
}

.table th:nth-child(4),
.table td:nth-child(4){
    width:110px;
}

.table th:nth-child(5),
.table td:nth-child(5){
    width:110px;
}

.table th:nth-child(6),
.table td:nth-child(6){
    width:180px;
}

.table th:nth-child(7),
.table td:nth-child(7){
    width:160px;
}

.table th:nth-child(8),
.table td:nth-child(8){
    width:180px;
    text-align:center;
}

.table th:last-child,
.table td:last-child{
    width:150px;
    text-align:center;
}


.table th{
    font-size:17px;
}

.table td{
    font-size:16px;
}

.badge-planifiee{

    background:#DCFCE7;
    color:#166534;
    border-radius:20px;
    padding:6px 14px;

}

.badge-envoyee{

    background:#DBEAFE;
    color:#1D4ED8;
    border-radius:20px;
    padding:6px 14px;

}

.badge-annulee{

    background:#FEE2E2;
    color:#991B1B;
    border-radius:20px;
    padding:6px 14px;

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

    background:#F8FAFC;

    border-radius:8px;

    display:flex;
    justify-content:center;
    align-items:center;

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

.pagination{

    justify-content:center;
    margin-top:25px;

}
.badge-convoque{
    background:#DCFCE7;
    color:#166534;
    padding:7px 16px;
    border-radius:20px;
    font-weight:600;
}

.badge-present{
    background:#DBEAFE;
    color:#1D4ED8;
    padding:7px 16px;
    border-radius:20px;
    font-weight:600;
}

.badge-absent{
    background:#FEE2E2;
    color:#991B1B;
    padding:7px 16px;
    border-radius:20px;
    font-weight:600;
}

.badge-excuse{
    background:#FEF3C7;
    color:#92400E;
    padding:7px 16px;
    border-radius:20px;
    font-weight:600;
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


/* =========================================================
   TOPBAR PRINCIPALE
========================================================= */

.ormvasm-topbar {

    position: fixed;

    top: 0;
    left: 0;

    width: 100%;
    height: 70px;

    background: #FFFFFF;

    border-bottom: 1px solid #E5E7EB;

    display: flex;
    align-items: center;

    z-index: 5000;

    padding: 0 28px;

    box-shadow: 0 2px 12px rgba(0,0,0,.04);

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
   CENTRE
========================================================= */

.ormvasm-topbar-center {

    flex: 1;

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 12px;

    padding: 0 35px;

}


/* =========================================================
   RECHERCHE
========================================================= */

.ormvasm-search {

    width: 100%;

    max-width: 420px;

    height: 45px;

    display: flex;

    align-items: center;

    gap: 11px;

    padding: 0 15px;

    background: #F8FAFC;

    border: 1px solid #E5E7EB;

    border-radius: 11px;

    transition: .2s ease;

}


.ormvasm-search:focus-within {

    background: #FFFFFF;

    border-color: #15803D;

    box-shadow:
        0 0 0 3px rgba(21,128,61,.08);

}


.ormvasm-search i {

    color: #64748B;

    font-size: 16px;

}


.ormvasm-search input {

    width: 100%;

    border: 0;

    outline: none;

    background: transparent;

    color: #1F2937;

    font-size: 13px;

}


.ormvasm-search input::placeholder {

    color: #94A3B8;

}


/* =========================================================
   FILTRE STATUT
========================================================= */

.ormvasm-status-filter {

    width: 165px;

    height: 45px;

    border: 1px solid #E5E7EB;

    background: #F8FAFC;

    border-radius: 11px;

    padding: 0 13px;

    color: #475569;

    font-size: 12px;

    outline: none;

    cursor: pointer;

    transition: .2s ease;

}


.ormvasm-status-filter:focus {

    background: #FFFFFF;

    border-color: #15803D;

    box-shadow:
        0 0 0 3px rgba(21,128,61,.08);

}


/* =========================================================
   DROITE
========================================================= */

.ormvasm-topbar-right {

    display: flex;

    align-items: center;

    justify-content: flex-end;

    gap: 18px;

    flex-shrink: 0;

    min-width: 250px;

}


/* =========================================================
   NOTIFICATION
========================================================= */

.ormvasm-notification {

    position: relative;

}


.ormvasm-notification-btn {

    position: relative;

    width: 44px;

    height: 44px;

    border: 1px solid #E5E7EB;

    background: #FFFFFF;

    border-radius: 11px;

    display: flex;

    align-items: center;

    justify-content: center;

    cursor: pointer;

    color: #475569;

    transition: .2s ease;

}


.ormvasm-notification-btn:hover {

    color: #15803D;

    border-color: #15803D;

    background: #F0FDF4;

}


.ormvasm-notification-btn i {

    font-size: 19px;

}


/* =========================================================
   BADGE
========================================================= */

.ormvasm-notification-badge {

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
   PANNEAU NOTIFICATIONS
========================================================= */

.ormvasm-notification-panel {

    position: absolute;

    top: 55px;

    right: 0;

    width: 390px;

    max-height: 560px;

    background: #FFFFFF;

    border: 1px solid #E5E7EB;

    border-radius: 15px;

    box-shadow:
        0 15px 45px rgba(15,23,42,.15);

    overflow: hidden;

    opacity: 0;

    visibility: hidden;

    transform: translateY(-8px);

    transition: .2s ease;

    z-index: 6000;

}


.ormvasm-notification-panel.active {

    opacity: 1;

    visibility: visible;

    transform: translateY(0);

}


/* =========================================================
   HEADER NOTIFICATIONS
========================================================= */

.ormvasm-notification-header {

    padding: 18px 20px;

    border-bottom: 1px solid #E5E7EB;

}


.ormvasm-notification-title {

    color: #17324D;

    font-size: 15px;

    font-weight: 700;

}


.ormvasm-notification-subtitle {

    margin-top: 4px;

    color: #6B7280;

    font-size: 11px;

}


/* =========================================================
   LISTE
========================================================= */

.ormvasm-notification-list {

    max-height: 420px;

    overflow-y: auto;

}


.ormvasm-notification-item {

    display: flex;

    gap: 12px;

    padding: 15px 18px;

    border-bottom: 1px solid #F1F5F9;

    transition: .2s;

}


.ormvasm-notification-item:hover {

    background: #F8FAFC;

}


/* =========================================================
   ICONES
========================================================= */

.ormvasm-notification-icon {

    width: 38px;

    height: 38px;

    min-width: 38px;

    border-radius: 10px;

    display: flex;

    align-items: center;

    justify-content: center;

}


.ormvasm-notification-icon.orange {

    background: #FFEDD5;

    color: #F97316;

}


.ormvasm-notification-icon.blue {

    background: #E0F2FE;

    color: #0284C7;

}


.ormvasm-notification-icon.red {

    background: #FEE2E2;

    color: #DC2626;

}


.ormvasm-notification-icon.green {

    background: #DCFCE7;

    color: #15803D;

}


/* =========================================================
   CONTENU NOTIFICATION
========================================================= */

.ormvasm-notification-content {

    min-width: 0;

}


.ormvasm-notification-content strong {

    display: block;

    color: #1F2937;

    font-size: 12px;

}


.ormvasm-notification-content p {

    margin: 4px 0;

    color: #6B7280;

    font-size: 11px;

    line-height: 1.4;

}


.ormvasm-notification-time {

    color: #94A3B8;

    font-size: 10px;

}


/* =========================================================
   EMPTY
========================================================= */

.ormvasm-empty {

    padding: 35px 20px;

    text-align: center;

    color: #94A3B8;

}


.ormvasm-empty i {

    font-size: 30px;

    color: #15803D;

    margin-bottom: 10px;

}


.ormvasm-empty p {

    color: #6B7280;

    font-size: 12px;

}


/* =========================================================
   FOOTER NOTIFICATION
========================================================= */

.ormvasm-notification-footer {

    padding: 13px 18px;

    border-top: 1px solid #E5E7EB;

    text-align: center;

}


.ormvasm-notification-footer a {

    color: #15803D;

    font-size: 11px;

    font-weight: 600;

}


/* =========================================================
   UTILISATEUR
========================================================= */

.ormvasm-user {

    position: relative;

    display: flex;

    align-items: center;

    gap: 10px;

    cursor: pointer;

    padding: 5px 7px;

    border-radius: 11px;

}


.ormvasm-user:hover {

    background: #F8FAFC;

}


.ormvasm-user-label {

    display: flex;

    flex-direction: column;

    align-items: flex-end;

    line-height: 1.3;

}


.ormvasm-user-label strong {

    color: #1F2937;

    font-size: 12px;

    font-weight: 700;

}


.ormvasm-user-label span {

    margin-top: 3px;

    color: #6B7280;

    font-size: 10px;

}


.ormvasm-user-avatar {

    width: 43px;

    height: 43px;

    border-radius: 50%;

    display: flex;

    align-items: center;

    justify-content: center;

    background: #15803D;

    color: #FFFFFF;

    font-size: 13px;

    font-weight: 700;

}


/* =========================================================
   MENU UTILISATEUR
========================================================= */

.ormvasm-user-menu {

    position: absolute;

    top: 56px;

    right: 0;

    width: 230px;

    background: #FFFFFF;

    border: 1px solid #E5E7EB;

    border-radius: 13px;

    box-shadow:
        0 15px 40px rgba(15,23,42,.14);

    padding: 8px;

    opacity: 0;

    visibility: hidden;

    transform: translateY(-8px);

    transition: .2s ease;

    z-index: 6000;

}


.ormvasm-user-menu.active {

    opacity: 1;

    visibility: visible;

    transform: translateY(0);

}


.ormvasm-user-menu a,

.ormvasm-user-menu button {

    width: 100%;

    min-height: 42px;

    display: flex;

    align-items: center;

    gap: 10px;

    padding: 0 12px;

    border: 0;

    border-radius: 9px;

    background: transparent;

    color: #334155;

    font-size: 12px;

    text-align: left;

    cursor: pointer;

}


.ormvasm-user-menu a:hover,

.ormvasm-user-menu button:hover {

    background: #F0FDF4;

    color: #15803D;

}


.ormvasm-user-menu i {

    width: 18px;

    text-align: center;

    font-size: 15px;

}


.ormvasm-user-menu hr {

    border: 0;

    border-top: 1px solid #E5E7EB;

    margin: 7px 0;

}


/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width: 1200px) {

    .ormvasm-topbar-left {

        min-width: 300px;

    }

    .ormvasm-brand-name {

        max-width: 220px;

        font-size: 11px;

    }

    .ormvasm-topbar-center {

        padding: 0 20px;

    }

}


@media(max-width: 1000px) {

    .ormvasm-status-filter {

        display: none;

    }

    .ormvasm-search {

        max-width: 400px;

    }

}


@media(max-width: 850px) {

    .ormvasm-topbar {

        left: 0;

        width: 100%;

        padding: 0 15px;

    }

    .ormvasm-topbar-left {

        min-width: auto;

    }

    .ormvasm-brand-name {

        display: none;

    }

    .ormvasm-topbar-center {

        padding: 0 15px;

    }

    .ormvasm-user-label {

        display: none;

    }

}


@media(max-width: 600px) {

    .ormvasm-topbar {

        height: 72px;

    }

    .ormvasm-brand {

        width: 45px;

        height: 45px;

    }

    .ormvasm-brand img {

        width: 43px;

        height: 43px;

    }

    .ormvasm-topbar-center {

        padding: 0 8px;

    }

    .ormvasm-search {

        max-width: none;

        height: 40px;

    }

    .ormvasm-topbar-right {

        min-width: auto;

        gap: 7px;

    }

    .ormvasm-notification-btn {

        width: 40px;

        height: 40px;

    }

    .ormvasm-user-avatar {

        width: 40px;

        height: 40px;

    }

    .ormvasm-notification-panel {

        position: fixed;

        top: 80px;

        left: 10px;

        right: 10px;

        width: auto;

    }

    .ormvasm-user-menu {

        right: 0;

    }

}
.ormvasm-topbar{

    position:fixed;

    top:0;

    left:0;

    width:100%;

    height:70px;

    background:#FFFFFF;

    border-bottom:1px solid #E5E7EB;

    display:flex;

    align-items:center;

    z-index:5000;

    padding:0 28px;

    box-shadow:0 2px 12px rgba(0,0,0,.04);

}

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


</style>



{{-- =========================================================
     JAVASCRIPT TOPBAR
========================================================= --}}



</head>

<body>
@php
    $profil = session('user')->profil ?? '';

    $admin = $profil === 'Administrateur';
    $serviceRH = $profil === 'RH';
    $commission = $profil === 'Commission';
    $responsableService = $profil === 'Responsable de service';
    $consultation = $profil === 'Consultation';
@endphp
@include('layouts.sidebar')

<div class="main">
    @php

    /*
    |--------------------------------------------------------------------------
    | UTILISATEUR CONNECTÉ
    |--------------------------------------------------------------------------
    */

    $sessionUser = session('user');

    $prenomUtilisateur = $sessionUser->prenom ?? '';
    $nomUtilisateur    = $sessionUser->nom ?? '';

    $userInitials = strtoupper(
        substr($prenomUtilisateur, 0, 1) .
        substr($nomUtilisateur, 0, 1)
    ) ?: 'U';

    $userName = trim(
        $prenomUtilisateur . ' ' . $nomUtilisateur
    ) ?: 'Utilisateur';

    $userRole = $sessionUser->profil ?? 'Non connecté';

    $estAdmin =
        strtolower(trim($userRole)) === 'administrateur';


    /*
    |--------------------------------------------------------------------------
    | NOTIFICATIONS
    |--------------------------------------------------------------------------
    */

    // Candidatures reçues mais non traitées
    $candidaturesEnAttente =
        \Illuminate\Support\Facades\DB::table('candidatures')
            ->where('etat_candidature', 'recue')
            ->count();


    // Dossiers incomplets
    $dossiersIncomplets =
        \Illuminate\Support\Facades\DB::table('candidatures')
            ->where('dossier_complet', 0)
            ->count();


    // Offres qui expirent dans les 7 prochains jours
    $offresExpirentBientot =
        \Illuminate\Support\Facades\DB::table('offres_recrutement')
            ->where('statut', '!=', 'Fermée')
            ->whereDate(
                'date_limite_depot',
                '>=',
                now()->toDateString()
            )
            ->whereDate(
                'date_limite_depot',
                '<=',
                now()->addDays(7)->toDateString()
            )
            ->count();


    // Convocations à venir
    $convocationsAVenir =
        \Illuminate\Support\Facades\DB::table('convocations')
            ->whereDate(
                'date_convocation',
                '>=',
                now()->toDateString()
            )
            ->count();


    // Total notifications
    $nbNotifications =
        $candidaturesEnAttente +
        $dossiersIncomplets +
        $offresExpirentBientot +
        $convocationsAVenir;

@endphp


{{-- =========================================================
     TOPBAR CONVOCATIONS
========================================================= --}}

<header class="ormvasm-topbar">

    {{-- =====================================================
         GAUCHE : LOGO + NOM ORMVASM
    ====================================================== --}}

    <div class="topbar-left">

            <img src="{{ asset('image/ormvaa.png') }}" class="topbar-logo">

            <h5>
                Office Régional de Mise en Valeur Agricole
                du Souss Massa
            </h5>

        </div>
    {{-- =====================================================
         CENTRE : RECHERCHE + FILTRE
    ====================================================== --}}

    <div class="ormvasm-topbar-center">

        {{-- RECHERCHE --}}

        <div class="ormvasm-search">

            <i class="bi bi-search"></i>

            <input
                type="text"
                id="topbarSearch"
                placeholder="Rechercher une convocation..."
                autocomplete="off"
            >

        </div>


        {{-- FILTRE STATUT --}}

        <select
            id="statutFilter"
            class="ormvasm-status-filter"
        >

            <option value="">
                Tous les statuts
            </option>

            <option value="Convoqué">
                Convoqué
            </option>

            <option value="Présent">
                Présent
            </option>

            <option value="Absent">
                Absent
            </option>

            <option value="Excusé">
                Excusé
            </option>

        </select>

    </div>


    {{-- =====================================================
         DROITE
    ====================================================== --}}

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


            {{-- =================================================
                 PANNEAU NOTIFICATIONS
            ================================================== --}}

            <div
                class="ormvasm-notification-panel"
                id="notificationPanel"
            >

                {{-- HEADER --}}

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


                {{-- LISTE --}}

                <div class="ormvasm-notification-list">


                    {{-- =================================================
                         NOUVELLES CANDIDATURES
                    ================================================== --}}

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


                    {{-- =================================================
                         DOSSIERS INCOMPLETS
                    ================================================== --}}

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


                    {{-- =================================================
                         OFFRES BIENTÔT EXPIRÉES
                    ================================================== --}}

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


                    {{-- =================================================
                         CONVOCATIONS À VENIR
                    ================================================== --}}

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


                    {{-- =================================================
                         AUCUNE NOTIFICATION
                    ================================================== --}}

                    @if($nbNotifications === 0)

                        <div class="ormvasm-empty">

                            <i class="bi bi-check-circle"></i>

                            <p class="mb-0">
                                Aucune notification.
                            </p>

                        </div>

                    @endif

                </div>


                {{-- FOOTER --}}

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


            {{-- =================================================
                 MENU UTILISATEUR
            ================================================== --}}

            <div
                class="ormvasm-user-menu"
                id="userMenuPanel"
            >

                @if($estAdmin)

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

</header>





    <!-- ===========================
                CONTENU
    ============================ -->

    <div class="content">

        <div class="page-title">

            <div>

                <h2>

                    Gestion des convocations

                </h2>

                <p>

                    Liste des convocations des candidats.

                </p>

            </div>
            <div class="page-actions">

                @if($admin || $serviceRH || $commission)
                <a
                    href="{{ route('convocations.export.excel', request()->only('search', 'statut_presence')) }}"
                    class="btn-export">

                    <i class="bi bi-file-earmark-excel"></i>

                    Export Excel

                </a>

                <a
                    href="{{ route('convocations.export.pdf', request()->only('search', 'statut_presence')) }}"
                    class="btn-export">

                    <i class="bi bi-file-earmark-pdf"></i>

                    Export PDF

                </a>
                @endif

                @if($admin || $serviceRH)
                <a
                    href="{{ route('convocations.create') }}"
                    class="btn-add">

                    <i class="bi bi-plus-circle"></i>

                    Nouvelle convocation

                </a>
                @endif

            </div>
        </div>


        @if(session('success'))

            <div class="alert alert-success">

                <i class="bi bi-check-circle-fill me-2"></i>

                {{ session('success') }}

            </div>

        @endif


        @if(session('error'))

            <div class="alert alert-danger">

                <i class="bi bi-exclamation-triangle-fill me-2"></i>

                {{ session('error') }}

            </div>

        @endif


        <div class="card">

            <div class="table-responsive">

                <table
                    class="table align-middle"
                    id="convocationsTable">

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Candidat</th>

                            <th>Offre</th>

                            <th>Date</th>

                            <th>Heure</th>

                            <th>Type</th>

                            <th>Lieu</th>

                            <th>Présence</th>

                            <th width="170">

                                Actions

                            </th>

                        </tr>

                    </thead>

                    <tbody>
                     @forelse($convocations as $convocation)

<tr>

    <td>

        {{ $convocation->id_convocation }}

    </td>

    <td>

        <strong>

            {{ $convocation->candidature->candidat->nom ?? '-' }}

            {{ $convocation->candidature->candidat->prenom ?? '' }}

        </strong>

    </td>

    <td>

        {{ $convocation->candidature->offre->intitule_poste ?? '-' }}

    </td>

    <td>

        {{ \Carbon\Carbon::parse($convocation->date_convocation)->format('d/m/Y') }}

    </td>

    <td>

        {{ substr($convocation->heure_convocation,0,5) }}

    </td>

    <td>

        {{ $convocation->type_convocation }}

    </td>

    <td>

        {{ $convocation->lieu_convocation }}

    </td>

  <td>

@if($convocation->statut_presence == 'Convoqué')

    <span class="badge-convoque">
        {{ $convocation->statut_presence }}
    </span>

@elseif($convocation->statut_presence == 'Présent')

    <span class="badge-present">
        {{ $convocation->statut_presence }}
    </span>

@elseif($convocation->statut_presence == 'Absent')

    <span class="badge-absent">
        {{ $convocation->statut_presence }}
    </span>

@elseif($convocation->statut_presence == 'Excusé')

    <span class="badge-excuse">
        {{ $convocation->statut_presence }}
    </span>

@else

    {{ $convocation->statut_presence }}

@endif

</td>

    <td>

        <div class="action">

            <a
                href="{{ route('convocations.show',$convocation->id_convocation) }}"
                class="text-show"
                title="Afficher">

                <i class="bi bi-eye-fill"></i>

            </a>
             @if($admin || $serviceRH)
            <a
                href="{{ route('convocations.edit',$convocation->id_convocation) }}"
                class="text-edit"
                title="Modifier">

                <i class="bi bi-pencil-square"></i>

            </a>
             @endif
             @if($admin || $serviceRH)
            <form
                action="{{ route('convocations.destroy',$convocation->id_convocation) }}"
                method="POST"
                style="display:inline;"
                onsubmit="return confirm('Voulez-vous supprimer cette convocation ?')">

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

        <i class="bi bi-calendar-x fs-1 text-secondary"></i>

        <br><br>

        Aucune convocation disponible.

    </td>

</tr>

@endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-4">

                {{ $convocations->links() }}

            </div>

        </div>

    </div>
                </tbody>

        </table>

    </div>

    <div class="mt-4">

        {{ $convocations->links() }}

    </div>

</div>
<script>

const search = document.getElementById('tableSearch');
const statut = document.getElementById('statutFilter');

function filtrerConvocations(){

    let texte = search.value.toLowerCase();
    let statutChoisi = statut.value.toLowerCase();

    document.querySelectorAll("#convocationsTable tbody tr").forEach(function(row){

        let contenu = row.innerText.toLowerCase();

        let statutCell = row.cells[7].innerText.toLowerCase();

        let okRecherche = contenu.includes(texte);

        let okStatut = statutChoisi === "" || statutCell.includes(statutChoisi);

        row.style.display = (okRecherche && okStatut)
            ? ""
            : "none";

    });

}

search.addEventListener("keyup", filtrerConvocations);
statut.addEventListener("change", filtrerConvocations);

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        /*
        |--------------------------------------------------------------------------
        | ELEMENTS
        |--------------------------------------------------------------------------
        */

        const notificationButton =
            document.getElementById(
                'notificationButton'
            );

        const notificationPanel =
            document.getElementById(
                'notificationPanel'
            );

        const userMenuButton =
            document.getElementById(
                'userMenuButton'
            );

        const userMenuPanel =
            document.getElementById(
                'userMenuPanel'
            );


        /*
        |--------------------------------------------------------------------------
        | NOTIFICATIONS
        |--------------------------------------------------------------------------
        */

        if (
            notificationButton &&
            notificationPanel
        ) {

            notificationButton.addEventListener(
                'click',
                function (event) {

                    event.stopPropagation();

                    notificationPanel
                        .classList
                        .toggle('active');


                    if (userMenuPanel) {

                        userMenuPanel
                            .classList
                            .remove('active');

                    }

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | MENU UTILISATEUR
        |--------------------------------------------------------------------------
        */

        if (
            userMenuButton &&
            userMenuPanel
        ) {

            userMenuButton.addEventListener(
                'click',
                function (event) {

                    event.stopPropagation();

                    userMenuPanel
                        .classList
                        .toggle('active');


                    if (notificationPanel) {

                        notificationPanel
                            .classList
                            .remove('active');

                    }

                }
            );


            userMenuPanel.addEventListener(
                'click',
                function (event) {

                    event.stopPropagation();

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | FERMETURE EN CLIQUANT AILLEURS
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'click',
            function (event) {

                if (
                    notificationPanel &&
                    notificationButton &&
                    !notificationPanel.contains(event.target) &&
                    !notificationButton.contains(event.target)
                ) {

                    notificationPanel
                        .classList
                        .remove('active');

                }


                if (
                    userMenuPanel &&
                    userMenuButton &&
                    !userMenuPanel.contains(event.target) &&
                    !userMenuButton.contains(event.target)
                ) {

                    userMenuPanel
                        .classList
                        .remove('active');

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | RECHERCHE CONVOCATIONS
        |--------------------------------------------------------------------------
        */

        const topbarSearch =
            document.getElementById(
                'topbarSearch'
            );

        const statutFilter =
            document.getElementById(
                'statutFilter'
            );


        function filtrerConvocations() {

            const recherche =
                topbarSearch
                    ? topbarSearch.value
                        .toLowerCase()
                        .trim()
                    : '';


            const statut =
                statutFilter
                    ? statutFilter.value
                        .toLowerCase()
                        .trim()
                    : '';


            const lignes =
                document.querySelectorAll(
                    '#convocationsTable tbody tr'
                );


            lignes.forEach(
                function (ligne) {

                    /*
                    | Une ligne vide n'a pas les cellules
                    | nécessaires au filtrage.
                    */

                    if (
                        ligne.cells.length < 8
                    ) {

                        return;

                    }


                    const contenu =
                        ligne.innerText
                            .toLowerCase();


                    const celluleStatut =
                        ligne.cells[7]
                            .innerText
                            .toLowerCase()
                            .trim();


                    const correspondRecherche =
                        contenu.includes(
                            recherche
                        );


                    const correspondStatut =
                        statut === '' ||
                        celluleStatut.includes(
                            statut
                        );


                    ligne.style.display =
                        (
                            correspondRecherche &&
                            correspondStatut
                        )
                            ? ''
                            : 'none';

                }
            );

        }


        if (topbarSearch) {

            topbarSearch.addEventListener(
                'input',
                filtrerConvocations
            );

        }


        if (statutFilter) {

            statutFilter.addEventListener(
                'change',
                filtrerConvocations
            );

        }

    }
);

</script>
</body>
</html>
