<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard | ORMVASM</title>


<!-- Bootstrap Icons -->
<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
/*====================================================
                VARIABLES
====================================================*/

:root{

    --green:#15803D;
    --green-light:#DCFCE7;

    --orange:#F97316;
    --orange-light:#FFEDD5;

    --blue:#2563EB;
    --blue-light:#DBEAFE;

    --red:#DC2626;
    --red-light:#FEE2E2;

    --purple:#7C3AED;
    --purple-light:#EDE9FE;

    --gray:#6B7280;
    --gray-light:#F3F4F6;

    --dark:#111827;

    --background:#F6F8FB;

    --border:#E5E7EB;

}



/*====================================================
                GENERAL
====================================================*/


*{

    margin:0;
    padding:0;
    box-sizing:border-box;

}

.main{

    margin-left:260px;
    margin-top:70px;      /* hauteur de la topbar */
    width:calc(100% - 260px);
    min-height:calc(100vh - 70px);

}

body{

    font-family:'Poppins',Arial,sans-serif;

    background:var(--background);

    color:#374151;

}



.dashboard{

    padding:30px;

    min-height:100vh;

}




/*====================================================
                HEADER
====================================================*/


.dashboard-header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:30px;

}



.header-left h2{

    font-size:28px;

    font-weight:700;

    color:var(--dark);

}



.header-left p{

    color:#6B7280;

    margin-top:8px;

}



.today{

    background:white;

    padding:14px 22px;

    border-radius:14px;

    border:1px solid var(--border);

    font-weight:600;

    box-shadow:0 4px 12px rgba(0,0,0,.04);

}



.today i{

    color:var(--green);

    margin-right:8px;

}





/*====================================================
                STATISTIQUES
====================================================*/


.stats-grid{

    display:grid;

    grid-template-columns:repeat(4,1fr);

    gap:20px;

    margin-bottom:25px;

}




.stat-card{

    background:white;

    border-radius:18px;

    padding:22px;

    display:flex;

    align-items:center;

    gap:18px;

    border:1px solid var(--border);

    transition:.3s;

}



.stat-card:hover{

    transform:translateY(-6px);

    box-shadow:0 15px 30px rgba(0,0,0,.08);

}




.stat-icon{

    width:60px;

    height:60px;

    border-radius:16px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:26px;

}




.stat-content h3{

    font-size:30px;

    font-weight:700;

    color:var(--dark);

}



.stat-content p{

    margin:0;

    color:#6B7280;

    font-size:14px;

}




/* COULEURS */


.blue .stat-icon{

    background:var(--blue-light);

    color:var(--blue);

}



.green .stat-icon{

    background:var(--green-light);

    color:var(--green);

}



.orange .stat-icon{

    background:var(--orange-light);

    color:var(--orange);

}



.red .stat-icon{

    background:var(--red-light);

    color:var(--red);

}



.purple .stat-icon{

    background:var(--purple-light);

    color:var(--purple);

}



.gray .stat-icon{

    background:var(--gray-light);

    color:var(--gray);

}





/*====================================================
        GRAPH + TABLE CARDS
====================================================*/


.dashboard-row{

    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:25px;

    margin-bottom:25px;

}




.dashboard-card{

    background:white;

    border-radius:18px;

    border:1px solid var(--border);

    overflow:hidden;

}



.card-header{

    padding:20px;

    border-bottom:1px solid var(--border);

}



.card-header h4{

    margin:0;

    font-size:17px;

    font-weight:700;

    color:var(--dark);

}



.card-header i{

    color:var(--green);

    margin-right:8px;

}



.card-body{

    padding:20px;

}




/*====================================================
                TABLEAUX
====================================================*/


.dashboard-table{

    width:100%;

    border-collapse:collapse;

}



.dashboard-table th{

    background:#F9FAFB;

    padding:15px;

    text-align:left;

    color:#6B7280;

    font-size:13px;

}



.dashboard-table td{

    padding:15px;

    border-bottom:1px solid #F1F5F9;

    font-size:14px;

}



.dashboard-table tbody tr:hover{

    background:#F9FAFB;

}




/*====================================================
                BADGES
====================================================*/


.badge{

    padding:7px 14px;

    border-radius:30px;

    font-size:12px;

    font-weight:600;

}



.badge-success{

    background:#DCFCE7;

    color:#15803D;

}



