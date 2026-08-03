@extends('layouts.app')

@section('title', 'Liste des candidatures')

@include('layouts.topbar')

@section('content')

@php
    $profil = session('user')->profil ?? '';

    $admin = $profil === 'Administrateur';
    $serviceRH = $profil === 'RH';
    $commission = $profil === 'Commission';
    $responsableService = $profil === 'Responsable de service';
    $consultation = $profil === 'Consultation';
@endphp

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

    --success:#DCFCE7;
    --danger:#FEE2E2;

    --shadow:0 8px 25px rgba(0,0,0,.06);

}

.page-title{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
    flex-wrap:wrap;
    gap:15px;
}

.page-title h2{
    font-size:32px;
    font-weight:700;
    color:var(--text);
}

.page-title p{
    color:var(--text-light);
    margin:0;
}

.btn-add{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;

    background:var(--orange);
    color:#fff !important;

    padding:12px 22px;

    border:none;
    border-radius:10px;

    font-size:20px;
    font-weight:600;
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;

    text-decoration:none;
    white-space:nowrap;

    cursor:pointer;

    transition:all .25s ease;
}

.btn-add:hover{
    background:#EA580C;
    color:#fff !important;
    transform:translateY(-2px);
    box-shadow:0 8px 20px rgba(249,115,22,.25);
}

.btn-add:active{
    transform:scale(.98);
}

.btn-add i{
    font-size:18px;
}
.card{
    border:none;
    border-radius:15px;
    box-shadow:var(--shadow);
    padding:20px;
    background:#fff;
}

.form-control,
.form-select{

    height:46px;
    border-radius:10px;
    border:1px solid var(--border);

}

.form-control:focus,
.form-select:focus{

    border-color:var(--green);
    box-shadow:0 0 0 3px rgba(21,128,61,.08);

}

.table{
    margin:0;
}

.table thead{
    background:#F8FAFC;
}

.table th{
    font-weight:600;
    white-space:nowrap;
}

.table th,
.table td{
    padding:15px;
    vertical-align:middle;
}

.table tbody tr{
    transition:.25s;
    cursor:pointer;
}

.table tbody tr:hover{
    background:#F8FAFC;
}

.badge-complet{
    background:#DCFCE7;
    color:#166534;
    padding:7px 15px;
    border-radius:20px;
    font-weight:600;
}

.badge-incomplet{
    background:#FEE2E2;
    color:#991B1B;
    padding:7px 15px;
    border-radius:20px;
    font-weight:600;
}

.badge-etat{
    background:#E0F2FE;
    color:#0369A1;
    padding:7px 15px;
    border-radius:20px;
    font-weight:600;
}

.action{
    display:flex;
    justify-content:center;
    align-items:center;
    gap:10px;
}

.action a{

    width:38px;
    height:38px;

    display:flex;
    align-items:center;
    justify-content:center;

    border-radius:8px;

    background:#F8FAFC;

    text-decoration:none;

    transition:.25s;

}

.text-show{
    color:#16A34A;
}

.text-edit{
    color:#0284C7;
}

.text-delete{
    color:#DC2626;
}

.action a:hover,
.action button:hover{

    background:#EEF2F7;
    transform:scale(1.08);

}

.pagination{
    justify-content:center;
    margin-top:25px;
}

@media(max-width:768px){

    .content{
        padding:20px;
    }

    .page-title{

        flex-direction:column;
        align-items:flex-start;

    }

    .btn-add{

        width:100%;
        justify-content:center;

    }

}

</style>

<div>
    <div class="page-title">

    <div>
        <h2>Gestion des candidatures</h2>
        <p>Liste des candidatures reçues.</p>
    </div>

    @if($admin || $serviceRH)
        <a href="{{ route('candidatures.create') }}" class="btn-add">
            <i class="bi bi-plus-circle"></i>
            Ajouter une candidature
        </a>
    @endif

