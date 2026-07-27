<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gestion des utilisateurs | ORMVASM</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/utilisateurs.css') }}">
    <style>
     /*==================================================
                VARIABLES
==================================================*/

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
    --success-text:#166534;

    --danger:#FEE2E2;
    --danger-text:#991B1B;

    --shadow:0 8px 25px rgba(0,0,0,.06);

}


/*==================================================
                    RESET
==================================================*/

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

    max-width:100%;
    display:block;

}


/*==================================================
                    PAGE
==================================================*/

.page{

    max-width:1450px;

    margin:0 auto;

    padding:30px;

    padding-top:110px; /* espace sous la topbar */

    margin-left:260px; /* espace pour sidebar */

}

/*==================================================
                    TOPBAR
==================================================*/

.topbar{

    position:fixed;

    top:0;
    left:0;
    right:0;

    height:75px;

    background:#ffffff;

    display:flex;

    justify-content:space-between;

    align-items:center;

    padding:0 30px;

    border-bottom:1px solid #E5E7EB;

    box-shadow:0 2px 10px rgba(0,0,0,.05);

    z-index:1100;

}

/*==================================================
                    LEFT
==================================================*/

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

/*==================================================
                    CENTER
==================================================*/

.topbar-center{

    flex:1;

    display:flex;

    justify-content:center;

}

.search{

    width:400px;

    position:relative;

}

.search i{

    position:absolute;

    left:15px;

    top:50%;

    transform:translateY(-50%);

    color:#9CA3AF;

    font-size:15px;

}

.search input{

    width:100%;

    height:44px;

    border:1px solid #D1D5DB;

    border-radius:30px;

    padding-left:45px;

    padding-right:20px;

    outline:none;

    transition:.3s;

    font-size:14px;

}

.search input:focus{

    border-color:#15803D;

    box-shadow:0 0 0 3px rgba(21,128,61,.15);

}

/*==================================================
                    RIGHT
==================================================*/

.user{

    display:flex;

    align-items:center;

    gap:20px;

}

/*==================================================
                NOTIFICATION
==================================================*/

.notification{

    position:relative;

    cursor:pointer;

}

.notification i{

    font-size:22px;

    color:#4B5563;

    transition:.3s;

}

.notification:hover i{

    color:#15803D;

}

.notification-badge{

    position:absolute;

    top:-6px;

    right:-8px;

    min-width:18px;

    height:18px;

    padding:0 5px;

    background:#EF4444;

    color:#fff;

    border-radius:50px;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:11px;

    font-weight:600;

}

/*==================================================
                USER INFO
==================================================*/

.user-info{

    display:flex;

    flex-direction:column;

    align-items:flex-end;

    line-height:1.3;

}

.user-info small{

    color:#6B7280;

    font-size:12px;

}

.user-info strong{

    font-size:14px;

    color:#111827;

    font-weight:600;

}

/*==================================================
                    AVATAR
==================================================*/

.avatar{

    width:45px;

    height:45px;

    border-radius:50%;

    background:#2563EB;

    color:#fff;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:15px;

    font-weight:bold;

    cursor:pointer;

    transition:.3s;

}

.avatar:hover{

    transform:scale(1.05);

    box-shadow:0 5px 15px rgba(37,99,235,.25);

}

/*==================================================
                RESPONSIVE
==================================================*/

@media(max-width:992px){

    .topbar{

        padding:0 15px;

    }

    .topbar-left h5{

        display:none;

    }

    .search{

        width:250px;

    }

}

@media(max-width:768px){

    .search{

        display:none;

    }

    .user-info{

        display:none;

    }

}
/*==================================================
                    RECHERCHE
==================================================*/

.search{

    position:relative;
    width:330px;

}

.search i{

    position:absolute;

    left:15px;
    top:50%;

    transform:translateY(-50%);

    color:#9CA3AF;

}

