@extends('layouts.app')
@php
    $profil = session('user')->profil ?? '';
    $profilNormalise = strtolower(trim($profil));
@endphp

{{--
    Profils officiels (référentiel PROFIL) : Administrateur, RH,
    Commission, Responsable de service, Consultation.
    L'Administrateur a toujours accès à tout, quel que soit le menu affiché.

    Comparaison normalisée (insensible à la casse/espaces), comme dans
    App\Http\Middleware\CheckProfil::normaliser() : le libellé du profil
    est saisi en texte libre depuis la page Paramètres, donc une simple
    comparaison "==" pouvait échouer sur une casse différente et masquer
    les actions rapides pour tous les profils sauf ceux tapés à l'identique.
--}}
@php
$admin = $profilNormalise === 'administrateur';

$serviceRH = $profilNormalise === 'rh';

$commission = $profilNormalise === 'commission';

$responsableService = $profilNormalise === 'responsable de service';

$consultation = $profilNormalise === 'consultation';

@endphp
@section('title', 'Tableau de bord | ORMVASM')

@section('content')

<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>

/* =========================================================
   VARIABLES
========================================================= */

:root{
    --green:#15803D;
    --green-dark:#166534;
    --green-light:#DCFCE7;

    --orange:#F97316;
    --orange-dark:#EA580C;
    --orange-light:#FFEDD5;

    --blue:#0284C7;
    --blue-dark:#0369A1;
    --blue-light:#E0F2FE;

    --red:#DC2626;
    --red-light:#FEE2E2;

    --bg:#F5F7F6;
    --white:#FFFFFF;

    --text:#1F2937;
    --text-dark:#17324D;
    --text-light:#6B7280;

    --border:#E5E7EB;

    --shadow:0 8px 25px rgba(0,0,0,.06);

    --radius:16px;
}


/* =========================================================
   RESET
========================================================= */

*{
    box-sizing:border-box;
}

/* Liens : professionnels, jamais soulignes ni bleus, meme visites */
a, a:visited, a:hover, a:active{
    color:inherit;
    text-decoration:none;
}


html{
    scroll-behavior:smooth;
}

body{
    margin:0;
    background:var(--bg);
    color:var(--text);
    font-family:"Segoe UI",Arial,sans-serif;
}

a{
    text-decoration:none;
    color:inherit;
}

button,
input,
select{
    font-family:inherit;
}


/* =========================================================
   DASHBOARD
========================================================= */

.ormvasm-dashboard{
    min-height:100vh;
    background:var(--bg);
}


/* =========================================================
   TOPBAR
========================================================= */

.ormvasm-topbar{

    position:fixed;

    top:0;
    left:0;
    right:0;

    height:75px;

    background:#fff;

    border-bottom:1px solid var(--border);

    display:flex;

    align-items:center;

    padding:0 28px;

    z-index:2000;

    box-shadow:0 2px 12px rgba(0,0,0,.04);

}


/* =========================================================
   BRAND
========================================================= */

.ormvasm-brand{

    
    margin:0;

    color:#15803D;

    font-size:17px;

    font-weight:600;

    line-height:1.3;
}

.ormvasm-brand img{

    width:100px;
    height:100px;

    object-fit:contain;

}

.ormvasm-brand-name{

    font-size:15px;

    font-weight:600;

    color:var(--green);

    line-height:1.3;

}


/* =========================================================
   TOPBAR CENTER
========================================================= */

.ormvasm-topbar-center{

    flex:1;

    display:flex;

    align-items:center;

    justify-content:center;

    gap:16px;

    min-width:0;

}


/* =========================================================
   SEARCH
========================================================= */

.ormvasm-search{

    width:390px;

    height:48px;

    border:1px solid #DCE3EA;

    border-radius:28px;

    background:#fff;

    display:flex;

    align-items:center;

    padding:0 18px;

    transition:.25s;

}

.ormvasm-search:focus-within{

    border-color:#0284C7;

    box-shadow:0 0 0 3px rgba(2,132,199,.10);

}

.ormvasm-search i{

    font-size:20px;

    color:#94A3B8;

    margin-right:12px;

}

.ormvasm-search input{

    width:100%;

    border:none;

    outline:none;

    font-size:14px;

    color:var(--text);

    background:transparent;

}

.ormvasm-search input::placeholder{

    color:#9CA3AF;

}


/* =========================================================
   FILTER
========================================================= */

.ormvasm-filter{

    height:48px;

    width:180px;

    padding:0 18px;

    border:1px solid #DCE3EA;

    border-radius:28px;

    background:#fff;

    color:var(--text);

    font-size:14px;

    outline:none;

    cursor:pointer;

}

.ormvasm-filter:focus{

    border-color:var(--blue);

}


/* =========================================================
   TOPBAR RIGHT
========================================================= */

.ormvasm-topbar-right{

    width:220px;

    display:flex;

    justify-content:flex-end;

    align-items:center;

    gap:17px;

    flex-shrink:0;

}


/* =========================================================
   NOTIFICATION
========================================================= */

.ormvasm-notification{

    position:relative;

}

.ormvasm-notification-btn{

    width:45px;

    height:45px;

    border:none;

    background:transparent;

    border-radius:50%;

    display:flex;

    align-items:center;

    justify-content:center;

    cursor:pointer;

    color:#475569;

}

.ormvasm-notification-btn:hover{

    background:#F1F5F9;

    color:var(--green);

}

.ormvasm-notification-btn i{

    font-size:24px;

}

.ormvasm-notification-badge{

    position:absolute;

    top:0;

    right:0;

    min-width:19px;

    height:19px;

    padding:0 5px;

    background:var(--red);

    color:white;

    border-radius:20px;

    font-size:10px;

    font-weight:700;

    display:flex;

    align-items:center;

    justify-content:center;

    border:2px solid white;

}


/* =========================================================
   NOTIFICATION PANEL
========================================================= */

.ormvasm-notification-panel{

    position:absolute;

    top:58px;

    right:-20px;

    width:400px;

    background:white;

    border:1px solid var(--border);

    border-radius:16px;

    box-shadow:0 18px 45px rgba(15,23,42,.15);

    overflow:hidden;

    opacity:0;

    visibility:hidden;

    transform:translateY(-10px);

    transition:.22s ease;

    z-index:3000;

}

.ormvasm-notification-panel.active{

    opacity:1;

    visibility:visible;

    transform:translateY(0);

}


/* =========================================================
   NOTIFICATION HEADER
========================================================= */

.ormvasm-notification-header{

    padding:18px 20px;

    border-bottom:1px solid var(--border);

    display:flex;

    align-items:center;

    justify-content:space-between;

}

.ormvasm-notification-title{

    font-size:17px;

    font-weight:700;

    color:var(--text);

}

.ormvasm-notification-subtitle{

    font-size:12px;

    color:var(--text-light);

    margin-top:4px;

}

.ormvasm-mark-read{

    border:none;

    background:transparent;

    color:var(--green);

    font-size:12px;

    font-weight:600;

    cursor:pointer;

}

.ormvasm-mark-read:hover{

    text-decoration:underline;

}


/* =========================================================
   NOTIFICATION LIST
========================================================= */

.ormvasm-notification-list{

    max-height:380px;

    overflow-y:auto;

}

.ormvasm-notification-item{

    display:flex;

    gap:13px;

    padding:16px 20px;

    border-bottom:1px solid #F1F5F9;

    transition:.2s;

    cursor:pointer;

}

.ormvasm-notification-item:hover{

    background:#F8FAFC;

}


