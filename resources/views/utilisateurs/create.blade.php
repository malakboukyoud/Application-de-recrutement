<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Ajouter un utilisateur | ORMVASM</title>


<!-- Bootstrap -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


<!-- Bootstrap Icons -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">



<style>


:root{

    --orange:#F97316;
    --green:#15803D;
    --blue:#0284C7;
    --light:#F5F7F6;
    --white:#FFFFFF;
    --border:#E5E7EB;
    --text:#1F2937;

}



/* ==========================
        RESET
========================== */


*{

    margin:0;
    padding:0;
    box-sizing:border-box;

}



body{

    background:var(--light);

    font-family:"Segoe UI",Tahoma,Geneva,Verdana,sans-serif;

    color:var(--text);

}



.main{

    min-height:100vh;

}








/* ==========================
        CONTENT
========================== */


.content{


    max-width:1200px;

    margin:auto;

    padding:40px;


}




.page-title{


    margin-bottom:30px;


}



.page-title h2{


    font-size:30px;

    font-weight:700;

    color:#222;


}



.page-title p{


    color:#6B7280;

    margin-top:6px;


}





/* ==========================
        CARDS
========================== */


.card{


    background:white;

    border:none;

    border-radius:18px;

    padding:30px;

    box-shadow:0 12px 30px rgba(0,0,0,.08);

    margin-bottom:25px;


}




.card-header{


    background:#F8F9FA;

    color:var(--green);

    font-weight:700;

    font-size:17px;

    border:none;

    border-radius:12px;

    padding:15px 20px;

    margin-bottom:20px;


}



.card-body{


    padding:10px;


}






/* ==========================
        FORMULAIRE
========================== */


.form-label{


    font-weight:600;

    color:#374151;

    margin-bottom:8px;


}



.form-control,
.form-select{


    border:1px solid #D1D5DB;

    border-radius:10px !important;

    padding:12px 15px;

    transition:.3s;

    box-shadow:none;


}



.form-control:hover,
.form-select:hover{


    border-color:#B5B5B5;


}



.form-control:focus,
.form-select:focus{


    border-color:var(--green);

    box-shadow:0 0 0 .18rem rgba(21,128,61,.18);


}



.input-group .btn{


    border:1px solid #D1D5DB;

    background:white;


}



.input-group .btn:hover{


    background:#F5F5F5;


}





/* ==========================
        ALERT
========================== */


.alert{


    border:none;

    border-radius:10px;

    box-shadow:0 5px 15px rgba(0,0,0,.08);


}







/* ==========================
        BUTTONS
========================== */


.btn-save{


    background:var(--green) !important;

    color:white !important;

    border:none;

    padding:12px 28px;

    border-radius:10px;

    font-weight:600;

    transition:.3s;


}



.btn-save:hover{


    background:#10662F !important;

    transform:translateY(-2px);


}



.btn-cancel{


    background:white;

    color:var(--orange);

    border:2px solid var(--orange);

    padding:12px 30px;

    border-radius:10px;

    font-weight:600;

    text-decoration:none;

    transition:.3s;


}



.btn-cancel:hover{


    background:var(--orange);

    color:white;


}






/* ==========================
        RESPONSIVE
========================== */


@media(max-width:992px){


.content{

padding:25px;

}


.topbar-left h5{

display:none;

}


}



@media(max-width:768px){


.topbar{

height:auto;

flex-direction:column;

padding:20px;

gap:15px;


}



.content{

padding:20px;


}



.card{

padding:20px;


}



.d-flex{

flex-direction:column;


}



.btn-save,
.btn-cancel{


width:100%;

text-align:center;


}



}



</style>


</head>


<body>


<div class="main">


<!-- ================= CONTENT ================= -->


<div class="content">



<div class="page-title">


<h2>

<i class="bi bi-person-plus-fill text-success"></i>

Ajouter un utilisateur

</h2>



<p>

Créez un nouveau compte utilisateur et attribuez-lui un profil.

</p>


</div>




@if ($errors->any())


<div class="alert alert-danger">


<ul class="mb-0">


@foreach ($errors->all() as $error)


<li>{{ $error }}</li>


@endforeach


</ul>


</div>


@endif



<form action="{{ route('utilisateurs.store') }}" method="POST">


@csrf

<!-- ================= CARD 1 ================= -->

<div class="card">


<div class="card-header">

<i class="bi bi-person-vcard-fill"></i>

Informations personnelles

</div>



<div class="card-body">


<div class="row">


<!-- Nom -->

<div class="col-md-6 mb-3">


<label class="form-label">

Nom <span class="text-danger">*</span>

</label>



