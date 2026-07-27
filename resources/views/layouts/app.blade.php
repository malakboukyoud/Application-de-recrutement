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


*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}


  body { background:#f5f6f8; }
        .navbar-brand small { display:block; font-size:.7rem; opacity:.8; }
        .badge-etat { font-size:.8rem; }
        table.table-hover tbody tr { cursor: pointer; }


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

    background:#15803D;

}



/* Contenu droite */

.content{

    margin-left:260px;

    width:calc(100% - 260px);

    min-height:100vh;
    margin-top:120px;
}

.main{
    
    margin-left:260px;

    width:calc(100% - 260px);

    min-height:100vh;

}



</style>


</head>


<body>
@php
    $profil = session('user')->profil ?? '';
@endphp

<div class="app-container">


    @include('layouts.sidebar')


    <div class="content">

        @yield('content')

    </div>


</div>


</body>


</html>