/* =========================================================
   NOTIFICATION ICON
========================================================= */

.ormvasm-notification-icon{

    width:38px;

    height:38px;

    min-width:38px;

    border-radius:11px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:17px;

}

.ormvasm-notification-icon.orange{

    background:var(--orange-light);

    color:var(--orange);

}

.ormvasm-notification-icon.green{

    background:var(--green-light);

    color:var(--green);

}

.ormvasm-notification-icon.blue{

    background:var(--blue-light);

    color:var(--blue);

}

.ormvasm-notification-icon.red{

    background:var(--red-light);

    color:var(--red);

}


/* =========================================================
   NOTIFICATION CONTENT
========================================================= */

.ormvasm-notification-content{

    flex:1;

    min-width:0;

}

.ormvasm-notification-content strong{

    display:block;

    font-size:13px;

    color:var(--text);

    margin-bottom:4px;

}

.ormvasm-notification-content p{

    margin:0;

    font-size:12px;

    line-height:1.5;

    color:var(--text-light);

}

.ormvasm-notification-time{

    display:block;

    margin-top:5px;

    font-size:11px;

    color:#94A3B8;

}

.ormvasm-unread-dot{

    width:7px;

    height:7px;

    min-width:7px;

    background:var(--orange);

    border-radius:50%;

    margin-top:6px;

}


/* =========================================================
   NOTIFICATION FOOTER
========================================================= */

.ormvasm-notification-footer{

    padding:14px;

    text-align:center;

    background:#FAFAFA;

}

.ormvasm-notification-footer a{

    color:var(--green);

    font-size:13px;

    font-weight:600;

}


/* =========================================================
   USER
========================================================= */

.ormvasm-user{

    display:flex;

    align-items:center;

    gap:10px;

}

.ormvasm-user-label{

    color:var(--text-light);

    font-size:13px;

}

.ormvasm-user-avatar{

    width:48px;

    height:48px;

    border-radius:50%;

    background:var(--blue);

    color:white;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:17px;

    font-weight:600;

}


/* =========================================================
   SIDEBAR
========================================================= */

.ormvasm-sidebar{

    position:fixed;

    top:88px;

    left:0;

    bottom:0;

    width:260px;

    background:white;

    border-right:1px solid var(--border);

    padding:28px 15px;

    overflow-y:auto;

    z-index:1500;

}

.ormvasm-menu{

    list-style:none;

    padding:0;

    margin:0;

}

.ormvasm-menu-item{

    margin-bottom:7px;

}

.ormvasm-menu-link{

    height:53px;

    display:flex;

    align-items:center;

    gap:16px;

    padding:0 18px;

    border-radius:13px;

    color:#334155;

    font-size:14px;

    font-weight:500;

    transition:.2s;

}

.ormvasm-menu-link i{

    width:24px;

    text-align:center;

    font-size:19px;

    color:#475569;

}

.ormvasm-menu-link:hover{

    background:#F0FDF4;

    color:var(--green);

}

.ormvasm-menu-link:hover i{

    color:var(--green);

}

.ormvasm-menu-link.active{

    background:var(--green);

    color:white;

    font-weight:600;

}

.ormvasm-menu-link.active i{

    color:white;

}


/* =========================================================
   MAIN
========================================================= */

.ormvasm-main{

    /* Le decalage a gauche est deja gere par la vraie sidebar (.content, layouts/app.blade.php) :
       on ne le duplique plus ici pour eviter le double espacement a gauche. */
    margin-left:0;
    margin-right:0;
    padding-top:70px;

    min-height:100vh;

}

.ormvasm-content{
   
    max-width:100%;
    margin:auto;
}


/* =========================================================
   PAGE HEADER
========================================================= */

.ormvasm-page-header{

    display:flex;

    align-items:flex-start;

    justify-content:space-between;

    margin-bottom:35px;

}

.ormvasm-page-title{

    font-size:34px;

    line-height:1.2;

    font-weight:700;

    color:var(--text-dark);

    margin:0;

}

.ormvasm-page-subtitle{

    margin-top:8px;

    font-size:15px;

    color:var(--text-light);

}

.ormvasm-header-actions{

    display:flex;

    align-items:center;

    gap:12px;

}

.ormvasm-date{

    height:45px;

    display:flex;

    align-items:center;

    gap:9px;

    padding:0 16px;

    border:1px solid var(--border);

    border-radius:10px;

    background:white;

    color:var(--text-light);

    font-size:13px;

}

.ormvasm-date i{

    color:var(--blue);

}

.ormvasm-refresh{

    height:45px;

    padding:0 17px;

    border:1px solid var(--border);

    border-radius:10px;

    background:white;

    color:var(--text);

    cursor:pointer;

    display:flex;

    align-items:center;

    gap:8px;

    font-size:13px;

}

.ormvasm-refresh:hover{

    border-color:var(--green);

    color:var(--green);

}


/* =========================================================
   SECTION
========================================================= */

.ormvasm-section{

    margin-bottom:34px;

}

.ormvasm-section-header{

    display:flex;

    align-items:flex-start;

    justify-content:space-between;

    margin-bottom:18px;

}

.ormvasm-section-heading{

    display:flex;

    align-items:center;

    gap:10px;

    margin:0;

    font-size:20px;

    font-weight:700;

    color:var(--text-dark);

}

.ormvasm-section-heading i{

    color:var(--green);

    font-size:20px;

}

.ormvasm-section-description{

    margin:5px 0 0;

    color:var(--text-light);

    font-size:13px;

}


/* =========================================================
   STATS
========================================================= */

.ormvasm-stats-grid{

    display:grid;

    grid-template-columns:repeat(4,minmax(0,1fr));

    gap:18px;

}

.ormvasm-candidates-grid{

    display:grid;

    grid-template-columns:repeat(5,minmax(0,1fr));

    gap:18px;

}

.ormvasm-stat-card{

    position:relative;

    background:white;

    border:1px solid var(--border);

    border-radius:15px;

    padding:22px;

    min-height:150px;

    box-shadow:var(--shadow);

    overflow:hidden;

    transition:.25s ease;

}

.ormvasm-stat-card:hover{

    transform:translateY(-3px);

    box-shadow:0 12px 30px rgba(0,0,0,.09);

}

.ormvasm-stat-card::before{

    content:"";

    position:absolute;

    left:0;

    top:18px;

    bottom:18px;

    width:4px;

    border-radius:0 5px 5px 0;

}

.ormvasm-stat-card.blue::before{
    background:var(--blue);
}

.ormvasm-stat-card.green::before{
    background:var(--green);
}

.ormvasm-stat-card.orange::before{
    background:var(--orange);
}

.ormvasm-stat-card.red::before{
    background:var(--red);
}

.ormvasm-stat-top{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:16px;

}

.ormvasm-stat-label{

    font-size:13px;

    font-weight:600;

    color:var(--text-light);

}

.ormvasm-stat-icon{

    width:42px;

    height:42px;

    display:flex;

    align-items:center;

    justify-content:center;

    border-radius:10px;

    font-size:18px;

}

.ormvasm-stat-icon.blue{

    background:var(--blue-light);

    color:var(--blue);

}

.ormvasm-stat-icon.green{

    background:var(--green-light);

    color:var(--green);

}

.ormvasm-stat-icon.orange{

    background:var(--orange-light);

    color:var(--orange);

}

.ormvasm-stat-icon.red{

    background:var(--red-light);

    color:var(--red);

}

