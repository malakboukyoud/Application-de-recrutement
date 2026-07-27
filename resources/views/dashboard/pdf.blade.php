<!DOCTYPE html>
<html lang="fr">

<head>
<meta charset="UTF-8">

<style>

body{
    font-family: DejaVu Sans, sans-serif;
    font-size:12px;
    color:#222;
}

.header{
    text-align:center;
    margin-bottom:20px;
}

.logo{
    width:80px;
    margin-bottom:10px;
}

h2{
    margin:0;
}

h3{
    margin:5px 0 20px;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th,
table td{
    border:1px solid #000;
    padding:8px;
    text-align:center;
}

th{
    background:#e8e8e8;
}

.date{
    margin-top:20px;
    text-align:right;
}

</style>

</head>

<body>

<div class="header">

  {{-- <img src="{{ asset('image/image1.png') }}" width="120"> --}}
    <h2>Office Régional de Mise en Valeur Agricole du Souss Massa</h2>

    <h3>Rapport des candidatures</h3>

</div>

<table>

<thead>

<tr>

<th>ID</th>

<th>Offre</th>

<th>Candidat</th>

<th>État</th>

<th>Dossier complet</th>

<th>Date</th>

</tr>

</thead>

<tbody>

@foreach($candidatures as $c)

<tr>

<td>{{ $c->id_candidature }}</td>

<td>{{ $c->offre->intitule_poste ?? '-' }}</td>

<td>{{ $c->candidat->nom ?? '-' }}</td>

<td>{{ $c->etat_candidature }}</td>

<td>{{ $c->dossier_complet ? 'Oui' : 'Non' }}</td>

<td>{{ $c->created_at->format('d/m/Y') }}</td>

</tr>

@endforeach

</tbody>

</table>

<div class="date">

Généré le : {{ now()->format('d/m/Y H:i') }}

</div>

</body>

</html>