.badge-danger{

    background:#FEE2E2;

    color:#DC2626;

}





/*====================================================
                AVATAR
====================================================*/


.avatar-small{

    width:42px;

    height:42px;

    border-radius:50%;

    background:#DCFCE7;

    color:var(--green);

    display:flex;

    align-items:center;

    justify-content:center;

    font-weight:700;

}




/*====================================================
                CHART
====================================================*/


canvas{

    max-height:320px;

}





/*====================================================
                RESPONSIVE
====================================================*/


@media(max-width:1200px){


    .stats-grid{

        grid-template-columns:repeat(3,1fr);

    }


}



@media(max-width:900px){


    .stats-grid{

        grid-template-columns:repeat(2,1fr);

    }



    .dashboard-row{

        grid-template-columns:1fr;

    }


}



@media(max-width:600px){


    .dashboard{

        padding:15px;

    }



    .dashboard-header{

        flex-direction:column;

        align-items:flex-start;

        gap:15px;

    }



    .stats-grid{

        grid-template-columns:1fr;

    }



    .stat-content h3{

        font-size:24px;

    }


}
.content{
    margin-left:260px;
    
}
/* ===========================
        TOPBAR
=========================== */

/* ===========================
        TOPBAR RIGHT
=========================== */


.topbar-right{

    display:flex;

    align-items:center;

    gap:25px;

}

.topbar{

    height:70px;

    width:100%;

    background:white;

    display:flex;

    justify-content:space-between;

    align-items:center;

    padding:0 30px;

    border-bottom:1px solid var(--border);

    position:fixed;

    top:0;

    left:0;

    z-index:1100;

}



.topbar-left{

    display:flex;

    align-items:center;

    gap:15px;

}



.topbar-logo{

    width:90px;

    height:60px;

    object-fit:contain;

}



.topbar-left h5{

    color:var(--green);

    font-size:16px;

    font-weight:600;

    margin:0;

}

/* NOTIFICATION */


.notification{

    position:relative;

    cursor:pointer;

}


.notification i{

    font-size:22px;

    color:#374151;

}



.notification-count{


    position:absolute;

    top:-8px;

    right:-10px;


    background:var(--red);


    color:white;


    width:20px;

    height:20px;


    border-radius:50%;


    font-size:11px;


    display:flex;

    justify-content:center;

    align-items:center;


}





/* PROFILE */


.profile-menu{

    display:flex;

    align-items:center;

    gap:12px;


    cursor:pointer;


    padding:8px 12px;


    border-radius:12px;


    transition:.3s;


}



.profile-menu:hover{

    background:var(--green-light);

}





.avatar{


    width:45px;

    height:45px;


    border-radius:50%;


    background:var(--blue);


    color:white;


    display:flex;

    justify-content:center;

    align-items:center;


    font-weight:700;


}




.profile-info{


    display:flex;

    flex-direction:column;


}



.profile-info strong{


    color:var(--dark);


    font-size:14px;


}



.profile-info small{


    color:var(--gray);


    font-size:12px;


}



.profile-menu i{

    color:var(--gray);

}
.settings-container{

    margin-left:260px;

    padding:100px 40px 40px;

    min-height:100vh;

    background:var(--background);

}
</style>


</head>


<body>
@extends('layouts.app')


@section('content')
@include('layouts.sidebar')
<div class="topbar">

    <div class="topbar-left">

        <img src="{{ asset('image/ormvaa.png') }}" class="topbar-logo">

        <h5>
            Office Régional de Mise en Valeur Agricole du Souss Massa
        </h5>

    </div>



    <div class="topbar-right">


        <!-- Notifications -->

        <div class="notification">

            <i class="bi bi-bell-fill"></i>

            <span class="notification-count">

                     {{ $notifications ?? 0 }}

            </span>
        </div>




        <!-- Profil -->

        <div class="profile-menu">


            <div class="avatar">

                {{ strtoupper(substr(session('user')->prenom,0,1)) }}
                {{ strtoupper(substr(session('user')->nom,0,1)) }}

            </div>



            <div class="profile-info">

                <strong>

                    {{ session('user')->prenom }}
                    {{ session('user')->nom }}

                </strong>


                <small>

                    {{ optional(session('user')->profil)->libelle ?? 'Utilisateur' }}

                </small>

            </div>


            <i class="bi bi-chevron-down"></i>


        </div>


    </div>