.search input{

    width:100%;
    height:42px;

    border:1px solid var(--border);
    border-radius:25px;

    padding-left:42px;
    padding-right:15px;

    outline:none;

    transition:.3s;

}

.search input:focus{

    border-color:var(--green);

    box-shadow:0 0 0 3px rgba(21,128,61,.12);

}

.topbar-center select{

    width:170px;
    height:42px;

    border-radius:25px;

    border:1px solid var(--border);

    font-size:14px;
    
}
.topbar-center{

    display:flex;

    align-items:center;

    gap:15px;

}



/*==================================================
                    UTILISATEUR
==================================================*/

.user{

    display:flex;
    align-items:center;
    gap:18px;

}

.user i{

    font-size:20px;
    color:#4B5563;

}

.avatar{

    width:42px;
    height:42px;

    border-radius:50%;

    background:var(--blue);

    display:flex;
    justify-content:center;
    align-items:center;

    color:#fff;

    font-weight:600;

}


/*==================================================
                    CONTENU
==================================================*/

.content{

    padding:35px;
    max-width:1300px;
    margin:auto;

}

/*==================================================
                    TITRE
==================================================*/

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

    margin-bottom:5px;

}

.page-title p{

    color:var(--text-light);

}


/*==================================================
                    BOUTON
==================================================*/

.btn-add{

    background:var(--orange);
    color:white;

    padding:12px 22px;

    border-radius:10px;

    font-weight:600;

    transition:.3s;

}

.btn-add:hover{

    background:#DF650E;
    color:white;

    transform:translateY(-2px);

}
/*==================================================
                CARTES STATISTIQUES
==================================================*/

.cards{

    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
    margin-bottom:30px;

}

.card-item{

    background:var(--white);

    border:1px solid var(--border);

    border-radius:15px;

    padding:22px;

    display:flex;
    align-items:center;
    gap:18px;

    box-shadow:var(--shadow);

    transition:.3s;

}

.card-item:hover{

    transform:translateY(-3px);

}

.icon{

    width:60px;
    height:60px;

    border-radius:15px;

    display:flex;
    justify-content:center;
    align-items:center;

    font-size:28px;

}

.icon.blue{

    background:#E0F2FE;
    color:#0284C7;

}

.icon.green{

    background:#DCFCE7;
    color:#16A34A;

}

.icon.orange{

    background:#FFEDD5;
    color:#EA580C;

}

.icon.purple{

    background:#F3E8FF;
    color:#9333EA;

}

.card-item h5{

    margin:0;
    font-size:15px;
    color:#6B7280;
    font-weight:500;

}

.card-item h2{

    margin-top:6px;
    margin-bottom:0;

    font-size:30px;
    font-weight:700;

}


/*==================================================
                    TABLE
==================================================*/

.table-card{

    background:var(--white);

    border:1px solid var(--border);

    border-radius:15px;

    box-shadow:var(--shadow);

    overflow:hidden;

}

.table-responsive{

    overflow-x:hidden;

}

.table{

    margin:0;

}

.table thead{

    background:#F8FAFC;

}

.table thead th{

    border-bottom:1px solid var(--border);

    padding:16px;

    font-size:14px;

    color:#374151;

    font-weight:600;

    white-space:nowrap;

}

.table tbody td{

    padding:16px;

    vertical-align:middle;

    border-bottom:1px solid #F1F5F9;

}

.table tbody tr{

    transition:.25s;

}

.table tbody tr:hover{

    background:#FAFAFA;

}


/*==================================================
                    BADGES
==================================================*/

.badge{

    padding:7px 14px;

    border-radius:20px;

    font-size:13px;

    font-weight:600;

}

.badge-admin{

    background:#DBEAFE;
    color:#1D4ED8;

}

.badge-rh{

    background:#DCFCE7;
    color:#15803D;

}

.badge-commission{

    background:#F3E8FF;
    color:#7E22CE;

}

.badge-consult{

    background:#F3F4F6;
    color:#4B5563;

}

.badge-active{

    background:#DCFCE7;
    color:#166534;

}

