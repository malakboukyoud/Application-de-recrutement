<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>@yield('title','ORMVASM')</title>


<!-- Bootstrap Icons -->
<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


<style>


*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}


body{

    font-family:Arial,sans-serif;

    background:#F6F8FB;

}


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

}

.main{

    margin-left:260px;

    width:calc(100% - 260px);

    min-height:100vh;

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


</body>


</html>