</div>

<div class="main">
     

    <div class="dashboard">


    <!-- ==========================
            HEADER
    =========================== -->

    <div class="dashboard-header">

        <div class="header-left">

            <h2>
                Bonjour,
                {{ session('user')->prenom }}
                {{ session('user')->nom }}
            </h2>

            <p>
                Bienvenue dans le système de gestion des recrutements ORMVASM.
            </p>

        </div>

        <div class="header-right">

            <div class="today">

                <i class="bi bi-calendar3"></i>

                {{ now()->locale('fr')->translatedFormat('l d F Y') }}

            </div>

        </div>

    </div>
     

    <!-- ==========================
            STATISTIQUES
    =========================== -->

    <div class="stats-grid">

        <!-- Utilisateurs -->

        <div class="stat-card blue">

            <div class="stat-icon">
                <i class="bi bi-people-fill"></i>
            </div>

            <div class="stat-content">

                <h3>{{ $totalUtilisateurs }}</h3>

                <p>Utilisateurs</p>

            </div>

        </div>


        <!-- Offres -->

        <div class="stat-card green">

            <div class="stat-icon">
                <i class="bi bi-briefcase-fill"></i>
            </div>

            <div class="stat-content">

                <h3>{{ $totalOffres }}</h3>

                <p>Offres</p>

            </div>

        </div>


        <!-- Offres ouvertes -->

        <div class="stat-card orange">

            <div class="stat-icon">
                <i class="bi bi-folder2-open"></i>
            </div>

            <div class="stat-content">

                <h3>{{ $offresOuvertes }}</h3>

                <p>Offres ouvertes</p>

            </div>

        </div>


        <!-- Offres clôturées -->

        <div class="stat-card red">

            <div class="stat-icon">
                <i class="bi bi-folder-x"></i>
            </div>

            <div class="stat-content">

                <h3>{{ $offresCloturees }}</h3>

                <p>Offres clôturées</p>

            </div>

        </div>


        <!-- Candidats -->

        <div class="stat-card purple">

            <div class="stat-icon">
                <i class="bi bi-person-vcard-fill"></i>
            </div>

            <div class="stat-content">

                <h3>{{ $totalCandidats }}</h3>

                <p>Candidats</p>

            </div>

        </div>


        <!-- Candidatures -->

        <div class="stat-card blue">

            <div class="stat-icon">
                <i class="bi bi-file-earmark-text-fill"></i>
            </div>

            <div class="stat-content">

                <h3>{{ $totalCandidatures }}</h3>

                <p>Candidatures</p>

            </div>

        </div>


        <!-- Convocations -->

        <div class="stat-card green">

            <div class="stat-icon">
                <i class="bi bi-calendar-check-fill"></i>
            </div>

            <div class="stat-content">

                <h3>{{ $totalConvocations }}</h3>

                <p>Convocations</p>

            </div>

        </div>


        <!-- Documents -->

        <div class="stat-card gray">

            <div class="stat-icon">
                <i class="bi bi-folder-fill"></i>
            </div>

            <div class="stat-content">

                <h3>{{ $totalDocuments }}</h3>

                <p>Documents</p>

            </div>

        </div>

    </div>
        <!-- ==========================
            STATISTIQUES SECONDAIRES
    =========================== -->

    <div class="stats-grid">

        <div class="stat-card green">
            <div class="stat-icon ">
                <i class="bi bi-folder-check"></i>
            </div>

            <div class="stat-content">
                <h3>{{ $dossiersComplets }}</h3>
                <p>Dossiers complets</p>
            </div>
        </div>

        <div class="stat-card orange">
            <div class="stat-icon orange">
                <i class="bi bi-folder-x"></i>
            </div>

            <div class="stat-content">
                <h3>{{ $dossiersIncomplets }}</h3>
                <p>Dossiers incomplets</p>
            </div>
        </div>

        <div class="stat-card red">
            <div class="stat-icon green">
                <i class="bi bi-person-check-fill"></i>
            </div>

            <div class="stat-content">
                <h3>{{ $preselectionnes }}</h3>
                <p>Présélectionnés</p>
            </div>
        </div>

        <div class="stat-card purple">
            <div class="stat-icon red">
                <i class="bi bi-person-x-fill"></i>
            </div>

            <div class="stat-content">
                <h3>{{ $rejetes }}</h3>
                <p>Rejetés</p>
            </div>
        </div>

        <div class="stat-card blue">
            <div class="stat-icon purple">
                <i class="bi bi-award-fill"></i>
            </div>

            <div class="stat-content">
                <h3>{{ $admis }}</h3>
                <p>Admis</p>
            </div>
        </div>

        <div class="stat-card gray">
            <div class="stat-icon gray">
                <i class="bi bi-check2-circle"></i>
            </div>

            <div class="stat-content">
                <h3>{{ $recrutementsFinalises }}</h3>
                <p>Recrutements finalisés</p>
            </div>
        </div>

        <div class="stat-card orange">
            <div class="stat-icon orange">
                <i class="bi bi-clock-history"></i>
            </div>

            <div class="stat-content">
                <h3>{{ $candidaturesAttente }}</h3>
                <p>En attente</p>
            </div>
        </div>

        <div class="stat-card green">
            <div class="stat-icon blue">
                <i class="bi bi-calendar-event"></i>
            </div>

            <div class="stat-content">
                <h3>{{ $convocationsAVenir }}</h3>
                <p>À venir</p>
            </div>
        </div>

    </div>


    <!-- ==========================
            GRAPHIQUES
    =========================== -->

    <div class="dashboard-row">

        <div class="dashboard-card">

            <div class="card-header">

                <h4>

                    <i class="bi bi-bar-chart-line-fill"></i>

                    Evolution des offres

                </h4>

            </div>

            <div class="card-body">

                <canvas id="offresChart"></canvas>

            </div>

        </div>


        <div class="dashboard-card">

            <div class="card-header">

                <h4>

                    <i class="bi bi-pie-chart-fill"></i>

                    Répartition des profils

                </h4>

            </div>

            <div class="card-body">

                <canvas id="profilChart"></canvas>

            </div>

        </div>

    </div>
        <!-- ============================================
                DERNIERES OFFRES
    ============================================= -->

    <div class="dashboard-row">

        <div class="dashboard-card">

            <div class="card-header">

                <h4>

                    <i class="bi bi-briefcase-fill"></i>

                    Dernières offres

                </h4>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="dashboard-table">

                        <thead>

                            <tr>

                                <th>Référence</th>

                                <th>Poste</th>

                                <th>Statut</th>

                                <th>Date limite</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($dernieresOffres as $offre)

                                <tr>

                                    <td>

                                        {{ $offre->reference_offre }}

                                    </td>

                                    <td>

                                        {{ $offre->intitule_poste }}

                                    </td>

                                    <td>

                                        @if($offre->statut=="Ouverte")

                                            <span class="badge badge-success">

                                                Ouverte

                                            </span>

                                        @else

                                            <span class="badge badge-danger">

                                                Fermée

                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        {{ \Carbon\Carbon::parse($offre->date_limite_depot)->format('d/m/Y') }}

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="4" class="text-center">

                                        Aucune offre disponible.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>





        <!-- ============================================
                    DERNIERS UTILISATEURS
        ============================================= -->

        <div class="dashboard-card">

            <div class="card-header">

                <h4>

                    <i class="bi bi-people-fill"></i>

                    Derniers utilisateurs

                </h4>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="dashboard-table">

                        <thead>

                            <tr>

                                <th>Utilisateur</th>

                                <th>Profil</th>

                                <th>Etat</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($derniersUtilisateurs as $user)

                                <tr>

                                    <td>

                                        <div style="display:flex;align-items:center;gap:10px;">

                                            <div class="avatar-small">

                                                {{ strtoupper(substr($user->prenom,0,1)) }}

                                                {{ strtoupper(substr($user->nom,0,1)) }}

                                            </div>

                                            <div>

                                                <strong>

                                                    {{ $user->prenom }}

                                                    {{ $user->nom }}

                                                </strong>

                                                <br>

                                                <small>

                                                    {{ $user->email }}

                                                </small>

                                            </div>

                                        </div>

                                    </td>

                                    <td>

                                        {{ optional($user->profil)->libelle ?? '-' }}

                                    </td>

                                    <td>

                                        @if($user->actif)

                                            <span class="badge badge-success">

                                                Actif

                                            </span>

                                        @else

                                            <span class="badge badge-danger">

                                                Inactif

                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="3" class="text-center">

                                        Aucun utilisateur.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
</div>
</body>

</html>