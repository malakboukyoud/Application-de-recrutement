<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Détails utilisateur | ORMVASM</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">



<style>


:root{

--green:#15803D;
--orange:#F97316;
--blue:#0284C7;
--light:#F5F7F6;
--border:#E5E7EB;
--text:#1F2937;

}



*{

margin:0;
padding:0;
box-sizing:border-box;

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

}



.user-card{

background:white;

border-radius:18px;

box-shadow:0 10px 35px rgba(0,0,0,.08);

overflow:hidden;

}




.card-header-custom{

padding:30px;

border-bottom:1px solid var(--border);

display:flex;

justify-content:space-between;

align-items:center;

flex-wrap:wrap;

gap:15px;

}



.title h2{

font-size:30px;

font-weight:700;

margin:0;

}



.title p{

color:#6B7280;

margin-top:8px;

}




.badge-status{

padding:10px 20px;

border-radius:30px;

font-weight:600;

}



.active{

background:#DCFCE7;

color:#166534;

}


.inactive{

background:#FEE2E2;

color:#991B1B;

}





.card-body-custom{

padding:35px;

}




.section-title{

font-size:20px;

font-weight:700;

margin-bottom:25px;

color:#111827;

}




.info-grid{

display:grid;

grid-template-columns:repeat(2,1fr);

gap:20px;

}



.info-box{

background:#FAFAFA;

border:1px solid #ECECEC;

border-radius:12px;

padding:18px;

}



.info-box label{

display:block;

font-size:13px;

font-weight:600;

color:#6B7280;

margin-bottom:8px;

}



.info-box span{

font-size:16px;

font-weight:600;

}





.buttons{

margin-top:35px;

display:flex;

justify-content:flex-end;

gap:15px;

}



.btn-return{

    background:white;

    color:var(--orange);

    border:2px solid var(--orange);

    padding:12px 30px;

    border-radius:10px;

    text-decoration:none;

    font-weight:600;

    transition:.30s;

}

.btn-return:hover{

   background:var(--orange);

    color:white;

    transform:translateY(-2px);
}



.btn-edit{

background:var(--green);

color:white;

padding:12px 28px;

border-radius:10px;

text-decoration:none;

font-weight:600;

}



.btn-delete{

background:#DC2626;

color:white;

border:none;

padding:12px 25px;

border-radius:10px;

font-weight:600;

}





@media(max-width:768px){


.info-grid{

grid-template-columns:1fr;

}


.buttons{

flex-direction:column;

}


}

</style>


</head>


<body>





<div class="content">


<div class="user-card">



<!-- HEADER -->


<div class="card-header-custom">


<div class="title">


<h2>

<i class="bi bi-person-circle text-success"></i>

Détails utilisateur

</h2>


<p>
Consultez les informations complètes de cet utilisateur.
</p>


</div>



@if($utilisateur->actif == 1)


<span class="badge-status active">

<i class="bi bi-check-circle-fill"></i>

Actif

</span>


@else


<span class="badge-status inactive">

<i class="bi bi-x-circle-fill"></i>

Inactif

</span>


@endif



</div>





<!-- BODY -->


<div class="card-body-custom">



<h4 class="section-title">

<i class="bi bi-person-vcard-fill text-success"></i>

Informations personnelles

</h4>




<div class="info-grid">



<div class="info-box">

<label>Nom</label>

<span>{{ $utilisateur->nom }}</span>

</div>




<div class="info-box">

<label>Prénom</label>

<span>{{ $utilisateur->prenom }}</span>

</div>




<div class="info-box">

<label>Email</label>

<span>{{ $utilisateur->email }}</span>

</div>




<div class="info-box">

<label>Téléphone</label>

<span>{{ $utilisateur->telephone ?? '-' }}</span>

</div>



</div>






<br>





<h4 class="section-title">

<i class="bi bi-shield-lock-fill text-success"></i>

Informations de connexion

</h4>




<div class="info-grid">



<div class="info-box">

<label>Login</label>

<span>{{ $utilisateur->login }}</span>

</div>



<div class="info-box">

<label>Date de création</label>

<span>{{ $utilisateur->created_at }}</span>

</div>



</div>







<br>




<h4 class="section-title">

<i class="bi bi-person-badge-fill text-success"></i>

Profil utilisateur

</h4>




<div class="info-grid">


<div class="info-box">

<label>Profil</label>


<span>

{{ optional($utilisateur->profil)->libelle ?? '-' }}

</span>


</div>



<div class="info-box">

<label>Statut</label>


<span>

{{ $utilisateur->actif == 1 ? 'Actif' : 'Inactif' }}

</span>


</div>



</div>








<!-- BUTTONS -->


<div class="buttons">


<a href="{{ route('utilisateurs.index') }}"
class="btn-return">

<i class="bi bi-arrow-left-circle"></i>

Retour

</a>





<a href="{{ route('utilisateurs.edit',$utilisateur->id_utilisateur) }}"
class="btn-edit">

<i class="bi bi-pencil-square"></i>

Modifier

</a>





<form action="{{ route('utilisateurs.destroy',$utilisateur->id_utilisateur) }}"
method="POST"
onsubmit="return confirm('Voulez-vous supprimer cet utilisateur ?');">


@csrf

@method('DELETE')


<button class="btn-delete">


<i class="bi bi-trash-fill"></i>

Supprimer


</button>


</form>



</div>





</div>


</div>


</div>






<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>