@extends('layouts.app')

@section('title', 'Documents')

@include('layouts.topbar')

@section('content')

@php

    $lienTri = function (string $champ, string $libelle) use ($filtres) {

        $nouvelleDirection = ($filtres['tri'] === $champ && $filtres['direction'] === 'asc')
            ? 'desc'
            : 'asc';

        $icone = $filtres['tri'] === $champ
            ? ($filtres['direction'] === 'asc' ? '▲' : '▼')
            : '';

        $params = array_merge(
            request()->query(),
            [
                'tri' => $champ,
                'direction' => $nouvelleDirection
            ]
        );

        $url = request()->url().'?' . http_build_query($params);

        return '<a href="'.$url.'" class="text-decoration-none text-dark fw-semibold">'
            .e($libelle).' '.$icone.
            '</a>';

    };

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

    font-size:32px;
    font-weight:700;
    color:var(--text);

}

.page-title p{

    color:var(--text-light);
    margin:0;

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

.btn-add{

    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;

    padding:12px 22px;

    background:var(--orange);
    color:#fff;

    border:none;
    border-radius:10px;

    font-size:15px;
    font-weight:600;

    transition:.25s;

}

.btn-add:hover{

    background:#EA580C;
    color:#fff;

}

.table{

    margin:0;

}

.table thead{

    background:#F8FAFC;

}

.table th{

    font-weight:700;

}

.table th,
.table td{

    padding:16px;
    vertical-align:middle;

}

.table tbody tr{

    transition:.25s;

}

.table tbody tr:hover{

    background:#F8FAFC;

}

.badge-file{

    background:#DBEAFE;
    color:#1D4ED8;

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

    display:flex;
    justify-content:center;
    align-items:center;

    border:none;
    border-radius:8px;

    background:#F8FAFC;

    transition:.25s;

}

.text-download{

    color:#15803D;

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

        <h2>Gestion des documents</h2>

        <p>
            Consultation et téléchargement des documents des candidats.
        </p>

    </div>

</div>

<div class="card mb-4">

<form method="GET" class="row g-3">

<div class="col-lg-3">

<label class="form-label fw-semibold">

Offre

</label>

<select
name="id_offre"
class="form-select">

<option value="">

Toutes les offres

</option>

@foreach($offres as $offre)

<option
value="{{ $offre->id_offre }}"
@selected($filtres['id_offre']==$offre->id_offre)>

{{ $offre->reference_offre }}

—

{{ $offre->intitule_poste }}

</option>

@endforeach

</select>

</div>

<div class="col-lg-2">

<label class="form-label fw-semibold">

Diplôme

</label>

<select
name="id_diplome"
class="form-select">

<option value="">

Tous les diplômes

</option>

@foreach($diplomes as $diplome)

<option
value="{{ $diplome->id_ref }}"
@selected($filtres['id_diplome']==$diplome->id_ref)>

{{ $diplome->libelle }}

</option>

@endforeach

</select>

</div>

<div class="col-lg-3">

<label class="form-label fw-semibold">

Candidat

</label>

<input
type="text"
name="candidat"
class="form-control"
value="{{ $filtres['candidat'] }}"
placeholder="Nom, prénom ou CIN">

</div>

<div class="col-lg-2">

<label class="form-label fw-semibold">

Type

</label>

<select
name="id_type_document"
class="form-select">

<option value="">

Tous les types

</option>

@foreach($typesDocument as $type)

<option
value="{{ $type->id_ref }}"
@selected($filtres['id_type_document']==$type->id_ref)>

{{ $type->libelle }}

</option>

@endforeach

</select>

</div>

<div class="col-lg-2 d-flex align-items-end">

<button class="btn-add w-100">

<i class="bi bi-search"></i>

Filtrer

</button>

</div>

<input
type="hidden"
name="tri"
value="{{ $filtres['tri'] }}">

<input
type="hidden"
name="direction"
value="{{ $filtres['direction'] }}">

</form>

</div>

<div class="card">

<div class="table-responsive">

<table class="table align-middle">

<thead>

<tr>

<th>Candidat</th>

<th>Offre</th>

<th>Diplôme</th>

<th>Type</th>

<th>{!! $lienTri('nom_fichier','Fichier') !!}</th>

<th>{!! $lienTri('date_ajout','Ajouté le') !!}</th>

<th class="text-center">

Actions

</th>

</tr>

</thead>

<tbody>
    @forelse($documents as $doc)

<tr>

    <td>

        <a href="{{ route('candidats.show',$doc->candidature->candidat) }}">

            <strong>

                {{ $doc->candidature->candidat->nom_complet
                    ?? trim($doc->candidature->candidat->nom.' '.$doc->candidature->candidat->prenom) }}

            </strong>

        </a>

    </td>

    <td>

        <a href="{{ route('candidatures.show',$doc->candidature) }}">

            {{ $doc->candidature->offre->intitule_poste }}

        </a>

    </td>

    <td>

        {{ optional($doc->candidature->candidat->diplome)->libelle ?? '-' }}

    </td>

    <td>

        <span class="badge-file">

            {{ $doc->typeDocument->libelle ?? '—' }}

        </span>

    </td>

    <td>

        <strong>

            {{ $doc->nom_fichier }}

        </strong>

    </td>

    <td>

        {{ optional($doc->date_ajout)->format('d/m/Y H:i') }}

    </td>

    <td>

        <div class="action">

            <a
                href="{{ route('candidatures.documents.download',[$doc->candidature,$doc]) }}"
                class="text-download"
                title="Télécharger">

                <i class="bi bi-download"></i>

            </a>

            <form
                action="{{ route('candidatures.documents.destroy',[$doc->candidature,$doc]) }}"
                method="POST"
                onsubmit="return confirm('Supprimer ce document ?')">

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

</tr>

@empty

<tr>

<td colspan="7" class="text-center py-5">

<i class="bi bi-folder-x fs-1 text-secondary"></i>

<br><br>

Aucun document trouvé.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

<div class="mt-4">

    {{ $documents->links() }}

</div>

</div>

@endsection