<input
type="text"
name="nom"
class="form-control @error('nom') is-invalid @enderror"
value="{{ old('nom') }}"
placeholder="Ex : El Amrani"
required>


@error('nom')

<div class="invalid-feedback">

{{ $message }}

</div>

@enderror


</div>





<!-- Prénom -->


<div class="col-md-6 mb-3">


<label class="form-label">

Prénom <span class="text-danger">*</span>

</label>



<input
type="text"
name="prenom"
class="form-control @error('prenom') is-invalid @enderror"
value="{{ old('prenom') }}"
placeholder="Ex : Malak"
required>



@error('prenom')

<div class="invalid-feedback">

{{ $message }}

</div>

@enderror


</div>




<!-- Email -->


<div class="col-md-6 mb-3">


<label class="form-label">

Email <span class="text-danger">*</span>

</label>



<input
type="email"
name="email"
class="form-control @error('email') is-invalid @enderror"
value="{{ old('email') }}"
placeholder="exemple@email.com"
required>



@error('email')

<div class="invalid-feedback">

{{ $message }}

</div>

@enderror


</div>





<!-- Téléphone -->


<div class="col-md-6 mb-3">


<label class="form-label">

Téléphone

</label>



<input
type="text"
name="telephone"
class="form-control"
value="{{ old('telephone') }}"
placeholder="06XXXXXXXX">


</div>



</div>


</div>


</div>






<!-- ================= CARD 2 ================= -->


<div class="card">


<div class="card-header">


<i class="bi bi-shield-lock-fill"></i>

Informations de connexion


</div>




<div class="card-body">


<div class="row">



<!-- Login -->


<div class="col-md-6 mb-3">


<label class="form-label">

Login <span class="text-danger">*</span>

</label>



<input
type="text"
name="login"
class="form-control @error('login') is-invalid @enderror"
value="{{ old('login') }}"
placeholder="Nom utilisateur"
required>


@error('login')

<div class="invalid-feedback">

{{ $message }}

</div>

@enderror



</div>




<!-- Mot de passe -->


<div class="col-md-6 mb-3">


<label class="form-label">

Mot de passe <span class="text-danger">*</span>

</label>



<div class="input-group">


<input
type="password"
id="password"
name="mot_de_passe"
class="form-control"
required>



<button
type="button"
class="btn"
onclick="togglePassword('password',this)">


<i class="bi bi-eye"></i>


</button>



</div>


</div>





<!-- Confirmation -->


<div class="col-md-6 mb-3">


<label class="form-label">

Confirmation du mot de passe

<span class="text-danger">*</span>

</label>



<div class="input-group">


<input
type="password"
id="password_confirmation"
name="mot_de_passe_confirmation"
class="form-control"
required>



<button
type="button"
class="btn"
onclick="togglePassword('password_confirmation',this)">


<i class="bi bi-eye"></i>


</button>



</div>


</div>




</div>


</div>


</div>






<!-- ================= CARD 3 ================= -->


<div class="card">


<div class="card-header">


<i class="bi bi-person-badge-fill"></i>


Profil et statut


</div>




<div class="card-body">


<div class="row">



<!-- Profil -->


<div class="col-md-6 mb-3">


<label class="form-label">

Profil <span class="text-danger">*</span>

</label>



<select name="id_profil" class="form-select" required>

    <option value="">
        -- Choisir un profil --
    </option>


    @foreach($profils as $profil)

        <option value="{{ $profil->id_ref }}">

            {{ $profil->libelle }}

        </option>

    @endforeach


</select>
</div>







<!-- Statut -->


<div class="col-md-6 mb-3">


<label class="form-label">

Statut

</label>



<select
name="actif"
class="form-select">


<option value="1">

Actif

</option>



<option value="0">

Inactif

</option>



</select>



</div>




</div>


</div>


</div>







<!-- ================= ACTIONS ================= -->


<div class="d-flex justify-content-end gap-3 mb-4">


<a href="{{ route('utilisateurs.index') }}"
class="btn-cancel">


<i class="bi bi-arrow-left-circle"></i>


Annuler


</a>




<button type="submit"
class="btn-save">


<i class="bi bi-check-circle-fill"></i>


Enregistrer l'utilisateur


</button>



</div>




</form>


</div>


</div>







<!-- ================= JAVASCRIPT ================= -->


<script>


function togglePassword(id,button)

{


let input=document.getElementById(id);


let icon=button.querySelector('i');



if(input.type==="password")

{


input.type="text";


icon.classList.remove("bi-eye");

icon.classList.add("bi-eye-slash");


}

else

{


input.type="password";


icon.classList.remove("bi-eye-slash");

icon.classList.add("bi-eye");


}



}



</script>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>



</body>

</html>