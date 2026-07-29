<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Nouvelle convocation | ORMVASM</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

:root{

    --green:#15803D;
    --green-dark:#0f6b31;
    --orange:#F97316;
    --blue:#0284C7;

    --bg:#F5F7F6;
    --white:#FFFFFF;

    --text:#1F2937;
    --text-light:#6B7280;

    --border:#E5E7EB;

    --shadow:0 15px 35px rgba(0,0,0,.08);

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

    font-family:'Poppins',sans-serif;
    background:var(--bg);
    color:var(--text);

}

.main{

    width:100%;
    display:flex;
    justify-content:center;
    padding:45px 20px;

}

.content{

    max-width:1200px;

    margin:auto;

    padding:40px;
    padding-top:95px;

}

.page-title{

    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    margin-bottom:35px;
    flex-wrap:wrap;
    gap:20px;

}

.page-title h2{

    font-size:30px;
    font-weight:700;
    color:#16213E;
    margin-bottom:8px;

}

.page-title p{

    font-size:18px;
    color:var(--text-light);

}

.card{

    background:#fff;

    border:none;

    border-radius:18px;

    padding:35px;

    box-shadow:0 12px 30px rgba(0,0,0,.08);

}

.form-label{

    font-weight:600;
    color:#334155;
    margin-bottom:10px;
    font-size:15px;

}

.form-control,
.form-select{

    height:56px;
    border-radius:14px;
    border:1px solid #D6DBE4;
    padding:0 18px;
    font-size:15px;
    transition:.25s;

}

textarea.form-control{

    height:170px;
    resize:vertical;
    padding-top:15px;

}

.form-control:focus,
.form-select:focus{

    border-color:var(--green);
    box-shadow:0 0 0 4px rgba(21,128,61,.12);

}

.btn-save{

    background:var(--green);
    color:#fff;
    border:none;
    border-radius:14px;
    padding:14px 32px;
    font-size:16px;
    font-weight:600;
    transition:.3s;
    text-decoration:none;

}

.btn-save:hover{

    background:var(--green-dark);
    color:white;
    transform:translateY(-2px);
    box-shadow:0 8px 18px rgba(21,128,61,.25);

}

.btn-cancel{

    background:white;
    border:2px solid var(--orange);
    color:var(--orange);
    border-radius:14px;
    padding:14px 30px;
    font-weight:600;
    transition:.3s;
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    gap:10px;

}

.btn-cancel:hover{

    background:var(--orange);
    color:white;

}

.btn-save i,
.btn-cancel i{

    font-size:18px;

}

.alert{

    border:none;
    border-radius:15px;
    padding:18px 22px;
    margin-bottom:30px;

}

.alert-danger{

    background:#FEE2E2;
    color:#991B1B;

}

hr{

    border-color:#E5E7EB;

}

.d-flex{

    margin-top:10px;

}

::placeholder{

    color:#9CA3AF;

}

.form-control:hover,
.form-select:hover{

    border-color:#CBD5E1;

}

input[type="date"],
input[type="time"]{

    cursor:pointer;

}

@media(max-width:992px){

.card{

padding:30px;

}

.page-title{

flex-direction:column;
align-items:flex-start;

}

}

@media(max-width:768px){

.row>*{

margin-bottom:5px;

}

.page-title h2{

font-size:30px;

}

.card{

padding:22px;

}

.d-flex{

flex-direction:column;

}

.btn-save,
.btn-cancel{

width:100%;
justify-content:center;

}

}
</style>

</head>

<body>


<div class="main">

<div class="content">

<div class="page-title">

<div>
  
<h2>

    <i class="bi bi-plus-circle-fill text-success me-2"></i>

    Nouvelle convocation

</h2>

<p class="text-muted">

Créer une nouvelle convocation pour un candidat.

</p>

</div>

<a href="{{ route('convocations.index') }}" class="btn-cancel">

<i class="bi bi-arrow-left"></i>

Retour

</a>

</div>

@if($errors->any())

<div class="alert alert-danger">

<ul class="mb-0">

@foreach($errors->all() as $error)

<li>{{ $error }}</li>

@endforeach

</ul>

</div>

@endif

<div class="card">

<form action="{{ route('convocations.store') }}" method="POST">

@csrf

<div class="row">

<div class="col-md-6 mb-4">

<label class="form-label">

Candidature

</label>

<select
class="form-select"
name="id_candidature"
required>

<option value="">

Sélectionner...

</option>

@foreach($candidatures as $candidature)

<option value="{{ $candidature->id_candidature }}">

{{ $candidature->candidat->nom }}

{{ $candidature->candidat->prenom }}

—

{{ $candidature->offre->intitule_poste }}

</option>

@endforeach

</select>

</div>

<div class="col-md-3 mb-4">

<label class="form-label">

Date

</label>

<input
type="date"
class="form-control"
name="date_convocation"
required>

</div>

<div class="col-md-3 mb-4">

<label class="form-label">

Heure

</label>

<input
type="time"
class="form-control"
name="heure_convocation"
required>

</div>
<div class="col-md-6 mb-4">

    <label class="form-label">

        Type de convocation

    </label>

    <select
    name="type_convocation"
    class="form-select"
    required>

    <option value="">Sélectionner...</option>

    <option value="Entretien">
        Entretien
    </option>

    <option value="Test écrit">
        Test écrit
    </option>

    <option value="Test pratique">
        Test pratique
    </option>

</select>
</div>


<div class="col-md-6 mb-4">

    <label class="form-label">

        Lieu

    </label>

    <input
        type="text"
        name="lieu_convocation"
        class="form-control"
        placeholder="Salle de réunion, Siège ORMVASM..."
        required>

</div>


<div class="col-md-6 mb-4">

    <label class="form-label">

        Statut

    </label>

    <select
    name="statut_presence"
    class="form-select"
    required>

    <option value="Convoqué">Convoqué</option>

    <option value="Présent">Présent</option>

    <option value="Absent">Absent</option>

    <option value="Excusé">Excusé</option>

</select>
</div>

<div class="col-12 mb-4">

    <label class="form-label">

        Observation

    </label>

    <textarea
        name="observation"
        rows="5"
        class="form-control"
        placeholder="Observation facultative..."></textarea>

</div>

</div>

<hr class="my-4">

<div class="d-flex justify-content-end gap-3">

    <a
        href="{{ route('convocations.index') }}"
        class="btn-cancel">

        <i class="bi bi-x-circle"></i>

        Annuler

    </a>

    <button
        type="submit"
        class="btn-save">

        <i class="bi bi-check-circle"></i>

        Enregistrer la convocation

    </button>

</div>

</form>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