.ormvasm-stat-number{

    margin:0;

    font-size:31px;

    font-weight:700;

    color:var(--text-dark);

}

.ormvasm-stat-description{

    margin:5px 0 0;

    font-size:12px;

    color:var(--text-light);

}


/* =========================================================
   CHARTS
========================================================= */

.ormvasm-charts-grid{

    display:grid;

    grid-template-columns:1.45fr 1fr;

    gap:20px;

}

.ormvasm-chart-card{

    background:white;

    border:1px solid var(--border);

    border-radius:16px;

    box-shadow:var(--shadow);

    overflow:hidden;

}

.ormvasm-chart-header{

    padding:20px 22px;

    border-bottom:1px solid var(--border);

    display:flex;

    align-items:center;

    justify-content:space-between;

}

.ormvasm-chart-title{

    display:flex;

    align-items:center;

    gap:10px;

    margin:0;

    font-size:16px;

    font-weight:700;

    color:var(--text-dark);

}

.ormvasm-chart-title i{

    color:var(--blue);

}

.ormvasm-chart-subtitle{

    margin:4px 0 0;

    font-size:12px;

    color:var(--text-light);

}

.ormvasm-chart-body{

    padding:20px;

    height:330px;

}


/* =========================================================
   CARD
========================================================= */

.ormvasm-card{

    background:white;

    border:1px solid var(--border);

    border-radius:16px;

    box-shadow:var(--shadow);

    overflow:hidden;

}

.ormvasm-card-header{

    padding:21px 24px;

    border-bottom:1px solid var(--border);

    display:flex;

    align-items:center;

    justify-content:space-between;

}

.ormvasm-card-title{

    font-size:17px;

    font-weight:700;

    color:var(--text-dark);

}

.ormvasm-card-subtitle{

    color:var(--text-light);

    font-size:12px;

    margin-top:4px;

}

.ormvasm-card-link{

    color:var(--green);

    font-size:12px;

    font-weight:600;

}

.ormvasm-card-link:hover{

    text-decoration:underline;

}


/* =========================================================
   RECENT
========================================================= */

.ormvasm-recent-grid{

    display:grid;

    grid-template-columns:1.15fr 1fr;

    gap:20px;

    margin-bottom:34px;

}

.ormvasm-recent-grid .ormvasm-section{

    margin-bottom:0;

}


/* =========================================================
   APPLICATIONS
========================================================= */

.ormvasm-application-list{

    padding:0;

}

.ormvasm-application-row{

    display:flex;

    align-items:center;

    padding:17px 24px;

    border-bottom:1px solid #F1F5F9;

    gap:15px;

}

.ormvasm-application-row:last-child{

    border-bottom:none;

}

.ormvasm-candidate-avatar{

    width:42px;

    height:42px;

    min-width:42px;

    border-radius:50%;

    background:var(--blue-light);

    color:var(--blue);

    display:flex;

    align-items:center;

    justify-content:center;

    font-weight:700;

}

.ormvasm-candidate-info{

    flex:1;

    min-width:0;

}

.ormvasm-candidate-name{

    font-size:13px;

    font-weight:600;

    color:var(--text);

}

.ormvasm-candidate-offer{

    font-size:11px;

    color:var(--text-light);

    margin-top:4px;

    white-space:nowrap;

    overflow:hidden;

    text-overflow:ellipsis;

}


/* =========================================================
   STATUS
========================================================= */

.ormvasm-status{

    display:inline-flex;

    align-items:center;

    gap:6px;

    padding:7px 11px;

    border-radius:20px;

    font-size:11px;

    font-weight:600;

    white-space:nowrap;

}

.ormvasm-status::before{

    content:"";

    width:6px;

    height:6px;

    border-radius:50%;

    background:currentColor;

}

.ormvasm-status.green{

    color:var(--green);

    background:var(--green-light);

}

.ormvasm-status.orange{

    color:var(--orange);

    background:var(--orange-light);

}

.ormvasm-status.blue{

    color:var(--blue);

    background:var(--blue-light);

}

.ormvasm-status.red{

    color:var(--red);

    background:var(--red-light);

}


/* =========================================================
   ALERTS
========================================================= */

.ormvasm-alert-list{

    padding:0;

}

.ormvasm-alert-item{

    display:flex;

    align-items:center;

    gap:15px;

    padding:17px 24px;

    border-bottom:1px solid #F1F5F9;

}

.ormvasm-alert-item:last-child{

    border-bottom:none;

}

.ormvasm-alert-icon{

    width:40px;

    height:40px;

    min-width:40px;

    border-radius:11px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:17px;

}

.ormvasm-alert-icon.orange{

    background:var(--orange-light);

    color:var(--orange);

}

.ormvasm-alert-icon.blue{

    background:var(--blue-light);

    color:var(--blue);

}

.ormvasm-alert-icon.green{

    background:var(--green-light);

    color:var(--green);

}

.ormvasm-alert-icon.red{

    background:var(--red-light);

    color:var(--red);

}

.ormvasm-alert-content{

    flex:1;

}

.ormvasm-alert-content strong{

    display:block;

    font-size:13px;

    color:var(--text);

}

.ormvasm-alert-content span{

    display:block;

    margin-top:4px;

    color:var(--text-light);

    font-size:11px;

}

.ormvasm-alert-count{

    min-width:30px;

    height:30px;

    padding:0 8px;

    border-radius:9px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:12px;

    font-weight:700;

}

.ormvasm-alert-count.orange{

    background:var(--orange-light);

    color:var(--orange);

}

.ormvasm-alert-count.blue{

    background:var(--blue-light);

    color:var(--blue);

}

.ormvasm-alert-count.green{

    background:var(--green-light);

    color:var(--green);

}

.ormvasm-alert-count.red{

    background:var(--red-light);

    color:var(--red);

}


/* =========================================================
   QUICK ACTIONS
========================================================= */

.ormvasm-quick-actions{

    display:grid;

    grid-template-columns:repeat(5,1fr);

    gap:15px;

    padding:22px 24px;

}

.ormvasm-quick-action{

    border:1px solid var(--border);

    background:white;

    border-radius:12px;

    padding:17px 12px;

    display:flex;

    flex-direction:column;

    align-items:center;

    justify-content:center;

    gap:10px;

    min-height:105px;

    color:var(--text);

    transition:.2s;

}

.ormvasm-quick-action i{

    font-size:22px;

}

.ormvasm-quick-action span{

    font-size:12px;

    font-weight:600;

    text-align:center;

}

.ormvasm-quick-action:hover{

    border-color:var(--green);

    background:#F0FDF4;

    color:var(--green);

    transform:translateY(-2px);

}

.ormvasm-quick-action.orange i{

    color:var(--orange);

}

.ormvasm-quick-action.green i{

    color:var(--green);

}

.ormvasm-quick-action.blue i{

    color:var(--blue);

}


/* =========================================================
   TABLE
========================================================= */

.ormvasm-table-wrapper{

    overflow-x:auto;

}

.ormvasm-offers-table{

    width:100%;

    border-collapse:collapse;

}

.ormvasm-offers-table th{

    text-align:left;

    padding:15px 20px;

    background:#FAFAFA;

    color:#475569;

    font-size:12px;

    font-weight:600;

    border-bottom:1px solid var(--border);

    white-space:nowrap;

}

.ormvasm-offers-table td{

    padding:17px 20px;

    border-bottom:1px solid #F1F5F9;

    font-size:13px;

    color:var(--text);

}

.ormvasm-offers-table tr:last-child td{

    border-bottom:none;

}

