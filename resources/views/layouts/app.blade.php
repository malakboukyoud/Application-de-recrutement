<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>@yield('title','ORMVASM')</title>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">


<!-- Bootstrap Icons -->
<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


<style>

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



  body {
    background:var(--bg);
    color:var(--text);
  }
        .navbar-brand small { display:block; font-size:.7rem; opacity:.8; }
        .badge-etat { font-size:.8rem; }
        table.table-hover tbody tr { cursor: pointer; }

/* Cartes : cohérentes avec la palette (fond blanc, bordure douce, ombre légère, coins arrondis) */
.card{
    background:var(--white);
    border:1px solid var(--border);
    border-radius:var(--radius);
    box-shadow:var(--shadow);
}

/* Boutons : alignés sur la palette au lieu du bleu/vert par défaut de Bootstrap */
.btn-success{
    background-color:var(--green);
    border-color:var(--green);
}
.btn-success:hover{
    background-color:var(--green-dark);
    border-color:var(--green-dark);
}
.btn-outline-primary{
    color:var(--blue);
    border-color:var(--blue);
}
.btn-outline-primary:hover{
    background-color:var(--blue);
    border-color:var(--blue);
}
.btn-outline-danger{
    color:var(--red);
    border-color:var(--red);
}
.btn-outline-danger:hover{
    background-color:var(--red);
    border-color:var(--red);
}

/* Badges d'état : mêmes teintes que le reste de l'app */
.badge.bg-success{ background-color:var(--green) !important; }
.badge.bg-info{ background-color:var(--blue) !important; color:var(--white) !important; }
.badge.bg-warning{ background-color:var(--orange) !important; color:var(--white) !important; }
.badge.bg-danger{ background-color:var(--red) !important; }
.badge.bg-secondary{ background-color:var(--text-light) !important; }


/* Zone générale */

.app-container{

    display:flex;

}


/* Sidebar gauche */

.sidebar{

    width:260px;

    height:100vh;

    position:fixed;

    top:0;

    left:0;

    background:var(--green);

}



/* Contenu droite */

.content{

    margin-left:260px;

    width:calc(100vw - 260px);

    min-height:100vh;

    padding:40px;

    padding-top:95px;

    box-sizing:border-box;

    overflow-x:auto;

}

.main{

    margin-left:260px;

    width:calc(100% - 260px);

    min-height:100vh;

    padding:32px;

}



</style>


</head>


<body>


<div class="app-container">


    @include('layouts.sidebar')


    <div class="content">

        @yield('content')

    </div>


</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')

</body>

</html>
