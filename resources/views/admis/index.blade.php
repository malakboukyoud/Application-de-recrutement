@extends('layouts.app')

@include('layouts.topbar')
@section('content')


<style>

.admis-container{
    margin-top:100px;
    padding:25px;

}


.admis-title{

    font-size:28px;

    font-weight:700;

    margin-bottom:30px;

    color:#1F2937;

}


.card-table{

    background:white;

    padding:25px;

    border-radius:16px;

    box-shadow:0 5px 15px rgba(0,0,0,.06);

}



table{

    width:100%;

    border-collapse:collapse;

}


th{

    background:#DCFCE7;

    color:#166534;

    padding:15px;

    text-align:left;

}


td{

    padding:15px;

    border-bottom:1px solid #E5E7EB;

}


.badge{

    background:#DCFCE7;

    color:#15803D;

    padding:6px 15px;

    border-radius:20px;

    font-weight:600;

}


.empty{

    text-align:center;

    padding:30px;

    color:#64748B;

}


</style>



<div class="admis-container">


<h2 class="admis-title">

<i class="bi bi-person-check-fill"></i>

Liste des candidats admis

</h2>



<div class="card-table">


<table>


<thead>

<tr>

<th>Nom complet</th>

<th>Email</th>

<th>Offre</th>

<th>Score</th>

<th>Date</th>

<th>Etat</th>

</tr>

</thead>



<tbody>


@forelse($admis as $candidat)


<tr>


<td>

{{ $candidat->prenom }}

{{ $candidat->nom }}

</td>


<td>

{{ $candidat->email }}

</td>


<td>

{{ $candidat->intitule_poste }}

</td>


<td>

{{ $candidat->note_finale }} %

</td>


<td>

{{ \Carbon\Carbon::parse($candidat->created_at)->format('d/m/Y') }}

</td>


<td>

<span class="badge">

Admis

</span>

</td>


</tr>


@empty


<tr>

<td colspan="6" class="empty">

Aucun candidat admis trouvé.

</td>

</tr>


@endforelse



</tbody>


</table>


</div>


</div>


@endsection