.ormvasm-offers-table tr:hover td{

    background:#FAFCFB;

}

.ormvasm-offer-reference{

    color:var(--green);

    font-weight:600;

}


/* =========================================================
   EMPTY
========================================================= */

.ormvasm-empty{

    padding:45px 20px;

    text-align:center;

    color:#94A3B8;

}

.ormvasm-empty i{

    display:block;

    font-size:34px;

    margin-bottom:12px;

    color:#A7B7CA;

}

.ormvasm-empty p{

    margin:0;

    font-size:14px;

}


/* =========================================================
   FOOTER
========================================================= */

.ormvasm-footer{

    text-align:center;

    padding:28px 20px;

    color:#94A3B8;

    font-size:11px;

}


/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width:1400px){

    .ormvasm-brand{
        width:260px;
    }

    .ormvasm-brand-name{
        font-size:13px;
    }

    .ormvasm-search{
        width:320px;
    }

    .ormvasm-sidebar{
        width:240px;
    }

    .ormvasm-main{
        margin-left:0;
    }

    .ormvasm-content{
        padding:30px;
    }

}


@media(max-width:1200px){

    .ormvasm-brand{
        width:220px;
    }

    .ormvasm-brand-name{
        display:none;
    }

    .ormvasm-search{
        width:300px;
    }

    .ormvasm-stats-grid{
        grid-template-columns:repeat(2,1fr);
    }

    .ormvasm-candidates-grid{
        grid-template-columns:repeat(3,1fr);
    }

    .ormvasm-recent-grid{
        grid-template-columns:1fr;
    }

}


@media(max-width:1000px){

    .ormvasm-topbar{
        padding:0 18px;
    }

    .ormvasm-topbar-center{
        display:none;
    }

    .ormvasm-topbar-right{
        margin-left:auto;
        width:auto;
    }

    .ormvasm-sidebar{
        width:78px;
        padding:25px 10px;
    }

    .ormvasm-menu-link{
        justify-content:center;
        padding:0;
    }

    .ormvasm-menu-link span{
        display:none;
    }

    .ormvasm-main{
        margin-left:0;
    }

}


@media(max-width:700px){

    .ormvasm-topbar{
        height:72px;
    }

    .ormvasm-sidebar{
        top:72px;
        width:65px;
    }

    .ormvasm-main{
        padding-top:72px;
        margin-left:0;
    }

    .ormvasm-content{
        padding:25px 15px;
    }

    .ormvasm-page-header{
        flex-direction:column;
        gap:18px;
    }

    .ormvasm-page-title{
        font-size:27px;
    }

    .ormvasm-stats-grid{
        grid-template-columns:1fr;
    }

    .ormvasm-candidates-grid{
        grid-template-columns:repeat(2,1fr);
    }

    .ormvasm-quick-actions{
        grid-template-columns:repeat(2,1fr);
    }

    .ormvasm-notification-panel{
        position:fixed;
        top:70px;
        left:10px;
        right:10px;
        width:auto;
    }

    .ormvasm-date{
        display:none;
    }

}


@media(max-width:480px){

    .ormvasm-candidates-grid{
        grid-template-columns:1fr;
    }

    .ormvasm-quick-actions{
        grid-template-columns:1fr;
    }

    .ormvasm-application-row{
        flex-wrap:wrap;
    }

    .ormvasm-status{
        margin-left:57px;
    }

}

</style>
@include('layouts.sidebar')

<div class="ormvasm-dashboard">


{{-- =========================================================
     TOPBAR
========================================================= --}}

<header class="ormvasm-topbar">


    {{-- BRAND --}}

    <div class="ormvasm-brand">

        <img
            src="{{ asset('image/ormvaa.png') }}"
            alt="ORMVASM"
        >

        
    </div>
    <div class="ormvasm-brand-name">
            Office Régional de Mise en Valeur Agricole du Souss Massa
        </div>



    {{-- SEARCH + FILTER --}}

    <div class="ormvasm-topbar-center">

        <div class="ormvasm-search">

            <i class="bi bi-search"></i>

            <input
                type="text"
                id="dashboardSearch"
                placeholder="Rechercher dans le dashboard..."
                autocomplete="off"
            >

        </div>

    </div>


    {{-- RIGHT --}}

    <div class="ormvasm-topbar-right">


        {{-- NOTIFICATIONS --}}

        <div class="ormvasm-notification">

            <button
                type="button"
                class="ormvasm-notification-btn"
                id="notificationButton"
                title="Notifications"
            >

                <i class="bi bi-bell"></i>

                @if(($nbNotifications ?? 0) > 0)

                    <span
                        class="ormvasm-notification-badge"
                        id="notificationBadge"
                    >
                        {{ $nbNotifications }}
                    </span>

                @endif

            </button>


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
                                {{ $nbNotifications ?? 0 }}
                            </span>

                            notifications

                        </div>

                    </div>

                    <button
                        type="button"
                        class="ormvasm-mark-read"
                        id="markAllRead"
                    >
                        Tout marquer comme lu
                    </button>

                </div>


                <div class="ormvasm-notification-list">


                    {{-- CANDIDATURES --}}

                    @if(($candidaturesEnAttente ?? 0) > 0)

                    <div class="ormvasm-notification-item unread">

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

                        <span class="ormvasm-unread-dot"></span>

                    </div>

                    @endif


                    {{-- DOSSIERS INCOMPLETS --}}

                    @if(($dossiersIncomplets ?? 0) > 0)

                    <div class="ormvasm-notification-item unread">

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

                        <span class="ormvasm-unread-dot"></span>

                    </div>

                    @endif


                    {{-- OFFRES EXPIRANT --}}

                    @if(($offresExpirentBientot ?? 0) > 0)

                    <div class="ormvasm-notification-item unread">

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

                        <span class="ormvasm-unread-dot"></span>

                    </div>

                    @endif


                    {{-- CONVOCATIONS --}}

                    @if(($convocationsAVenir ?? 0) > 0)

                    <div class="ormvasm-notification-item unread">

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

                        <span class="ormvasm-unread-dot"></span>

                    </div>

                    @endif


                    {{-- AUCUNE NOTIFICATION --}}

                    @if(
                        ($candidaturesEnAttente ?? 0) == 0 &&
                        ($dossiersIncomplets ?? 0) == 0 &&
                        ($offresExpirentBientot ?? 0) == 0 &&
                        ($convocationsAVenir ?? 0) == 0
                    )

                        <div class="ormvasm-empty">

                            <i class="bi bi-check-circle"></i>

                            <p>
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


        {{-- USER --}}

        <div class="ormvasm-user">

            <span class="ormvasm-user-label">
                {{ session('user')->profil ?? 'Utilisateur' }}
            </span>

            <div class="ormvasm-user-avatar">

                @php

                    $prenom =
                        session('user')->prenom
                        ?? '';

                    $nom =
                        session('user')->nom
                        ?? '';

                    $initiales =
                        strtoupper(
                            substr($prenom,0,1)
                            .
                            substr($nom,0,1)
                        );

                @endphp

                {{ $initiales ?: 'U' }}

            </div>

        </div>

    </div>

</header>




{{-- =========================================================
     MAIN
========================================================= --}}

<main class="ormvasm-main">

<div class="ormvasm-content">


{{-- =========================================================
     HEADER
========================================================= --}}

