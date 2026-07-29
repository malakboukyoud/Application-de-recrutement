<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Modifier une convocation | ORMVASM</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
 :root{
    --orange:#F97316;
    --green:#15803D;
    --blue:#0284C7;
    --bg:#F5F7F6;
    --white:#FFFFFF;
    --text:#1F2937;
    --text-light:#6B7280;
    --border:#E5E7EB;
    --shadow:0 10px 30px rgba(0,0,0,.08);
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
    font-family:"Segoe UI",sans-serif;
    background:var(--bg);
    color:var(--text);
}

.main{
    min-height:100vh;
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
    align-items:center;
    margin-bottom:30px;
    flex-wrap:wrap;
    gap:20px;
}

.page-title h2{
    font-size:30px;
    font-weight:700;
    color:black;
    margin-bottom:8px;
}

.page-title p{
    margin:0;
    color:var(--text-light);
    font-size:15px;
}

.card{
    background:#fff;
    border:none;
    border-radius:18px;
    box-shadow:var(--shadow);
    padding:40px;
}

.form-label{
    font-weight:600;
    color:#374151;
    margin-bottom:8px;
}

.form-control,
.form-select{
    height:52px;
    border-radius:12px;
    border:1px solid var(--border);
    font-size:15px;
    transition:.3s;
}

textarea.form-control{
    min-height:140px;
    height:auto;
    padding-top:12px;
}

.form-control:focus,
.form-select:focus{
    border-color:var(--green);
    box-shadow:0 0 0 .2rem rgba(21,128,61,.15);
}

.btn-save{
    background:var(--green);
    color:#fff;
    border:2px solid var(--green);
    border-radius:10px;
    padding:13px 28px;
    font-weight:600;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    transition:.35s ease;
}

.btn-save i{
    font-size:17px;
}

.btn-save:hover{
    background:#13632e;
    border-color:#13632e;
    color:#fff;
    transform:translateY(-2px);
    box-shadow:0 8px 20px rgba(21,128,61,.25);
}

.btn-save:active{
    transform:scale(.98);
}

.btn-cancel{
    background:#fff;
    color:var(--orange);
    border:2px solid var(--orange);
    border-radius:10px;
    padding:13px 28px;
    font-weight:600;
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    transition:.35s ease;
}

.btn-cancel i{
    font-size:17px;
}

.btn-cancel:hover{
    background:var(--orange);
    color:#fff;
    transform:translateY(-2px);
    box-shadow:0 8px 20px rgba(249,115,22,.25);
}

.btn-cancel:active{
    transform:scale(.98);
}
.alert{
    border:none;
    border-radius:12px;
    padding:18px;
    margin-bottom:25px;
}

.alert-danger{
    background:#FEE2E2;
    color:#991B1B;
}

hr{
    border-top:1px solid #E5E7EB;
}

.d-flex.gap-3{
    margin-top:15px;
}

input[type=date],
input[type=time]{
    cursor:pointer;
}

.form-control::placeholder{
    color:#9CA3AF;
}

.form-select{
    cursor:pointer;
}

.card:hover{
    transform:translateY(-2px);
    transition:.3s;
}

@media(max-width:992px){

.card{
    padding:30px;
}

}

@media(max-width:768px){

.main{
    padding:20px;
}

.page-title{
    flex-direction:column;
    align-items:flex-start;
}

.page-title h2{
    font-size:28px;
}

.card{
    padding:22px;
}

.btn-save,
.btn-cancel{
    width:100%;
    justify-content:center;
}

.d-flex.justify-content-end{
    flex-direction:column;
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

            <i class="bi bi-pencil-square text-warning"></i>

            Modifier une convocation

        </h2>

        <p class="text-muted">

            Modifiez les informations de cette convocation.

        </p>

    </div>

    <a href="{{ route('convocations.index') }}" class="btn-cancel">

        <i class="bi bi-arrow-left-circle"></i>

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

<form action="{{ route('convocations.update',$convocation->id_convocation) }}" method="POST">

@csrf

@method('PUT')

<div class="row">

<div class="col-md-6 mb-4">

<label class="form-label">

Candidature

</label>

<select
name="id_candidature"
class="form-select"
required>

@foreach($candidatures as $candidature)

<option
value="{{ $candidature->id_candidature }}"
{{ $convocation->id_candidature == $candidature->id_candidature ? 'selected' : '' }}>

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
value="{{ $convocation->date_convocation }}"
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
value="{{ $convocation->heure_convocation }}"
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

    <option value="Entretien"
        {{ $convocation->type_convocation == 'Entretien' ? 'selected' : '' }}>
        Entretien
    </option>


    <option value="Test écrit"
        {{ $convocation->type_convocation == 'Test écrit' ? 'selected' : '' }}>
        Test écrit
    </option>

    <option value="Test pratique"
        {{ $convocation->type_convocation == 'Test pratique' ? 'selected' : '' }}>
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
        value="{{ $convocation->lieu_convocation }}"
        required>

</div>


<div class="col-md-6 mb-4">

    <label class="form-label">

        Statut de présence

    </label>

    <select
    name="statut_presence"
    class="form-select"
    required>

    <option value="Convoqué"
        {{ $convocation->statut == 'Convoqué' ? 'selected' : '' }}>
        Convoqué
    </option>

    <option value="Présent"
        {{ $convocation->statut == 'Présent' ? 'selected' : '' }}>
        Présent
    </option>

    <option value="Absent"
        {{ $convocation->statut == 'Absent' ? 'selected' : '' }}>
        Absent
    </option>

    <option value="Excusé"
        {{ $convocation->statut == 'Excusé' ? 'selected' : '' }}>
        Excusé
    </option>

</select>

</div>

<div class="col-12 mb-4">

    <label class="form-label">

        Observation

    </label>

    <textarea
        name="observation"
        rows="5"
        class="form-control">{{ old('observation',$convocation->observation) }}</textarea>

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

    <i class="bi bi-check-circle-fill"></i>

    Enregistrer les modifications

</button>

</div>

</form>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