.badge-inactive{

    background:#FEE2E2;
    color:#991B1B;

}
.badge-resp{
    background:#FFEDD5;
    color:#C2410C;
}

/*==================================================
                    ACTIONS
==================================================*/

.actions{

    display:flex;
    align-items:center;
    gap:10px;

}

.btn-action{

    width:38px;
    height:38px;

    border:none;

    border-radius:8px;

    background:#F8FAFC;

    display:flex;
    justify-content:center;
    align-items:center;

    transition:.25s;

    cursor:pointer;

}

.btn-view{

    color:#16A34A;

}

.btn-edit{

    color:#0284C7;

}

.btn-delete{

    color:#DC2626;

}

.btn-action:hover{

    transform:scale(1.08);

    background:#EEF2F7;

}


/*==================================================
                    PAGINATION
==================================================*/

.pagination{

    justify-content:center;

    margin:25px 0;

}

.pagination .page-link{

    color:#374151;

    border-radius:8px;

    margin:0 3px;

    border:1px solid var(--border);

}

.pagination .active .page-link{

    background:var(--orange);

    border-color:var(--orange);

    color:white;

}
/*==================================================
                ALERTES
==================================================*/

.alert{

    border:none;
    border-radius:12px;
    padding:14px 18px;
    margin-bottom:20px;
    font-weight:500;

}

.alert-success{

    background:#ECFDF5;
    color:#166534;

}

.alert-danger{

    background:#FEF2F2;
    color:#991B1B;

}

.alert-warning{

    background:#FFF7ED;
    color:#9A3412;

}


/*==================================================
                SCROLLBAR
==================================================*/

::-webkit-scrollbar{

    width:8px;
    height:8px;

}

::-webkit-scrollbar-track{

    background:#F3F4F6;

}

::-webkit-scrollbar-thumb{

    background:#CBD5E1;
    border-radius:20px;

}

::-webkit-scrollbar-thumb:hover{

    background:#94A3B8;

}


/*==================================================
                TABLE HOVER
==================================================*/

.table tbody tr{

    transition:.25s ease;

}

.table tbody tr:hover{

    background:#F8FAFC;
    transform:scale(1.002);

}


/*==================================================
                INPUTS
==================================================*/

input,
select{

    transition:.25s;

}

input:focus,
select:focus{

    border-color:var(--blue)!important;

    box-shadow:0 0 0 .18rem rgba(2,132,199,.15)!important;

}


/*==================================================
                BOUTONS
==================================================*/

button{

    transition:.25s;

}

button:hover{

    opacity:.95;

}


/*==================================================
                ICÔNES
==================================================*/

.bi{

    vertical-align:middle;

}


/*==================================================
                RESPONSIVE
==================================================*/

@media(max-width:1200px){

    .cards{

        grid-template-columns:repeat(2,1fr);

    }

    .topbar-center{

        flex-wrap:wrap;

    }

}

@media(max-width:992px){

    .topbar{

        height:auto;
        padding:15px;
        flex-direction:column;
        align-items:flex-start;
        gap:15px;

    }

    .topbar-left{

        width:100%;

    }

    .topbar-center{

        width:100%;
        display:flex;
        flex-direction:column;
        gap:12px;

    }

    .search{

        width:100%;

    }

    .topbar-center select{

        width:100%;

    }

    .user{

        align-self:flex-end;

    }

}

@media(max-width:768px){

    .content{

        padding:20px;

    }

    .page-title{

        flex-direction:column;
        align-items:flex-start;
        gap:15px;

    }

    .page-title h2{

        font-size:28px;

    }

    .btn-add{

        width:100%;
        text-align:center;

    }

    .cards{

        grid-template-columns:1fr;

    }

    .table th,
    .table td{

        padding:12px;

        font-size:14px;

    }

}

