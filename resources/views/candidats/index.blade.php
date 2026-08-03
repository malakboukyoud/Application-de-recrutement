@extends('layouts.app')

@section('title', 'Liste des candidats')

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
    flex-wrap:wrap;
    gap:20px;
    margin-bottom:30px;

}

.page-title h2{

    font-size:34px;
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
    border-radius:16px;
    box-shadow:var(--shadow);
    background:#fff;
    padding:22px;

}

.form-control,
.form-select{

    height:48px;
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

    font-weight:700;
    white-space:nowrap;

}

.table th,
.table td{

    padding:16px;
    vertical-align:middle;

}

.table tbody tr{

    transition:.25s;
    cursor:pointer;

}

.table tbody tr:hover{

    background:#F8FAFC;

}

.badge-count{

    background:#E0F2FE;
    color:#0369A1;
    padding:7px 14px;
    border-radius:20px;
    font-weight:600;

}

.action{

    display:flex;
    justify-content:center;
    gap:10px;

}

.action a,
.action button{

    width:38px;
    height:38px;

    border:none;

    border-radius:8px;

    display:flex;
    justify-content:center;
    align-items:center;

    background:#F8FAFC;

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

</style>

<div class="page-title">

    <div>

        <h2>Gestion des candidats</h2>

        <p>Liste des candidats enregistrés.</p>

    </div>

    @if($admin || $serviceRH)

    <a href="{{ route('candidats.create') }}" class="btn-add">

        <i class="bi bi-person-plus-fill"></i>

        Ajouter un candidat

    </a>

    @endif

</div>

<div class="card mb-4">

<form method="GET" class="row g-3">

    <div class="col-lg-4">

        <label class="form-label fw-semibold">

            Recherche

        </label>

        <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            class="form-control"
            placeholder="Nom, prénom, CIN, diplôme...">

    </div>

    <div class="col-lg-3">

        <label class="form-label fw-semibold">

            Ville

        </label>

        <select
            name="ville"
            class="form-select">

            <option value="">Toutes les villes</option>

            @foreach($villes as $ville)

                <option
                    value="{{ $ville }}"
                    @selected(request('ville')==$ville)>

                    {{ $ville }}

                </option>

            @endforeach

        </select>

    </div>

    <div class="col-lg-3">

        <label class="form-label fw-semibold">

            Diplôme

        </label>

        <select
            name="id_diplome"
            class="form-select">

            <option value="">Tous les diplômes</option>

            @foreach($diplomes as $diplome)

                <option
                    value="{{ $diplome->id_ref }}"
                    @selected(request('id_diplome')==$diplome->id_ref)>

                    {{ $diplome->libelle }}

                </option>

            @endforeach

        </select>

    </div>

    <div class="col-lg-2 d-flex align-items-end">

        <button
            class="btn-add border-0 w-100">

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

<th>CIN</th>

<th>Candidat</th>

<th>Ville</th>

<th>Diplôme</th>

<th>Spécialité</th>

<th>Candidatures</th>

@if($admin || $serviceRH)
<th width="130" class="text-center">
Actions
</th>
@endif

</tr>

</thead>

<tbody>
    @forelse($candidats as $candidat)

<tr onclick="window.location='{{ route('candidats.show',$candidat) }}'">

    <td>

        <strong>{{ $candidat->cin }}</strong>

    </td>

    <td>

        <strong>{{ $candidat->nom_complet }}</strong>

        @if($candidat->email)

            <br>

            <small class="text-muted">

                {{ $candidat->email }}

            </small>

        @endif

    </td>

    <td>

        {{ $candidat->ville ?? '-' }}

    </td>

    <td>

        {{ optional($candidat->diplome)->libelle ?? '-' }}

    </td>

    <td>

        {{ optional($candidat->specialite)->libelle ?? '-' }}

    </td>

    <td>

        <span class="badge-count">

            {{ $candidat->candidatures_count }}

        </span>

    </td>

    @if($admin || $serviceRH)

    <td onclick="event.stopPropagation();">

        <div class="action">

            <a
                href="{{ route('candidats.show',$candidat) }}"
                class="text-show"
                title="Afficher">

                <i class="bi bi-eye-fill"></i>

            </a>

            <a
                href="{{ route('candidats.edit',$candidat) }}"
                class="text-edit"
                title="Modifier">

                <i class="bi bi-pencil-square"></i>

            </a>

            <form
                action="{{ route('candidats.destroy',$candidat) }}"
                method="POST"
                onsubmit="return confirm('Supprimer ce candidat ?')">

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="text-delete"
                    title="Supprimer"
                    style="background:none;border:none;">

                    <i class="bi bi-trash-fill"></i>

                </button>

            </form>

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

<i class="bi bi-people fs-1 text-secondary"></i>

<br><br>

Aucun candidat trouvé.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

<div class="mt-4">

    {{ $candidats->links() }}

</div>

</div>

@endsection