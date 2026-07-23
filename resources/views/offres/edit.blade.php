<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Modifier une offre | ORMVASM</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

:root{

    --orange:#F97316;
    --blue:#2563EB;
    --green:#16A34A;
    --bg:#F5F7FA;
    --white:#FFF;
    --border:#E5E7EB;
    --text:#1F2937;
    --gray:#6B7280;
    --light:#F5F7F6;

}

*{

    margin:0;
    padding:0;
    box-sizing:border-box;

}

body{

    background:var(--light);
    font-family:"Segoe UI",sans-serif;

}

.container-page{

    max-width:1100px;
    margin:45px auto;
    padding:20px;

}

.form-card{

    background:white;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 10px 35px rgba(0,0,0,.08);

}

.card-header{

    padding:30px 35px;
    border-bottom:1px solid var(--border);

}

.card-header h2{

    margin:0;
    font-size:30px;
    color:#111827;

}

.card-header p{

    margin-top:8px;
    color:var(--gray);

}

.card-body{

    padding:35px;

}

.form-label{

    font-weight:600;
    margin-bottom:8px;
    color:#374151;

}

.form-control,
.form-select{

    border-radius:10px;
    border:1px solid var(--border);
    padding:12px;

}

.form-control:focus,
.form-select:focus{

    border-color:var(--orange);
    box-shadow:0 0 0 .15rem rgba(249,115,22,.15);

}

textarea{

    resize:none;

}

.section-title{

    font-size:20px;
    font-weight:700;
    margin-bottom:25px;
    color:#111827;

}

.buttons{

    display:flex;
    justify-content:flex-end;
    gap:15px;
    margin-top:35px;

}

.btn-back{

    background:#F3F4F6;
    color:#374151;
    text-decoration:none;
    padding:12px 24px;
    border-radius:10px;
    font-weight:600;
    transition:.3s;

}

.btn-back:hover{

    background:#E5E7EB;
    color:#111827;

}

.btn-save{

    background:var(--orange);
    color:white;
    border:none;
    padding:12px 28px;
    border-radius:10px;
    font-weight:600;
    transition:.3s;

}

.btn-save:hover{

    background:#EA580C;

}

.alert{

    border-radius:12px;

}

@media(max-width:768px){

.buttons{

flex-direction:column;

}

.btn-back,
.btn-save{

width:100%;
text-align:center;

}

}

</style>

</head>

<body>

<div class="container-page">

<div class="form-card">

<div class="card-header">

<h2>

<i class="bi bi-pencil-square text-warning"></i>

Modifier une offre

</h2>

<p>

Modifiez les informations de cette offre de recrutement.

</p>

</div>

<div class="card-body">

@if ($errors->any())

<div class="alert alert-danger">

<ul class="mb-0">

@foreach($errors->all() as $error)

<li>{{ $error }}</li>

@endforeach

</ul>

</div>

@endif

<form action="{{ route('offres.update',$offre->id_offre) }}" method="POST">

@csrf

@method('PUT')

<div class="row">
 <!-- Référence -->

<div class="col-md-6 mb-4">

    <label class="form-label">

        Référence de l'offre

    </label>

    <input
        type="text"
        class="form-control"
        name="reference_offre"
        value="{{ old('reference_offre',$offre->reference_offre) }}">

</div>

<!-- Intitulé -->

<div class="col-md-6 mb-4">

    <label class="form-label">

        Intitulé du poste

    </label>

    <input
        type="text"
        class="form-control"
        name="intitule_poste"
        value="{{ old('intitule_poste',$offre->intitule_poste) }}">

</div>

<!-- Type recrutement -->

<div class="col-md-6 mb-4">

    <label class="form-label">
        Type de recrutement
    </label>

    <select class="form-select" name="type_recrutement">

        <option value="Interne"
            {{ old('type_recrutement', $offre->type_recrutement ?? '') == 'Interne' ? 'selected' : '' }}>
            Interne
        </option>

        <option value="Externe"
            {{ old('type_recrutement', $offre->type_recrutement ?? '') == 'Externe' ? 'selected' : '' }}>
            Externe
        </option>

    </select>

</div>

<!-- Nombre de postes -->

<div class="col-md-6 mb-4">

    <label class="form-label">

        Nombre de postes

    </label>

    <input
        type="number"
        min="1"
        class="form-control"
        name="nombre_postes"
        value="{{ old('nombre_postes',$offre->nombre_postes) }}">