<div class="ormvasm-page-header">

    <div>

        <h1 class="ormvasm-page-title">
            Tableau de bord
        </h1>

        <p class="ormvasm-page-subtitle">
            Vue globale du processus de recrutement
        </p>

    </div>


    <div class="ormvasm-header-actions">

        <div class="ormvasm-date">

            <i class="bi bi-calendar3"></i>

            {{ now()->format('d/m/Y') }}

        </div>


        <button
            type="button"
            class="ormvasm-refresh"
            onclick="location.reload()"
        >

            <i class="bi bi-arrow-clockwise"></i>

            Actualiser

        </button>

    </div>

</div>



{{-- =========================================================
     1. VUE GENERALE
========================================================= --}}

<section
    class="ormvasm-section dashboard-category"
    data-category="offres candidatures"
>

    <div class="ormvasm-section-header">

        <div>

            <h2 class="ormvasm-section-heading">

                <i class="bi bi-grid-fill"></i>

                Vue générale

            </h2>

            <p class="ormvasm-section-description">
                Situation globale des offres et candidatures
            </p>

        </div>

    </div>


    <div class="ormvasm-stats-grid">


        {{-- TOTAL OFFRES --}}

        <div
            class="ormvasm-stat-card blue searchable-card"
            data-search="total offres offres enregistrées"
        >

            <div class="ormvasm-stat-top">

                <span class="ormvasm-stat-label">
                    Total offres
                </span>

                <div class="ormvasm-stat-icon blue">

                    <i class="bi bi-briefcase-fill"></i>

                </div>

            </div>

            <h2 class="ormvasm-stat-number">

                {{ $totalOffres ?? 0 }}

            </h2>

            <p class="ormvasm-stat-description">

                Toutes les offres enregistrées

            </p>

        </div>


        {{-- OFFRES OUVERTES --}}

        <div
            class="ormvasm-stat-card green searchable-card"
            data-search="offres ouvertes recrutement en cours"
        >

            <div class="ormvasm-stat-top">

                <span class="ormvasm-stat-label">
                    Offres ouvertes
                </span>

                <div class="ormvasm-stat-icon green">

                    <i class="bi bi-folder2-open"></i>

                </div>

            </div>

            <h2 class="ormvasm-stat-number">

                {{ $offresOuvertes ?? 0 }}

            </h2>

            <p class="ormvasm-stat-description">

                Recrutements en cours

            </p>

        </div>


        {{-- OFFRES FERMEES --}}

        <div
            class="ormvasm-stat-card orange searchable-card"
            data-search="offres clôturées fermées terminées"
        >

            <div class="ormvasm-stat-top">

                <span class="ormvasm-stat-label">
                    Offres clôturées
                </span>

                <div class="ormvasm-stat-icon orange">

                    <i class="bi bi-folder-check"></i>

                </div>

            </div>

            <h2 class="ormvasm-stat-number">

                {{ $offresFermees ?? 0 }}

            </h2>

            <p class="ormvasm-stat-description">

                Offres terminées

            </p>

        </div>


        {{-- CANDIDATURES --}}

        <div
            class="ormvasm-stat-card blue searchable-card"
            data-search="total candidatures candidatures reçues"
        >

            <div class="ormvasm-stat-top">

                <span class="ormvasm-stat-label">
                    Total candidatures
                </span>

                <div class="ormvasm-stat-icon blue">

                    <i class="bi bi-file-earmark-text-fill"></i>

                </div>

            </div>

            <h2 class="ormvasm-stat-number">

                {{ $totalCandidatures ?? 0 }}

            </h2>

            <p class="ormvasm-stat-description">

                Candidatures reçues

            </p>

        </div>


    </div>

</section>



{{-- =========================================================
     2. DOSSIERS
========================================================= --}}

<section
    class="ormvasm-section dashboard-category"
    data-category="dossiers candidatures"
>

    <div class="ormvasm-section-header">

        <div>

            <h2 class="ormvasm-section-heading">

                <i class="bi bi-folder-fill"></i>

                Suivi des dossiers

            </h2>

            <p class="ormvasm-section-description">
                État administratif des dossiers candidats
            </p>

        </div>

    </div>


    <div class="ormvasm-stats-grid">


        <div
            class="ormvasm-stat-card green searchable-card"
            data-search="dossiers complets conformes"
        >

            <div class="ormvasm-stat-top">

                <span class="ormvasm-stat-label">
                    Dossiers complets
                </span>

                <div class="ormvasm-stat-icon green">

                    <i class="bi bi-file-earmark-check-fill"></i>

                </div>

            </div>

            <h2 class="ormvasm-stat-number">

                {{ $dossiersComplets ?? 0 }}

            </h2>

            <p class="ormvasm-stat-description">

                Dossiers conformes

            </p>

        </div>


        <div
            class="ormvasm-stat-card red searchable-card"
            data-search="dossiers incomplets compléter documents"
        >

            <div class="ormvasm-stat-top">

                <span class="ormvasm-stat-label">
                    Dossiers incomplets
                </span>

                <div class="ormvasm-stat-icon red">

                    <i class="bi bi-file-earmark-x-fill"></i>

                </div>

            </div>

            <h2 class="ormvasm-stat-number">

                {{ $dossiersIncomplets ?? 0 }}

            </h2>

            <p class="ormvasm-stat-description">

                Dossiers à compléter

            </p>

        </div>


        <div
            class="ormvasm-stat-card orange searchable-card"
            data-search="non traitées candidatures attente traitement"
        >

            <div class="ormvasm-stat-top">

                <span class="ormvasm-stat-label">
                    Non traitées
                </span>

                <div class="ormvasm-stat-icon orange">

                    <i class="bi bi-hourglass-split"></i>

                </div>

            </div>

            <h2 class="ormvasm-stat-number">

                {{ $candidaturesEnAttente ?? 0 }}

            </h2>

            <p class="ormvasm-stat-description">

                Candidatures à traiter

            </p>

        </div>


        <div
            class="ormvasm-stat-card blue searchable-card"
            data-search="à archiver dossiers archives"
        >

            <div class="ormvasm-stat-top">

                <span class="ormvasm-stat-label">
                    À archiver
                </span>

                <div class="ormvasm-stat-icon blue">

                    <i class="bi bi-archive-fill"></i>

                </div>

            </div>

            <h2 class="ormvasm-stat-number">

                {{ $dossiersAArchiver ?? 0 }}

            </h2>

            <p class="ormvasm-stat-description">

                Dossiers à archiver

            </p>

        </div>


    </div>

</section>



{{-- =========================================================
     3. CANDIDATS
========================================================= --}}

<section
    class="ormvasm-section dashboard-category"
    data-category="candidats candidatures"