@media(max-width:576px){

    .topbar-logo{

        width:90px;

    }

    .topbar-left h5{

        display:none;

    }

    .avatar{

        width:38px;
        height:38px;

        font-size:14px;

    }

    .icon{

        width:50px;
        height:50px;

        font-size:22px;

    }

    .card-item h2{

        font-size:24px;

    }

    .card-item{

        padding:18px;

    }

}


/*==================================================
                ANIMATIONS
==================================================*/

.card-item,
.table-card{

    animation:fadeIn .5s ease;

}

@keyframes fadeIn{

    from{

        opacity:0;
        transform:translateY(10px);

    }

    to{

        opacity:1;
        transform:translateY(0);

    }

}
    </style>
</head>

<body>
    @include('layouts.sidebar')
    

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
                    id="searchUser"
                    placeholder="Rechercher un utilisateur...">

            </div>

            <select id="profilFilter" class="form-select">

                <option value="">Tous les profils</option>
                <option value="Administrateur">Administrateur</option>
                <option value="RH">RH</option>
                <option value="Commission">Commission</option>
                <option value="Consultation">Consultation</option>
                <option value="Responsable de service">Responsable dee service</option>

            </select>

            <select id="statutFilter" class="form-select">

                <option value="">Tous les statuts</option>
                <option value="Actif">Actif</option>
                <option value="Inactif">Inactif</option>

            </select>

        </div>

        <div class="user">

        <div class="notification">

            <i class="bi bi-bell fs-5"></i>

            @if($nbNotifications > 0)
                <span class="notification-badge">
                    {{ $nbNotifications }}
                </span>
            @endif

        </div>

        <div class="user-info">

            <small>{{ session('user')->profil ?? 'Utilisateur' }}</small>

            <strong>
                {{ session('user')->prenom ?? '' }}
                {{ session('user')->nom ?? '' }}
            </strong>

        </div>

        <div class="avatar">

            {{ strtoupper(substr(session('user')->prenom ?? 'U',0,1)) }}
            {{ strtoupper(substr(session('user')->nom ?? '',0,1)) }}

        </div>

    </div>

    </div>



<div class="page">
    
    

    <!-- ===========================
            TITRE
    ============================ -->

    <div class="page-title">

        <div>

            <h2>

                Gestion des utilisateurs

            </h2>

            <p>

                Gérez les comptes utilisateurs et leurs droits d'accès.

            </p>

        </div>

        <a href="{{ route('utilisateurs.create') }}" class="btn-add">

            <i class="bi bi-plus-circle"></i>

            Ajouter un utilisateur

        </a>

    </div>



    <!-- ===========================
            CARTES
    ============================ -->

    <div class="cards">

        <div class="card-item">

            <div class="icon blue">

                <i class="bi bi-people-fill"></i>

            </div>

            <div>

                <h5>Total utilisateurs</h5>

                <h2>

                    {{ $utilisateurs->total() }}

                </h2>

            </div>

        </div>



        <div class="card-item">

            <div class="icon green">

                <i class="bi bi-person-check-fill"></i>

            </div>

            <div>

                <h5>Actifs</h5>

                <h2>

                    {{ $utilisateurs->where('actif',1)->count() }}

                </h2>

            </div>

        </div>



        <div class="card-item">

            <div class="icon orange">

                <i class="bi bi-person-x-fill"></i>

            </div>

            <div>

                <h5>Inactifs</h5>

                <h2>

                    {{ $utilisateurs->where('actif',0)->count() }}

                </h2>

            </div>

        </div>



        <div class="card-item">

            <div class="icon shield">

                <i class="bi bi-shield-lock-fill"></i>

            </div>

            <div>

                <h5>Administrateurs</h5>

                <h2>

                    {{ $utilisateurs->where('id_profil',1)->count() }}

                </h2>

            </div>

        </div>

    </div>



    <!-- ===========================
            TABLEAU
    ============================ -->

    <div class="table-card">

        <div class="table-responsive">

            <table class="table align-middle" id="usersTable">

                <thead>

                    <tr>

                        <th>Nom</th>

                        <th>Prénom</th>

                        <th>Login</th>

                        <th>Email</th>

                        <th>Profil</th>

                        <th>Statut</th>

                        <th width="170">Actions</th>

                    </tr>

                </thead>

                <tbody>
                 @forelse($utilisateurs as $user)

