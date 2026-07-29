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

    <h2>Office Régional de Mise en Valeur Agricole du Souss Massa</h2>

    <h3>Liste des candidats admis</h3>

</div>

<table>

<thead>

<tr>

<th>Classement</th>

<th>Nom &amp; Prénom</th>

<th>CIN</th>

<th>Offre</th>

<th>Avis de la commission</th>

</tr>

</thead>

<tbody>

@forelse ($candidatures as $c)

<tr>

<td>{{ $c->classement ?? '-' }}</td>

<td>{{ $c->candidat->nom ?? '-' }} {{ $c->candidat->prenom ?? '' }}</td>

<td>{{ $c->candidat->cin ?? '-' }}</td>

<td>{{ $c->offre->intitule_poste ?? '-' }}</td>

<td>{{ $c->observation_commission ?? '-' }}</td>

</tr>

@empty

<tr>

<td colspan="5">Aucun candidat admis pour le moment.</td>

</tr>

@endforelse

</tbody>

</table>

<div class="date">

Généré le : {{ now()->format('d/m/Y H:i') }}

</div>

</body>

</html>
