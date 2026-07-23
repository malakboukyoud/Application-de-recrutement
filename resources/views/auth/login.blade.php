<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | ORMVASM</title>

    
    <!-- Font Awesome -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
     /* =========================
   RESET
========================= */

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:"Segoe UI",Tahoma,Geneva,Verdana,sans-serif;
    background:#eef2ee;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
}

/* =========================
   CONTENEUR
========================= */

.container{
    width:100%;
    display:flex;
    justify-content:center;
}

/* =========================
   CARTE
========================= */

.login-card{
    position:relative;
    width:850px;
    height:550px;
    background:#fff;
    margin:20px;
    border-radius:30px;
    overflow:hidden;
    display:flex;
    box-shadow:0 20px 50px rgba(0,0,0,.15);
}


/* =========================
   PARTIE GAUCHE
========================= */

.left-side{
    width:50%;
    padding:35px;
    display:flex;
    flex-direction:column;
    justify-content:center;
}


/* =========================
   LOGO
========================= */

.logo{
    text-align:center;
    margin-bottom:20px;
}

.logo img{
    width:140px;
    height:auto;
}

.logo h1{
    margin-top:8px;
    font-size:28px;
    color:#1f5c3f;
}

.logo p{
    color:#666;
    margin-top:5px;
    font-size:14px;
}


/* =========================
   TITRE
========================= */

.title{
    margin-bottom:20px;
}

.title h2{
    font-size:30px;
    color:#222;
}

.title span{
    color:#777;
    font-size:14px;
}


/* =========================
   FORMULAIRE
========================= */

.input-box{
    margin-bottom:15px;
}

.input-box label{
    display:block;
    margin-bottom:6px;
    font-weight:600;
    font-size:14px;
}

.input{
    display:flex;
    align-items:center;
    background:#f7f7f7;
    border-radius:12px;
    border:1px solid #ddd;
    padding:0 15px;
    transition:.3s;
}

.input:focus-within{
    border-color:#1f5c3f;
    box-shadow:0 0 10px rgba(31,92,63,.2);
}

.input i{
    color:#777;
    margin-right:12px;
}

.input input{
    width:100%;
    border:none;
    background:transparent;
    padding:12px 0;
    outline:none;
    font-size:14px;
}


/* =========================
   BOUTON
========================= */

.btn-login{
    width:100%;
    margin-top:10px;
    padding:12px;
    border:none;
    border-radius:12px;
    background:#1f5c3f;
    color:white;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
    transition:.3s;
}

.btn-login:hover{
    background:linear-gradient(
        135deg,
        #1f5c3f,
        #4d8a62,
        #6ca36d
    );

    transform:translateY(-2px);
}

.btn-login i{
    margin-right:8px;
}


/* =========================
   PARTIE DROITE
========================= */

.right-side{
    width:50%;
    position:relative;

    background-image:url("../image/welcome1.png");
    background-size:cover;
    background-position:center;
    background-repeat:no-repeat;

    display:flex;
    justify-content:center;
    align-items:center;

    border-top-left-radius:120px;
    border-bottom-left-radius:120px;

    overflow:hidden;
}


.right-side::before{
    content:"";
    position:absolute;
    inset:0;
    background:rgba(255,255,255,0.15);
}


/* =========================
   WELCOME
========================= */

.welcome{
    text-align:center;
    color:white;
    padding:30px;
}

.welcome h2{
    font-size:38px;
    margin-bottom:15px;
}

.welcome p{
    font-size:20px;
    margin-bottom:10px;
}

.welcome span{
    font-size:15px;
    line-height:1.6;
    opacity:.9;
}


/* =========================
   RESPONSIVE
========================= */

@media(max-width:900px){

    .login-card{
        flex-direction:column;
        width:90%;
        height:auto;
    }

    .left-side,
    .right-side{
        width:100%;
    }

    .right-side{
        min-height:300px;
        border-radius:0;
    }

}
</style>
</head>

<body>

<div class="container">
    @if(session('error'))

<div class="alert alert-danger">

    {{ session('error') }}

</div>

@endif

@if(session('success'))

<div class="alert alert-success">

    {{ session('success') }}

</div>

@endif
    <!-- Carte -->
    <div class="login-card">
         
        <!-- Partie gauche -->
        <div class="left-side">

            <div class="logo">

                <img src="{{ asset('image/ormva.png') }}" alt="Logo">

                <h1>ORMVASM</h1>

                <p>Service des Ressources Humaines</p>

            </div>

            <div class="title">

                <h2>Connexion</h2>

                <span>
                    Accès réservé aux agents autorisés.
                </span>

            </div>

            <form action="{{ route('login') }}" method="POST">

                @csrf

                <div class="input-box">

                    <label>Identifiant</label>

                    <div class="input">

                        <i class="fa-solid fa-user"></i>

                        <input
                        type="text"
                        name="login"
                        placeholder="Votre identifiant"
                        required>

                    </div>

                </div>

                <div class="input-box">

                    <label>Mot de passe</label>

                    <div class="input">

                        <i class="fa-solid fa-lock"></i>

                        <input
                        type="password"
                        name="password"
                        placeholder="Votre mot de passe"
                        required>

                    </div>

                </div>

                <button class="btn-login">

                    <i class="fa-solid fa-right-to-bracket"></i>

                    Se connecter

                </button>

            </form>

        </div>

        <!-- Partie droite -->

        <div class="right-side">
  
            <div class="welcome">

                <h2>Bienvenue</h2>

                <p>
                    Plateforme de Gestion des Candidatures de Recrutement
                </p>

                <span>
                    Office Régional de Mise en Valeur Agricole
                    du Souss Massa
                </span>

            </div>

        </div>

    </div>

</div>

</body>
</html>