</div>

<!-- Service -->

<div class="col-md-6 mb-4">

    <label class="form-label">

        Service concerné

    </label>

    <input
        type="text"
        class="form-control"
        name="service_concerne"
        value="{{ old('service_concerne',$offre->service_concerne) }}">

</div>

<!-- Lieu -->

<div class="col-md-6 mb-4">

    <label class="form-label">

        Lieu d'affectation

    </label>

    <input
        type="text"
        class="form-control"
        name="lieu_affectation"
        value="{{ old('lieu_affectation',$offre->lieu_affectation) }}">

</div>
<!-- Diplôme exigé -->

<div class="col-md-6 mb-4">

    <label class="form-label">

        Diplôme exigé

    </label>

    <select
        class="form-select"
        name="id_diplome_exigee">

        <option value="">-- Sélectionner un diplôme --</option>

        @foreach($diplomes as $diplome)

            <option value="{{ $diplome->id_ref }}"
                {{ old('id_diplome_exigee',$offre->id_diplome_exigee)==$diplome->id_ref ? 'selected' : '' }}>

                {{ $diplome->libelle }}

            </option>

        @endforeach

    </select>

</div>


<!-- Spécialité exigée -->

<div class="col-md-6 mb-4">

    <label class="form-label">

        Spécialité exigée

    </label>

    <select
        class="form-select"
        name="id_specialite_exigee">

        <option value="">-- Sélectionner une spécialité --</option>

        @foreach($specialites as $specialite)

            <option value="{{ $specialite->id_ref }}"
                {{ old('id_specialite_exigee',$offre->id_specialite_exigee)==$specialite->id_ref ? 'selected' : '' }}>

                {{ $specialite->libelle }}

            </option>

        @endforeach

    </select>

</div>


<!-- Expérience -->

<div class="col-md-6 mb-4">

    <label class="form-label">

        Expérience exigée

    </label>

    <input
        type="text"
        class="form-control"
        name="experience_exigee"
        value="{{ old('experience_exigee',$offre->experience_exigee) }}"
        placeholder="Ex : 2 ans">

</div>


<!-- Date publication -->

<div class="col-md-6 mb-4">

    <label class="form-label">

        Date de publication

    </label>

    <input
        type="date"
        class="form-control"
        name="date_publication"
        value="{{ old('date_publication',$offre->date_publication) }}">

</div>


<!-- Date limite -->

<div class="col-md-6 mb-4">

    <label class="form-label">

        Date limite de dépôt

    </label>

    <input
        type="date"
        class="form-control"
        name="date_limite_depot"
        value="{{ old('date_limite_depot',$offre->date_limite_depot) }}">

</div>


<!-- Statut -->

<div class="col-md-6 mb-4">

    <label class="form-label">
        Statut
    </label>

    <select class="form-select" name="statut">

        <option value="Ouverte"
            {{ old('statut', $offre->statut ?? '') == 'Ouverte' ? 'selected' : '' }}>
            Ouverte
        </option>

        <option value="Fermée"
            {{ old('statut', $offre->statut ?? '') == 'Fermée' ? 'selected' : '' }}>
            Fermée
        </option>

    </select>

</div>
<!-- Description du poste -->

<div class="col-12 mb-4">

    <label class="form-label">

        Description du poste

    </label>

    <textarea
        class="form-control"
        name="description_poste"
        rows="5">{{ old('description_poste',$offre->description_poste) }}</textarea>

</div>


<!-- Conditions -->

<div class="col-12 mb-4">

    <label class="form-label">

        Conditions de participation

    </label>

    <textarea
        class="form-control"
        name="conditions_participation"
        rows="4">{{ old('conditions_participation',$offre->conditions_participation) }}</textarea>

</div>


<!-- Observations -->

<div class="col-12 mb-4">

    <label class="form-label">

        Observations

    </label>

    <textarea
        class="form-control"
        name="observations"
        rows="4">{{ old('observations',$offre->observations) }}</textarea>

</div>


<!-- Boutons -->

<div class="buttons">

    <a href="{{ route('offres.index') }}" class="btn-back">

        <i class="bi bi-arrow-left-circle"></i>

        Annuler

    </a>

    <button type="submit" class="btn-save">

        <i class="bi bi-check-circle-fill"></i>

        Enregistrer les modifications

    </button>

</div>

</div>

</form>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>