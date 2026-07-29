<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Détails de la convocation | ORMVASM</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

:root{

    --orange:#F97316;
    --green:#15803D;
    --blue:#0284C7;
    --red:#DC2626;
    --light:#F5F7F6;
    --white:#FFFFFF;
    --border:#E5E7EB;
    --text:#1F2937;
    --gray:#6B7280;

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

.container-page{

    max-width:1100px;
    margin:45px auto;
    padding:20px;

}

/*==========================
        PAGE TITLE
==========================*/

.page-title{

    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:20px;
    margin-bottom:30px;

}

.page-title h2{

    font-size:30px;
    font-weight:700;
    margin-bottom:8px;
    color:#111827;

}

.page-title p{

    margin:0;
    color:var(--gray);

}

/*==========================
          BADGES
==========================*/

.badge-status{

    padding:10px 20px;
    border-radius:30px;
    font-size:14px;
    font-weight:600;

}

.open{

    background:#DCFCE7;
    color:#166534;

}

.blue{

    background:#DBEAFE;
    color:#1D4ED8;

}

.close{

    background:#FEE2E2;
    color:#991B1B;

}

.waiting{

    background:#FEF3C7;
    color:#92400E;

}

/*==========================
            CARD
==========================*/

.convocation-card{

    background:white;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 10px 35px rgba(0,0,0,.08);

}

.card-body{

    padding:35px;

}

.section-title{

    font-size:20px;
    font-weight:700;
    margin-bottom:25px;
    color:#111827;

}

/*==========================
         INFO GRID
==========================*/

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
    color:#6B7280;
    margin-bottom:8px;
    font-weight:600;

}

.info-box span{

    font-size:16px;
    font-weight:600;
    color:#1F2937;

}

/*==========================
        TEXT CARD
==========================*/

.text-card{

    margin-top:30px;
    background:#FCFCFC;
    border:1px solid #ECECEC;
    border-radius:12px;
    padding:22px;

}

.text-card h5{

    margin-bottom:15px;
    color:#111827;

}

.text-card p{

    margin:0;
    line-height:1.8;
    color:#4B5563;
    white-space:pre-line;

}
/*==========================
        BUTTONS
==========================*/

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

    transition:.3s;

}

.btn-return:hover{

    background:var(--orange);

    color:white;

    transform:translateY(-2px);

}

.btn-edit{

    background:white;

    color:var(--green);

    border:2px solid var(--green);

    padding:12px 30px;

    border-radius:10px;

    text-decoration:none;

    font-weight:600;

    transition:.3s;

}

.btn-edit:hover{

    background:var(--green);

    color:white;

    transform:translateY(-2px);

    box-shadow:0 8px 20px rgba(21,128,61,.25);

}

.btn-delete{

    background:#DC2626;

    color:white;

    border:none;

    padding:12px 30px;

    border-radius:10px;

    font-weight:600;

    transition:.3s;

}

.btn-delete:hover{

    background:#B91C1C;

    color:white;

    transform:translateY(-2px);

}

/*==========================
        RESPONSIVE
==========================*/

@media(max-width:768px){

.info-grid{

grid-template-columns:1fr;

}

.buttons{

flex-direction:column;

}

.btn-return,
.btn-edit,
.btn-delete{

width:100%;
text-align:center;

}

}

</style>

</head>

<body>
@php
    $profil = session('user')->profil ?? '';

    $admin = $profil === 'Administrateur';
    $serviceRH = $profil === 'RH';
    $commission = $profil === 'Commission';
    $responsableService = $profil === 'Responsable de service';
    $consultation = $profil === 'Consultation';
@endphp
<div class="container-page">

<!-- ==========================
        TITRE
========================== -->

<div class="page-title">

<div>

<h2>

<i class="bi bi-calendar-check-fill text-warning"></i>

Détails de la convocation

</h2>

<p>

Consultez toutes les informations relatives à cette convocation.

</p>

</div>

<div>

@if($convocation->statut_presence == 'Convoqué')

<span class="badge-status open">

<i class="bi bi-envelope-check-fill"></i>

Convoqué

</span>

@elseif($convocation->statut_presence == 'Présent')

<span class="badge-status blue">

<i class="bi bi-person-check-fill"></i>

Présent

</span>

@elseif($convocation->statut_presence == 'Absent')

<span class="badge-status close">

<i class="bi bi-person-x-fill"></i>

Absent

</span>

@else

<span class="badge-status waiting">

<i class="bi bi-exclamation-circle-fill"></i>

Excusé

</span>

@endif

</div>

</div>

<!-- ==========================
        CARD
========================== -->

<div class="convocation-card">

<div class="card-body">

<h4 class="section-title">

<i class="bi bi-info-circle-fill text-warning"></i>

Informations générales

</h4>

<div class="info-grid">

<div class="info-box">

<label>Candidat</label>

<span>

{{ $convocation->candidature->candidat->nom }}

{{ $convocation->candidature->candidat->prenom }}

</span>

</div>

<div class="info-box">

<label>Offre</label>

<span>

{{ $convocation->candidature->offre->intitule_poste }}

</span>

</div>

<div class="info-box">

<label>Type de convocation</label>

<span>

{{ $convocation->type_convocation }}

</span>

</div>

<div class="info-box">

<label>Date</label>

<span>

{{ \Carbon\Carbon::parse($convocation->date_convocation)->format('d/m/Y') }}

</span>

</div>

<div class="info-box">

<label>Heure</label>

<span>

{{ substr($convocation->heure_convocation,0,5) }}

</span>

</div>

<div class="info-box">

<label>Lieu</label>

<span>

{{ $convocation->lieu_convocation }}

</span>

</div>

<div class="info-box">

    <label>Statut de présence</label>

    <span>

        @if($convocation->statut_presence == 'Convoqué')

            <span class="badge-status open">

                <i class="bi bi-envelope-check-fill"></i>

                Convoqué

            </span>

        @elseif($convocation->statut_presence == 'Présent')

            <span class="badge-status blue">

                <i class="bi bi-person-check-fill"></i>

                Présent

            </span>

        @elseif($convocation->statut_presence == 'Absent')

            <span class="badge-status close">

                <i class="bi bi-person-x-fill"></i>

                Absent

            </span>

        @else

            <span class="badge-status waiting">

                <i class="bi bi-exclamation-circle-fill"></i>

                Excusé

            </span>

        @endif

    </span>

</div>

</div>

<!-- ==========================
        OBSERVATION
========================== -->

<div class="text-card">

    <h5>

        <i class="bi bi-chat-left-text-fill text-warning"></i>

        Observation

    </h5>

    <p>

        {{ $convocation->observation ?: 'Aucune observation.' }}

    </p>

</div>

<!-- ==========================
        BOUTONS
========================== -->

<div class="buttons">

    <a href="{{ route('convocations.index') }}"
       class="btn-return">

        <i class="bi bi-arrow-left-circle"></i>

        Retour à la liste

    </a>
     @if($admin || $serviceRH)
    <a href="{{ route('convocations.edit',$convocation->id_convocation) }}"
       class="btn-edit">

        <i class="bi bi-pencil-square"></i>

        Modifier

    </a>
    @endif
@if($admin || $serviceRH)
    <form action="{{ route('convocations.destroy',$convocation->id_convocation) }}"
          method="POST"
          onsubmit="return confirm('Voulez-vous vraiment supprimer cette convocation ?');">

        @csrf

        @method('DELETE')

        <button type="submit"
                class="btn-delete">

            <i class="bi bi-trash-fill"></i>

            Supprimer

        </button>

    </form>
@endif
</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>