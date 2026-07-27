<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Document</title>
 <style>
    /* ==============================
        SIDEBAR
============================== */

.sidebar{

    width:260px;

    height:calc(100vh - 75px);

    background:#ffffff;

    border-right:1px solid #E5E7EB;

    position:fixed;

    left:0;

    top:70px;

    bottom:0;

    overflow-y:auto;

}


/* LOGO */

.logo{

    height:90px;

    display:flex;

    align-items:center;

    justify-content:center;

    gap:15px;

    border-bottom:1px solid #E5E7EB;

}


.logo img{

    width:55px;
    height:55px;

    object-fit:contain;

}


.logo h3{

    font-size:20px;

    color:#15803D;

    font-weight:700;

}



/* MENU */

.menu{

    list-style:none;

    padding:25px 15px;

    margin:0;

}



.menu li{

    margin-bottom:8px;

}



.menu li a{

    display:flex;

    align-items:center;

    gap:15px;


    padding:13px 18px;


    text-decoration:none;


    color:#4B5563;


    border-radius:12px;


    font-size:15px;


    font-weight:500;


    transition:.3s;

}



.menu li a i{

    font-size:20px;

}



/* HOVER */

.menu li a:hover{

    background:#EEF7F0;

    color:#15803D;

}



/* ACTIVE */

.menu li.active a{

    background:#15803D;

    color:white;

}



/* DECONNEXION */

.menu li:last-child a{

    color:#DC2626;

}


.menu li:last-child a:hover{

    background:#FEE2E2;

}


/* ==============================
        MAIN CONTENT
============================== */


.main{

    margin-left:260px;

    width:calc(100% - 260px);

}



/* RESPONSIVE */

@media(max-width:768px){


.sidebar{

    width:80px;

}


.logo h3{

    display:none;

}



.menu li a span{

    display:none;

}



.main{

    margin-left:80px;

    width:calc(100% - 80px);

}


}
</style>
</head>
<body>
 <aside class="sidebar">

    

    <ul class="menu">

    <li class="{{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
        <a href="{{ route('dashboard.index') }}">
            <i class="bi bi-grid-fill"></i>
            <span>Dashboard</span>
        </a>
    </li>


    <li class="{{ request()->routeIs('offres.index') ? 'active' : '' }}">
        <a href="{{ route('offres.index') }}">
            <i class="bi bi-briefcase-fill"></i>
            <span>Offres</span>
        </a>
    </li>


    <li class="{{ request()->routeIs('candidats.index') ? 'active' : '' }}">
        <a href="{{ route('candidats.index') }}">
            <i class="bi bi-people-fill"></i>
            <span>Candidats</span>
        </a>
    </li>


    <li class="{{ request()->routeIs('candidatures.index') ? 'active' : '' }}">
        <a href="{{ route('candidatures.index') }}">
            <i class="bi bi-file-earmark-text-fill"></i>
            <span>Candidatures</span>
        </a>
    </li>

    
    <li>
        <a href="#">
            <i class="bi bi-folder-fill"></i>
            <span>Documents</span>
        </a>
    </li>


    <li class="{{ request()->routeIs('convocations.index') ? 'active' : '' }}">
        <a href="{{ route('convocations.index') }}">
            <i class="bi bi-calendar-event-fill"></i>
            <span>Convocations</span>
        </a>
    </li>


    <li>
        <a href="evaluations._form">
            <i class="bi bi-star-fill"></i>
            <span>Évaluation</span>
        </a>
    </li>


    <li>
        <a href="#">
            <i class="bi bi-trophy-fill"></i>
            <span>Résultats</span>
        </a>
    </li>


    <li class="{{ request()->routeIs('utilisateurs.index') ? 'active' : '' }}">
        <a href="{{ route('utilisateurs.index') }}">
            <i class="bi bi-person-fill"></i>
            <span>Utilisateurs</span>
        </a>
    </li>

    <li class="{{ request()->routeIs('historique.index') ? 'active' : '' }}">
        <a href="{{ route('historique.index') }}">
            <i class="bi bi-clock-history"></i>
            <span>Historique</span>
        </a>
    </li>


    <li class="{{ request()->routeIs('parametres.index') ? 'active' : '' }}">
    <a href="{{ route('parametres.index') }}">
        <i class="bi bi-gear-fill"></i>
        <span>Paramètres</span>
    </a>
</li>
<li>
    <a href="#" 
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="bi bi-box-arrow-right"></i>
        <span>Déconnexion</span>
    </a>

    <form id="logout-form" 
          method="POST" 
          action="{{ route('logout') }}" 
          style="display:none;">
        @csrf
    </form>
</li>
</ul>


</aside>
</body>
</html>