>

    <div class="ormvasm-section-header">

        <div>

            <h2 class="ormvasm-section-heading">

                <i class="bi bi-people-fill"></i>

                Suivi des candidats

            </h2>

            <p class="ormvasm-section-description">

                Progression des candidats dans le processus de recrutement

            </p>

        </div>

    </div>


    <div class="ormvasm-candidates-grid">


        <div
            class="ormvasm-stat-card blue searchable-card"
            data-search="présélectionnés candidats"
        >

            <div class="ormvasm-stat-top">

                <span class="ormvasm-stat-label">
                    Présélectionnés
                </span>

                <div class="ormvasm-stat-icon blue">

                    <i class="bi bi-person-check"></i>

                </div>

            </div>

            <h2 class="ormvasm-stat-number">

                {{ $preselectionnes ?? 0 }}

            </h2>

            <p class="ormvasm-stat-description">

                Candidats présélectionnés

            </p>

        </div>


        <div
            class="ormvasm-stat-card red searchable-card"
            data-search="rejetés refus non admis candidats"
        >

            <div class="ormvasm-stat-top">

                <span class="ormvasm-stat-label">
                    Rejetés
                </span>

                <div class="ormvasm-stat-icon red">

                    <i class="bi bi-person-x"></i>

                </div>

            </div>

            <h2 class="ormvasm-stat-number">

                {{ $rejetes ?? 0 }}
            </h2>

            <p class="ormvasm-stat-description">

                Candidats non retenus

            </p>

        </div>


        <div
            class="ormvasm-stat-card orange searchable-card"
            data-search="convoqués convocations candidats"
        >

            <div class="ormvasm-stat-top">

                <span class="ormvasm-stat-label">
                    Convoqués
                </span>

                <div class="ormvasm-stat-icon orange">

                    <i class="bi bi-calendar-event"></i>

                </div>

            </div>

            <h2 class="ormvasm-stat-number">

                {{ $convoques ?? 0 }}

            </h2>

            <p class="ormvasm-stat-description">

                Candidats convoqués

            </p>

        </div>


        <div
            class="ormvasm-stat-card green searchable-card"
            data-search="admis retenus candidats"
        >

            <div class="ormvasm-stat-top">

                <span class="ormvasm-stat-label">
                    Admis
                </span>

                <div class="ormvasm-stat-icon green">

                    <i class="bi bi-person-check-fill"></i>

                </div>

            </div>

            <h2 class="ormvasm-stat-number">

                {{ $admis ?? 0 }}

            </h2>

            <p class="ormvasm-stat-description">

                Candidats retenus

            </p>

        </div>


        <div
            class="ormvasm-stat-card green searchable-card"
            data-search="recrutements finalisés terminés"
        >

            <div class="ormvasm-stat-top">

                <span class="ormvasm-stat-label">
                    Recrutements finalisés
                </span>

                <div class="ormvasm-stat-icon green">

                    <i class="bi bi-award-fill"></i>

                </div>

            </div>

            <h2 class="ormvasm-stat-number">

                {{ $recrutementsFinalises ?? 0 }}

            </h2>

            <p class="ormvasm-stat-description">

                Recrutements terminés

            </p>

        </div>


    </div>

</section>



{{-- =========================================================
     4. STATISTIQUES
========================================================= --}}

<section
    class="ormvasm-section dashboard-category"
    data-category="candidatures candidats statistiques"
>

    <div class="ormvasm-section-header">

        <div>

            <h2 class="ormvasm-section-heading">

                <i class="bi bi-graph-up-arrow"></i>

                Statistiques

            </h2>

            <p class="ormvasm-section-description">

                Analyse globale du processus de recrutement

            </p>

        </div>

    </div>


    <div class="ormvasm-charts-grid">


        {{-- CHART 1 --}}

        <div class="ormvasm-chart-card">

            <div class="ormvasm-chart-header">

                <div>

                    <h3 class="ormvasm-chart-title">

                        <i class="bi bi-bar-chart-fill"></i>

                        Candidatures par mois

                    </h3>

                    <p class="ormvasm-chart-subtitle">

                        Évolution des candidatures reçues

                    </p>

                </div>

            </div>


            <div class="ormvasm-chart-body">

                <canvas id="candidaturesParOffreChart"></canvas>

            </div>

        </div>


        {{-- CHART 2 --}}

        <div class="ormvasm-chart-card">

            <div class="ormvasm-chart-header">

                <div>

                    <h3 class="ormvasm-chart-title">

                        <i class="bi bi-pie-chart-fill"></i>

                        État des candidats

                    </h3>

                    <p class="ormvasm-chart-subtitle">

                        Répartition des candidats selon leur état

                    </p>

                </div>

            </div>


            <div class="ormvasm-chart-body">

                <canvas id="etatCandidatsChart"></canvas>

            </div>

        </div>


    </div>

</section>



{{-- =========================================================
     5. ALERTES
========================================================= --}}

<section class="ormvasm-section">

    <div class="ormvasm-section-header">

        <div>

            <h2 class="ormvasm-section-heading">

                <i class="bi bi-exclamation-triangle-fill"></i>

                Alertes

            </h2>

            <p class="ormvasm-section-description">

                Éléments nécessitant votre attention

            </p>

        </div>

    </div>


    <div class="ormvasm-card">

        <div class="ormvasm-alert-list">


            {{-- CANDIDATURES --}}

            <div class="ormvasm-alert-item">

                <div class="ormvasm-alert-icon orange">

                    <i class="bi bi-person-plus-fill"></i>

                </div>

                <div class="ormvasm-alert-content">

                    <strong>
                        Candidatures non traitées
                    </strong>

                    <span>
                        Candidatures en attente de traitement
                    </span>

                </div>

                <div class="ormvasm-alert-count orange">

                    {{ $candidaturesEnAttente ?? 0 }}

                </div>

            </div>


            {{-- DOSSIERS --}}

            <div class="ormvasm-alert-item">

                <div class="ormvasm-alert-icon blue">

                    <i class="bi bi-folder2-open"></i>

                </div>

                <div class="ormvasm-alert-content">

                    <strong>
                        Dossiers incomplets
                    </strong>

                    <span>
                        Documents à vérifier
                    </span>

                </div>

                <div class="ormvasm-alert-count blue">

                    {{ $dossiersIncomplets ?? 0 }}

                </div>

            </div>


            {{-- OFFRES --}}

            <div class="ormvasm-alert-item">

                <div class="ormvasm-alert-icon red">

                    <i class="bi bi-clock-history"></i>

                </div>

                <div class="ormvasm-alert-content">

                    <strong>
                        Offres bientôt expirées
                    </strong>

                    <span>
                        Vérifier les dates limites
                    </span>

                </div>

                <div class="ormvasm-alert-count red">

                    {{ $offresExpirentBientot ?? 0 }}

                </div>

            </div>


            {{-- CONVOCATIONS --}}

            <div class="ormvasm-alert-item">

                <div class="ormvasm-alert-icon green">

                    <i class="bi bi-calendar-check"></i>

                </div>

                <div class="ormvasm-alert-content">

                    <strong>
                        Candidats convoqués prochainement
                    </strong>

                    <span>
                        Prochaines convocations
                    </span>

                </div>

                <div class="ormvasm-alert-count green">

                    {{ $convocationsAVenir ?? 0 }}

                </div>

            </div>


        </div>

    </div>

</section>



{{-- =========================================================
     6. CANDIDATURES + OFFRES
========================================================= --}}