</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card mb-4">

    <form method="GET" class="row g-3">

        <div class="col-lg-3 col-md-6">

            <label class="form-label fw-semibold">
                Offre
            </label>

            <select name="id_offre" class="form-select">

                <option value="">
                    Toutes les offres
                </option>

                @foreach($offres as $offre)

                    <option
                        value="{{ $offre->id_offre }}"
                        @selected(($filtres['id_offre'] ?? null) == $offre->id_offre)
                    >

                        {{ $offre->reference_offre }}
                        —
                        {{ $offre->intitule_poste }}

                    </option>

                @endforeach

            </select>

        </div>

        <div class="col-lg-3 col-md-6">

            <label class="form-label fw-semibold">
                État
            </label>

            <select
                name="etat_candidature"
                class="form-select">

                <option value="">
                    Tous les états
                </option>

                @foreach($etats as $valeur => $libelle)

                    <option
                        value="{{ $valeur }}"
                        @selected(($filtres['etat_candidature'] ?? null) == $valeur)
                    >

                        {{ $libelle }}

                    </option>

                @endforeach

            </select>

        </div>

        <div class="col-lg-2 col-md-6">

            <label class="form-label fw-semibold">
                Dossier
            </label>

            <select
                name="dossier_complet"
                class="form-select">

                <option value="">
                    Tous
                </option>

                <option
                    value="1"
                    @selected(($filtres['dossier_complet'] ?? '') === '1')
                >
                    Complet
                </option>

                <option
                    value="0"
                    @selected(($filtres['dossier_complet'] ?? '') === '0')
                >
                    Incomplet
                </option>

            </select>

        </div>

        <div class="col-lg-4 col-md-6">

            <label class="form-label fw-semibold">
                Recherche
            </label>

            <input
                type="text"
                name="recherche"
                class="form-control"
                value="{{ $filtres['recherche'] ?? '' }}"
                placeholder="Nom, prénom ou CIN">

        </div>

        <div class="col-lg-12">

            <button
                type="submit"
                class="btn-add border-0">

                <i class="bi bi-search"></i>

                Filtrer

            </button>

        </div>

    </form>

</div>

<div class="card">

    <div class="table-responsive">

        <table class="table align-middle">

            <thead>

                <tr>

                    <th>N°</th>

                    <th>Candidat</th>

                    <th>Offre</th>

                    <th>Date dépôt</th>

                    <th>Dossier</th>

                    <th>État</th>

                    @if($admin || $serviceRH)
                        <th width="120" class="text-center">
                            Actions
                        </th>
                    @endif

                </tr>

            </thead>

            <tbody>
                @forelse($candidatures as $c)

<tr onclick="window.location='{{ route('candidatures.show',$c) }}'">

    <td>
        {{ $c->numero_candidature }}
    </td>

    <td>

        <strong>
            {{ $c->candidat->nom_complet }}
        </strong>

        @if(!empty($c->candidat->cin))
            <br>
            <small class="text-muted">
                CIN : {{ $c->candidat->cin }}
            </small>
        @endif

    </td>

    <td>

        <strong>
            {{ $c->offre->intitule_poste }}
        </strong>

        <br>

        <small class="text-muted">

            {{ $c->offre->reference_offre }}

        </small>

    </td>

    <td>

        {{ $c->date_depot->format('d/m/Y') }}

    </td>

    <td>

        @if($c->dossier_complet)

            <span class="badge-complet">

                Complet

            </span>

        @else

            <span class="badge-incomplet">

                Incomplet

            </span>

        @endif

    </td>

    <td>

        <span class="badge-etat">

            {{ $c->libelleEtat() }}

        </span>

    </td>

    @if($admin || $serviceRH)

    <td onclick="event.stopPropagation();">

        <div class="action">

            <a
                href="{{ route('candidatures.show',$c) }}"
                class="text-show"
                title="Afficher">

                <i class="bi bi-eye-fill"></i>

            </a>

            <a
                href="{{ route('candidatures.edit',$c) }}"
                class="text-edit"
                title="Modifier">

                <i class="bi bi-pencil-square"></i>

            </a>

        </div>

    </td>

    @endif

</tr>

@empty

<tr>

@if($admin || $serviceRH)

<td colspan="7" class="text-center py-5">

@else

<td colspan="6" class="text-center py-5">

@endif

<i class="bi bi-folder2-open fs-1 text-secondary"></i>

<br><br>

Aucune candidature disponible.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

<div class="mt-4">

{{ $candidatures->links() }}

</div>

</div>
@endsection
