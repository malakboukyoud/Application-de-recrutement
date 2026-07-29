<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Modifier utilisateur | ORMVASM</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">


<style>


:root{

--green:#15803D;
--orange:#F97316;
--light:#F5F7F6;
--border:#E5E7EB;
--text:#1F2937;

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

background:var(--light);

font-family:"Segoe UI",sans-serif;

color:var(--text);

}




/* CONTENT */


.content{

max-width:1100px;

margin:40px auto;

padding:20px;
padding-top:95px;

}



.card{

background:white;

border-radius:18px;

padding:30px;

box-shadow:0 10px 35px rgba(0,0,0,.08);

margin-bottom:25px;

}



.page-title h2{

font-size:30px;

font-weight:700;

}



.page-title p{

color:#6B7280;

margin-bottom:30px;

}



/* CARD HEADER */


.card-header-custom{

background:#F8F9FA;

border-radius:12px;

padding:15px 20px;

margin-bottom:25px;

font-size:17px;

font-weight:700;

color:var(--green);

}





.form-label{

font-weight:600;

color:#374151;

margin-bottom:8px;

}



.form-control,
.form-select{


border:1px solid #D1D5DB;

border-radius:10px;

padding:12px 15px;

}



.form-control:focus,
.form-select:focus{


border-color:var(--green);

box-shadow:0 0 0 .15rem rgba(21,128,61,.2);

}





/* BUTTONS */


.buttons{

display:flex;

justify-content:flex-end;

gap:15px;

margin-top:30px;

}



.btn-save{


background:var(--green);

color:white;

border:none;

padding:12px 28px;

border-radius:10px;

font-weight:600;

}



.btn-save:hover{

background:#10662F;

}



.btn-cancel{


background:white;

color:var(--orange);

border:2px solid var(--orange);

padding:12px 28px;

border-radius:10px;

text-decoration:none;

font-weight:600;

}



.btn-cancel:hover{


background:var(--orange);

color:white;


}





@media(max-width:768px){


.buttons{

flex-direction:column;

}


}

</style>


</head>


<body>

<div class="content">



<div class="page-title">


<h2>

<i class="bi bi-pencil-square text-success"></i>

Modifier utilisateur

</h2>


<p>

Mettez à jour les informations de ce compte utilisateur.

</p>


</div>







<form action="{{ route('utilisateurs.update',$utilisateur->id_utilisateur) }}"
method="POST">


@csrf

@method('PUT')






<!-- INFORMATIONS PERSONNELLES -->


<div class="card">


<div class="card-header-custom">


<i class="bi bi-person-vcard-fill"></i>

Informations personnelles


</div>




<div class="row">



<div class="col-md-6 mb-3">


<label class="form-label">

Nom

</label>


<input type="text"
name="nom"
class="form-control"
value="{{ old('nom',$utilisateur->nom) }}"
required>


</div>





<div class="col-md-6 mb-3">


<label class="form-label">

Prénom

</label>


<input type="text"
name="prenom"
class="form-control"
value="{{ old('prenom',$utilisateur->prenom) }}"
required>


</div>







<div class="col-md-6 mb-3">


<label class="form-label">

Email

</label>


<input type="email"
name="email"
class="form-control"
value="{{ old('email',$utilisateur->email) }}"
required>


</div>







<div class="col-md-6 mb-3">


<label class="form-label">

Téléphone

</label>


<input type="text"
name="telephone"
class="form-control"
value="{{ old('telephone',$utilisateur->telephone) }}">


</div>



</div>



</div>









<!-- CONNEXION -->


<div class="card">


<div class="card-header-custom">


<i class="bi bi-shield-lock-fill"></i>

Informations de connexion


</div>



<div class="row">



<div class="col-md-6 mb-3">


<label class="form-label">

Login

</label>


<input type="text"
name="login"
class="form-control"
value="{{ old('login',$utilisateur->login) }}"
required>


</div>





<div class="col-md-6 mb-3">


<label class="form-label">

Nouveau mot de passe

</label>


<input type="password"
name="mot_de_passe"
class="form-control"
placeholder="Laisser vide pour garder l'ancien">


</div>



</div>



</div>









<!-- PROFIL -->


<div class="card">


<div class="card-header-custom">


<i class="bi bi-person-badge-fill"></i>

Profil et statut


</div>





<div class="row">



<div class="col-md-6 mb-3">


<label class="form-label">

Profil

</label>



<select name="id_profil"
class="form-select">


@foreach($profils as $profil)


<option value="{{ $profil->id_ref }}"

@if($utilisateur->id_profil == $profil->id_ref)

selected

@endif

>

{{ $profil->libelle }}

</option>


@endforeach


</select>



</div>







<div class="col-md-6 mb-3">


<label class="form-label">

Statut

</label>



<select name="actif"
class="form-select">


<option value="1"

@if($utilisateur->actif == 1)

selected

@endif

>

Actif

</option>



<option value="0"

@if($utilisateur->actif == 0)

selected

@endif

>

Inactif

</option>



</select>



</div>



</div>



</div>










<div class="buttons">


<a href="{{ route('utilisateurs.index',$utilisateur->id_utilisateur) }}"
class="btn-cancel">


<i class="bi bi-arrow-left-circle"></i>

Annuler


</a>




<button type="submit"
class="btn-save">


<i class="bi bi-check-circle-fill"></i>

Enregistrer les modifications


</button>



</div>






</form>





</div>







<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>


</html>