<div class="ormvasm-recent-grid">


    {{-- CANDIDATURES RECENTES --}}

    <section class="ormvasm-section">

        <div class="ormvasm-card">


            <div class="ormvasm-card-header">

                <div>

                    <div class="ormvasm-card-title">

                        Candidatures récentes

                    </div>

                    <div class="ormvasm-card-subtitle">

                        Les dernières candidatures reçues.

                    </div>

                </div>


                <a
                    href="{{ url('/candidatures') }}"
                    class="ormvasm-card-link"
                >

                    Voir tout

                    <i class="bi bi-arrow-right"></i>

                </a>

            </div>


            <div class="ormvasm-application-list">


                @if(
                    isset($candidaturesRecentes)
                    &&
                    count($candidaturesRecentes) > 0
                )


                    @foreach(
                        $candidaturesRecentes
                        as $candidature
                    )


                        @php

                            $nom =
                                $candidature->candidat->nom
                                ?? 'Candidat';

                            $prenom =
                                $candidature->candidat->prenom
                                ?? '';

                            $initiale =
                                strtoupper(
                                    substr(
                                        $prenom ?: $nom,
                                        0,
                                        1
                                    )
                                );

                            $etat =
                                strtolower(
                                    $candidature->etat_candidature
                                    ?? ''
                                );

                            $statusClass = 'blue';


                            if(
                                str_contains($etat,'accept')
                                ||
                                str_contains($etat,'valid')
                                ||
                                str_contains($etat,'admis')
                            ){

                                $statusClass = 'green';

                            }

                            elseif(
                                str_contains($etat,'rejet')
                                ||
                                str_contains($etat,'refus')
                            ){

                                $statusClass = 'red';

                            }

                            elseif(
                                str_contains($etat,'attente')
                                ||
                                str_contains($etat,'cours')
                                ||
                                str_contains($etat,'convo')
                            ){

                                $statusClass = 'orange';

                            }

                        @endphp


                        <div
                            class="ormvasm-application-row"
                            data-searchable="
                                {{ strtolower(
                                    ($nom ?? '')
                                    .' '.
                                    ($prenom ?? '')
                                    .' '.
                                    ($candidature->offre->titre ?? '')
                                    .' '.
                                    ($candidature->etat_candidature ?? '')
                                ) }}
                            "
                        >


                            <div class="ormvasm-candidate-avatar">

                                {{ $initiale }}

                            </div>


                            <div class="ormvasm-candidate-info">

                                <div class="ormvasm-candidate-name">

                                    {{ $nom }}

                                    {{ $prenom }}

                                </div>


                                <div class="ormvasm-candidate-offer">

                                    {{ $candidature->offre->titre
                                        ?? 'Offre non disponible' }}

                                </div>

                            </div>


                            <span
                                class="ormvasm-status {{ $statusClass }}"
                            >

                                {{ $candidature->etat_candidature
                                    ?? 'En attente' }}

                            </span>


                        </div>


                    @endforeach


                @else


                    <div class="ormvasm-empty">

                        <i class="bi bi-inbox"></i>

                        <p>
                            Aucune candidature récente.
                        </p>

                    </div>


                @endif


            </div>

        </div>

    </section>



    {{-- OFFRES RECENTES --}}

    <section class="ormvasm-section">

        <div class="ormvasm-card">


            <div class="ormvasm-card-header">

                <div>

                    <div class="ormvasm-card-title">

                        Offres récentes

                    </div>

                    <div class="ormvasm-card-subtitle">

                        Les dernières offres de recrutement.

                    </div>

                </div>


                <a
                    href="{{ url('/offres') }}"
                    class="ormvasm-card-link"
                >

                    Voir toutes

                    <i class="bi bi-arrow-right"></i>

                </a>

            </div>


            <div class="ormvasm-table-wrapper">


                <table class="ormvasm-offers-table">


                    <thead>

                        <tr>

                            <th>
                                Référence
                            </th>

                            <th>
                                Intitulé
                            </th>

                            <th>
                                Statut
                            </th>

                        </tr>

                    </thead>


                    <tbody>


                    @if(
                        isset($offresRecentes)
                        &&
                        count($offresRecentes) > 0
                    )


                        @foreach(
                            $offresRecentes
                            as $offre
                        )


                            @php

                                $statut =
                                    strtolower(
                                        $offre->statut ?? ''
                                    );

                                $statusClass = 'blue';


                                if(
                                    str_contains(
                                        $statut,
                                        'ouvert'
                                    )
                                    ||
                                    str_contains(
                                        $statut,
                                        'publi'
                                    )
                                ){

                                    $statusClass = 'green';

                                }

                                elseif(
                                    str_contains(
                                        $statut,
                                        'expir'
                                    )
                                    ||
                                    str_contains(
                                        $statut,
                                        'ferm'
                                    )
                                    ||
                                    str_contains(
                                        $statut,
                                        'clôt'
                                    )
                                ){

                                    $statusClass = 'red';

                                }

                                elseif(
                                    str_contains(
                                        $statut,
                                        'attente'
                                    )
                                ){

                                    $statusClass = 'orange';

                                }

                            @endphp


                            <tr
                                data-searchable="
                                    {{ strtolower(
                                        ($offre->reference ?? '')
                                        .' '.
                                        ($offre->titre ?? '')
                                        .' '.
                                        ($offre->statut ?? '')
                                    ) }}
                                "
                            >

                                <td>

                                    <span
                                        class="ormvasm-offer-reference"
                                    >

                                        {{ $offre->reference_offre }}

                                    </span>

                                </td>


                                <td>

                                    {{ $offre->intitule_poste ?? '-' }}

                                </td>


                                <td>

                                    <span
                                        class="ormvasm-status
                                        {{ $statusClass }}"
                                    >

                                        {{ $offre->statut
                                            ?? 'Non défini' }}

                                    </span>

                                </td>

                            </tr>


                        @endforeach


                    @else


                        <tr>

                            <td colspan="3">

                                <div class="ormvasm-empty">

                                    <i class="bi bi-briefcase"></i>

                                    <p>
                                        Aucune offre récente.
                                    </p>

                                </div>

                            </td>

                        </tr>


                    @endif


                    </tbody>


                </table>

            </div>

        </div>

    </section>


</div>



{{-- =========================================================
     7. ACTIONS RAPIDES
========================================================= --}}

@if($admin || $serviceRH)
<section class="ormvasm-section">

    <div class="ormvasm-card">


        <div class="ormvasm-card-header">

            <div>

                <div class="ormvasm-card-title">

                    Actions rapides

                </div>

                <div class="ormvasm-card-subtitle">

                    Accès direct aux principales fonctionnalités.

                </div>

            </div>

        </div>


        <div class="ormvasm-quick-actions">


            @if($admin || $serviceRH)

        <a href="{{ url('/offres/create') }}"
        class="ormvasm-quick-action orange">

            <i class="bi bi-plus-circle"></i>

            <span>Nouvelle offre</span>

        </a>

        @endif


            <a
                href="{{ url('/candidats/create') }}"
                class="ormvasm-quick-action blue"
            >

                <i class="bi bi-person-plus"></i>

                <span>
                    Ajouter un candidat
                </span>

            </a>


            <a
                href="{{ url('/candidatures') }}"
                class="ormvasm-quick-action orange"
            >

                <i class="bi bi-file-earmark-plus"></i>

                <span>
                    Candidatures
                </span>

            </a>


            <a
                href="{{ url('/convocations') }}"
                class="ormvasm-quick-action green"
            >

                <i class="bi bi-calendar-plus"></i>

                <span>
                    Convocations
                </span>

            </a>


            @if($admin || $commission)

<a
    href="{{ url('/evaluations') }}"
    class="ormvasm-quick-action green"
>

    <i class="bi bi-clipboard-check"></i>

    <span>
        Évaluations
    </span>

</a>

@endif

            @if($admin)

<a
    href="{{ url('/utilisateurs') }}"
    class="ormvasm-quick-action blue"
>

    <i class="bi bi-people"></i>

    <span>
        Utilisateurs
    </span>

</a>

@endif
            

        </div>

    </div>

</section>
@endif

