@php
    $sessionUser = session('user');

    $prenomUtilisateur = $sessionUser->prenom ?? '';
    $nomUtilisateur = $sessionUser->nom ?? '';

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

    $candidaturesEnAttente =
        \Illuminate\Support\Facades\DB::table('candidatures')
            ->where('etat_candidature', 'recue')
            ->count();


    $dossiersIncomplets =
        \Illuminate\Support\Facades\DB::table('candidatures')
            ->where('dossier_complet', 0)
            ->count();


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


    $convocationsAVenir =
        \Illuminate\Support\Facades\DB::table('convocations')
            ->whereDate(
                'date_convocation',
                '>=',
                now()->toDateString()
            )
            ->count();


    $nbNotifications =
        $candidaturesEnAttente +
        $dossiersIncomplets +
        $offresExpirentBientot +
        $convocationsAVenir;
@endphp


{{-- =========================================================
     TOPBAR
========================================================= --}}

<header class="ormvasm-topbar">


    {{-- =====================================================
         GAUCHE : LOGO + NOM
    ====================================================== --}}

    <div class="topbar-left">

            <img src="{{ asset('image/ormvaa.png') }}" class="topbar-logo">

            <h5>
                Office Régional de Mise en Valeur Agricole
                du Souss Massa
            </h5>

        </div>



    {{-- =====================================================
         CENTRE : RECHERCHE
    ====================================================== --}}

    <div class="ormvasm-topbar-center">

        <div class="ormvasm-search">

            <i class="bi bi-search"></i>

            <input
                type="text"
                id="topbarSearch"
                placeholder="Rechercher…"
                autocomplete="off"
            >

        </div>

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



{{-- =========================================================
     CSS TOPBAR
========================================================= --}}

<style>


/* =========================================================
   TOPBAR PRINCIPALE
========================================================= */

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


/* =========================================================
   CENTRE
========================================================= */

.ormvasm-topbar-center{

    flex:1;

    display:flex;

    justify-content:center;

    padding:0 35px;

}


.ormvasm-search{

    width:100%;

    max-width:500px;

    height:45px;

    display:flex;

    align-items:center;

    gap:11px;

    padding:0 15px;

    background:#F8FAFC;

    border:1px solid #E5E7EB;

    border-radius:11px;

    transition:.2s ease;

}


.ormvasm-search:focus-within{

    background:#FFFFFF;

    border-color:#15803D;

    box-shadow:0 0 0 3px rgba(21,128,61,.08);

}


.ormvasm-search i{

    color:#64748B;

    font-size:16px;

}


.ormvasm-search input{

    width:100%;

    border:0;

    outline:none;

    background:transparent;

    color:#1F2937;

    font-size:13px;

}


.ormvasm-search input::placeholder{

    color:#94A3B8;

}


/* =========================================================
   DROITE
========================================================= */

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


.ormvasm-notification-panel.active{

    opacity:1;

    visibility:visible;

    transform:translateY(0);

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


.ormvasm-user-menu.active{

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



{{-- =========================================================
     JAVASCRIPT
========================================================= --}}

<script>

document.addEventListener(
    'DOMContentLoaded',
    function(){

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


        /* =====================================================
           NOTIFICATIONS
        ===================================================== */

        if(
            notificationButton &&
            notificationPanel
        ){

            notificationButton.addEventListener(
                'click',
                function(event){

                    event.stopPropagation();

                    notificationPanel
                        .classList
                        .toggle('active');


                    if(userMenuPanel){

                        userMenuPanel
                            .classList
                            .remove('active');

                    }

                }
            );

        }

    });
        /* =====================================================
           MENU UTILISATEUR
        ===================================================== */


</script>
</body>
</html>

