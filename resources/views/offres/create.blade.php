<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une offre | ORMVASM</title>

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
    --gray:#6B7280;
}

/* ===========================
        RESET
=========================== */

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


/* ===========================
        CONTENT
=========================== */

.content{
    padding-top:700px;
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

/* ===========================
        CARD
=========================== */

.card{

    background:white;

    border:none;

    border-radius:18px;

    padding:35px;

    box-shadow:0 12px 30px rgba(0,0,0,.08);

}

/* ===========================
        FORMULAIRE
=========================== */

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

    transition:.30s;

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

textarea{

    resize:vertical;

    min-height:120px;

}

::placeholder{

    color:#9CA3AF;

}

/* ===========================
        ALERT
=========================== */

.alert{

    border:none;

    border-radius:10px;

    box-shadow:0 5px 15px rgba(0,0,0,.08);

}

/* ===========================
        BUTTONS
=========================== */

.btn-save{

    background:#15803D !important;

    color:#FFFFFF !important;

    border:none;

    padding:12px 28px;

    border-radius:10px;

    font-weight:600;

    transition:.3s;

    box-shadow:0 5px 15px rgba(21,128,61,.25);

}

.btn-save:hover{

    background:#10662F !important;

    color:#FFFFFF !important;

    transform:translateY(-2px);

}

.btn-save i{

    color:#FFFFFF;

    margin-right:8px;

}

.btn-cancel{

    background:white;

    color:var(--orange);

    border:2px solid var(--orange);

    padding:12px 30px;

    border-radius:10px;

    text-decoration:none;

    font-weight:600;

    transition:.30s;

}

.btn-cancel:hover{

    background:var(--orange);

    color:white;

    transform:translateY(-2px);

}

.btn-cancel i{

    margin-right:8px;

}

/* ===========================
        ROWS
=========================== */

.row>.col-md-6,
.row>.col-12{

    margin-bottom:10px;

}

/* ===========================
        HR
=========================== */

hr{

    border:none;

    border-top:1px solid var(--border);

    margin:25px 0;

}

/* ===========================
        RESPONSIVE
=========================== */

@media(max-width:992px){

    .content{

        padding:25px;

    }

    .topbar{

        padding:0 20px;

    }

    .topbar-left h5{

        display:none;

    }

}

@media(max-width:768px){

    .topbar{

        height:auto;

        flex-direction:column;

        gap:15px;

        padding:20px;

    }

    .topbar-left{

        flex-direction:column;

        text-align:center;

    }

    .content{

        padding:20px;

    }

    .card{

        padding:25px;

    }

    .page-title h2{

        font-size:24px;

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

@media(max-width:576px){

    .content{

        padding:15px;

    }

    .topbar-logo{

        width:90px;

    }

    .card{

        padding:18px;

    }

}

    </style>

</head>

<body>


<div class="main">

   
    <!-- Contenu -->

    <div class="content">

        <div class="page-title">

            <h2>

                <i class="bi bi-plus-circle-fill text-success"></i>

                Ajouter une offre de recrutement

            </h2>

            <p class="text-muted">

                Remplissez les informations concernant la nouvelle offre.

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

        <div class="card">

            <form action="{{ route('offres.store') }}" method="POST">

                @csrf

                <div class="row">
                 <!-- Référence -->
<div class="col-md-6 mb-3">

    <label class="form-label">
        Référence de l'offre
    </label>

    <input
        type="text"
        class="form-control"
        name="reference_offre"
        value="{{ old('reference_offre') }}"
        placeholder="Ex : ORMVASM-2026-001">

</div>

<!-- Intitulé -->
<div class="col-md-6 mb-3">

    <label class="form-label">
        Intitulé du poste
    </label>

    <input
        type="text"
        class="form-control"
        name="intitule_poste"
        value="{{ old('intitule_poste') }}"
        placeholder="Ex : Ingénieur Informatique">

</div>

<!-- Type recrutement -->
<div class="col-md-6 mb-3">

    <label class="form-label">
        Type de recrutement
    </label>

    <select
        class="form-select"
        name="type_recrutement">

        <option value="">Choisir...</option>

        <option value="Interne">
            Interne
        </option>

        <option value="Externe">
            Externe
        </option>

    </select>

</div>

<!-- Nombre postes -->
<div class="col-md-6 mb-3">

    <label class="form-label">
        Nombre de postes
    </label>

    <input
        type="number"
        class="form-control"
        name="nombre_postes"
        min="1"
        value="{{ old('nombre_postes') }}">

</div>

<!-- Service -->
<div class="col-md-6 mb-3">

    <label class="form-label">
        Service concerné
    </label>

    <input
        type="text"
        class="form-control"
        name="service_concerne"
        value="{{ old('service_concerne') }}">

</div>

<!-- Lieu -->
<div class="col-md-6 mb-3">

    <label class="form-label">
        Lieu d'affectation
    </label>

    <input
        type="text"
        class="form-control"
        name="lieu_affectation"
        value="{{ old('lieu_affectation') }}">

</div>

<!-- Diplôme -->
<div class="col-md-6 mb-3">

    <label class="form-label">
        Diplôme exigé
    </label>

    <select class="form-select" name="id_diplome_exigee">

        <option value="">-- Sélectionner un diplôme --</option>

        @foreach($diplomes as $diplome)

            <option value="{{ $diplome->id_ref }}">
                {{ $diplome->libelle }}
            </option>

        @endforeach

    </select>

</div>

<!-- Spécialité -->
<div class="col-md-6 mb-3">

    <label class="form-label">
        Spécialité exigée
    </label>

    <select class="form-select" name="id_specialite_exigee">

        <option value="">-- Sélectionner une spécialité --</option>

        @foreach($specialites as $specialite)

            <option value="{{ $specialite->id_ref }}">
                {{ $specialite->libelle }}
            </option>

        @endforeach

    </select>

</div>

<!-- Expérience -->
<div class="col-md-6 mb-3">

    <label class="form-label">
        Expérience exigée
    </label>

    <input
        type="text"
        class="form-control"
        name="experience_exigee"
        value="{{ old('experience_exigee') }}"
        placeholder="Ex : 2 ans">

</div>

<!-- Statut -->
<div class="col-md-6 mb-3">

    <label class="form-label">
        Statut
    </label>

    <select
        class="form-select"
        name="statut">

        <option value="Ouverte">
            Ouverte
        </option>

        <option value="Fermée">
            Fermée
        </option>

    </select>

</div>

<!-- Date publication -->
<div class="col-md-6 mb-3">

    <label class="form-label">
        Date de publication
    </label>

    <input
        type="date"
        class="form-control"
        name="date_publication"
        value="{{ old('date_publication') }}">

</div>

<!-- Date limite -->
<div class="col-md-6 mb-3">

    <label class="form-label">
        Date limite de dépôt
    </label>

    <input
        type="date"
        class="form-control"
        name="date_limite_depot"
        value="{{ old('date_limite_depot') }}">

</div>

<!-- Description -->
<div class="col-12 mb-3">

    <label class="form-label">
        Description du poste
    </label>

    <textarea
        class="form-control"
        rows="4"
        name="description_poste">{{ old('description_poste') }}</textarea>

</div>

<!-- Conditions -->
<div class="col-12 mb-3">

    <label class="form-label">
        Conditions de participation
    </label>

    <textarea
        class="form-control"
        rows="3"
        name="conditions_participation">{{ old('conditions_participation') }}</textarea>

</div>

<!-- Observations -->
<div class="col-12 mb-3">

    <label class="form-label">
        Observations
    </label>

    <textarea
        class="form-control"
        rows="3"
        name="observations">{{ old('observations') }}</textarea>

</div>
<!-- Boutons -->
<div class="col-12 mt-4 d-flex justify-content-end gap-3">

    <a href="{{ route('offres.index') }}" class="btn-cancel">

        <i class="bi bi-arrow-left-circle"></i>

        Annuler

    </a>

   <button type="submit" class="btn-save">
    <i class="bi bi-check-circle-fill"></i>
    Enregistrer l'offre
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