@if($admin || $serviceRH)
<section class="ormvasm-section">

    <div class="ormvasm-card">

        <div class="ormvasm-card-header">

            <div>

                <div class="ormvasm-card-title">
                    Exporter les rapports
                </div>


                <div class="ormvasm-card-subtitle">
                    Télécharger la liste des offres et des candidatures.
                </div>

            </div>

        </div>

        <div class="ormvasm-quick-actions">

            @if($admin || $serviceRH || $responsableService)

            <a href="{{ route('dashboard.export.excel') }}"
            class="ormvasm-quick-action green">

                <i class="bi bi-file-earmark-excel"></i>

                <span>
                    Export Excel
                </span>

            </a>

            @endif

           
            @if($admin || $serviceRH || $responsableService)
            <a href="{{ route('dashboard.export.pdf') }}"
            class="ormvasm-quick-action red">

                <i class="bi bi-file-earmark-pdf"></i>

                <span>
                    Export PDF
                </span>

            </a>

            @endif

        </div>

    </div>

</section>
@endif



{{-- =========================================================
     FOOTER
========================================================= --}}

<footer class="ormvasm-footer">

    © {{ date('Y') }}

    Office Régional de Mise en Valeur Agricole du Souss Massa

    — Tous droits réservés.

</footer>


</div>

</main>

</div>



{{-- =========================================================
     CHART.JS
========================================================= --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>

document.addEventListener(
    'DOMContentLoaded',
    function(){


/* =========================================================
   NOTIFICATIONS
========================================================= */

const notificationButton =
    document.getElementById(
        'notificationButton'
    );

const notificationPanel =
    document.getElementById(
        'notificationPanel'
    );

const markAllRead =
    document.getElementById(
        'markAllRead'
    );

const notificationBadge =
    document.getElementById(
        'notificationBadge'
    );

const notificationCount =
    document.getElementById(
        'notificationCount'
    );


if(
    notificationButton
    &&
    notificationPanel
){

    notificationButton.addEventListener(
        'click',
        function(event){

            event.stopPropagation();

            notificationPanel.classList.toggle(
                'active'
            );

        }
    );


    document.addEventListener(
        'click',
        function(event){

            if(
                !notificationPanel.contains(
                    event.target
                )
                &&
                !notificationButton.contains(
                    event.target
                )
            ){

                notificationPanel.classList.remove(
                    'active'
                );

            }

        }
    );

}


/* =========================================================
   MARK ALL READ
========================================================= */

if(markAllRead){

    markAllRead.addEventListener(
        'click',
        function(){

            const unreadItems =
                document.querySelectorAll(
                    '.ormvasm-notification-item.unread'
                );


            unreadItems.forEach(
                function(item){

                    item.classList.remove(
                        'unread'
                    );

                    const dot =
                        item.querySelector(
                            '.ormvasm-unread-dot'
                        );

                    if(dot){

                        dot.remove();

                    }

                }
            );


            if(notificationBadge){

                notificationBadge.textContent =
                    '0';

                notificationBadge.style.display =
                    'none';

            }


            if(notificationCount){

                notificationCount.textContent =
                    '0';

            }

        }
    );

}


/* =========================================================
   CHART 1
========================================================= */

const candidaturesCanvas =
    document.getElementById(
        'candidaturesParOffreChart'
    );


if(candidaturesCanvas){

    new Chart(
        candidaturesCanvas,
        {

            type:'bar',

            data:{

                labels:@json(
                    $labels ?? []
                ),

                datasets:[{

                    label:
                        'Nombre de candidatures',

                    data:@json(
                        $data ?? []
                    ),

                    backgroundColor:
                        '#0284C7',

                    borderColor:
                        '#0369A1',

                    borderWidth:1,

                    borderRadius:7,

                    maxBarThickness:50

                }]

            },

            options:{

                responsive:true,

                maintainAspectRatio:false,

                plugins:{

                    legend:{

                        display:false

                    }

                },

                scales:{

                    y:{

                        beginAtZero:true,

                        ticks:{

                            precision:0

                        },

                        grid:{

                            color:'#E5E7EB'

                        }

                    },

                    x:{

                        grid:{

                            display:false

                        }

                    }

                }

            }

        }
    );

}


/* =========================================================
   CHART 2
========================================================= */

const etatCanvas =
    document.getElementById(
        'etatCandidatsChart'
    );


if(etatCanvas){

    new Chart(
        etatCanvas,
        {

            type:'doughnut',

            data:{

                labels:[

                    'Présélectionnés',

                    'Rejetés',

                    'Convoqués',

                    'Admis'

                ],

                datasets:[{

                    data:[

                        {{ $preselectionnes ?? 0 }},

                        {{ $rejetes ?? $nonAdmis ?? 0 }},

                        {{ $convoques ?? 0 }},

                        {{ $admis ?? 0 }}

                    ],

                    backgroundColor:[

                        '#0284C7',

                        '#DC2626',

                        '#F97316',

                        '#15803D'

                    ],

                    borderWidth:3,

                    borderColor:'#FFFFFF'

                }]

            },

            options:{

                responsive:true,

                maintainAspectRatio:false,

                cutout:'65%',

                plugins:{

                    legend:{

                        position:'bottom',

                        labels:{

                            padding:18,

                            usePointStyle:true

                        }

                    }

                }

            }

        }
    );

}


/* =========================================================
   SEARCH DASHBOARD
========================================================= */

const searchInput =
    document.getElementById(
        'dashboardSearch'
    );

const dashboardFilter =
    document.getElementById(
        'dashboardFilter'
    );


function filterDashboard(){

    const value =
        searchInput
        ?
        searchInput.value
            .toLowerCase()
            .trim()
        :
        '';


    const category =
        dashboardFilter
        ?
        dashboardFilter.value
        :
        'all';


    const sections =
        document.querySelectorAll(
            '.dashboard-category'
        );


    sections.forEach(
        function(section){

            const sectionCategory =
                section.dataset.category
                ||
                '';


            let categoryMatch =
                category === 'all'
                ||
                sectionCategory
                    .toLowerCase()
                    .includes(category);


            if(!categoryMatch){

                section.style.display =
                    'none';

                return;

            }


            section.style.display =
                '';


            if(!value){

                section
                    .querySelectorAll(
                        '.searchable-card'
                    )
                    .forEach(
                        function(card){

                            card.style.display =
                                '';

                        }
                    );

                return;

            }


            const cards =
                section.querySelectorAll(
                    '.searchable-card'
                );


            let found =
                false;


            cards.forEach(
                function(card){

                    const text =
                        (
                            card.dataset.search
                            ||
                            card.innerText
                        )
                        .toLowerCase();


                    if(
                        text.includes(value)
                    ){

                        card.style.display =
                            '';

                        found = true;

                    }
                    else{

                        card.style.display =
                            'none';

                    }

                }
            );


            const rows =
                section.querySelectorAll(
                    '[data-searchable]'
                );


            rows.forEach(
                function(row){

                    const text =
                        row.dataset.searchable
                            .toLowerCase();


                    row.style.display =
                        text.includes(value)
                        ?
                        ''
                        :
                        'none';

                }
            );


            if(
                cards.length > 0
                &&
                !found
            ){

                /*
                 * On garde la section visible
                 * pour éviter de casser la mise en page.
                 */

            }

        }
    );

}


if(searchInput){

    searchInput.addEventListener(
        'input',
        filterDashboard
    );

}


if(dashboardFilter){

    dashboardFilter.addEventListener(
        'change',
        filterDashboard
    );

}


/* =========================================================
   ESCAPE = FERMER NOTIFICATION
========================================================= */

document.addEventListener(
    'keydown',
    function(event){

        if(event.key === 'Escape'){

            if(notificationPanel){

                notificationPanel.classList.remove(
                    'active'
                );

            }

        }

    }
);


});

</script>

@endsection