<tr>

    <td>{{ $user->nom }}</td>

    <td>{{ $user->prenom }}</td>

    <td>{{ $user->login }}</td>

    <td>{{ $user->email }}</td>

    <td>

        @php

            $profil = "";

            switch($user->id_profil){

                case 1:
                    $profil="Administrateur";
                    $class="badge-admin";
                    break;

                case 2:
                    $profil="RH";
                    $class="badge-rh";
                    break;

                case 3:
                    $profil="Commission";
                    $class="badge-commission";
                    break;

                case 4:
                     
                    $profil="Consultation";
                    $class="badge-consult";
                    break;
                
                 default:
                   
                    $profil="Responsable de service";
                    $class="badge-resp";
                    break;
            }

        @endphp

        <span class="badge {{ $class }}">
            {{ $profil }}
        </span>

    </td>

    <td data-status="{{ $user->actif ? 'actif' : 'inactif' }}">

    @if($user->actif)

        <span class="badge badge-active">
            <i class="bi bi-circle-fill"></i>
            Actif
        </span>

    @else

        <span class="badge badge-inactive">
            <i class="bi bi-circle-fill"></i>
            Inactif
        </span>

    @endif

</td>
    <td>

        <div class="actions">

            <a
                href="{{ route('utilisateurs.show',$user->id_utilisateur) }}"
                class="btn-action btn-view">

                <i class="bi bi-eye-fill"></i>

            </a>

            <a
                href="{{ route('utilisateurs.edit',$user->id_utilisateur) }}"
                class="btn-action btn-edit">

                <i class="bi bi-pencil-square"></i>

            </a>

            <form
                action="{{ route('utilisateurs.destroy',$user->id_utilisateur) }}"
                method="POST"
                style="display:inline;">

                @csrf

                @method('DELETE')

                <button
                    class="btn-action btn-delete"
                    type="submit"
                    onclick="return confirm('Supprimer cet utilisateur ?')">

                    <i class="bi bi-trash-fill"></i>

                </button>

            </form>

        </div>

    </td>

</tr>

@empty

<tr>

    <td colspan="7" class="text-center py-5">

        <i class="bi bi-people fs-1 text-secondary"></i>

        <br><br>

        Aucun utilisateur trouvé.

    </td>

</tr>

@endforelse

</tbody>

</table>

</div>

<div class="mt-4">

    {{ $utilisateurs->links() }}

</div>

</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

const searchInput = document.getElementById("searchUser");
const profilFilter = document.getElementById("profilFilter");
const statutFilter = document.getElementById("statutFilter");
function filtrerTable() {

    const recherche = searchInput.value.toLowerCase().trim();
    const profil = profilFilter.value.toLowerCase();
    const statut = statutFilter.value.toLowerCase();

    const lignes = document.querySelectorAll("#usersTable tbody tr");

    lignes.forEach(function(ligne){

        if(ligne.cells.length < 7){
            return;
        }

        let afficher = true;

        const texte = ligne.innerText.toLowerCase();
        const profilCell = ligne.cells[4].innerText.toLowerCase().trim();
        const statutCell = ligne.cells[5].dataset.status;

        if(recherche !== "" && !texte.includes(recherche)){
            afficher = false;
        }

        if(profil !== "" && !profilCell.includes(profil)){
            afficher = false;
        }

        if(statut !== "" && statutCell !== statut){
            afficher = false;
        }

        ligne.style.display = afficher ? "" : "none";

    });

}
searchInput.addEventListener("keyup", filtrerTable);

profilFilter.addEventListener("change", filtrerTable);

statutFilter.addEventListener("change", filtrerTable);

</script>

</body>
</html>