<!DOCTYPE html>
<html lang="fr">

<head>
<meta charset="UTF-8">

<style>

body{
    font-family: DejaVu Sans, sans-serif;
    font-size:11px;
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
    padding:6px;
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

    <h3>Liste des candidats convoqués</h3>

</div>

<table>

<thead>

<tr>

<th>Nom &amp; Prénom</th>

<th>CIN</th>

<th>Offre</th>

<th>Date</th>

<th>Heure</th>

<th>Type</th>

<th>Lieu</th>

<th>Statut de présence</th>

</tr>

</thead>

<tbody>

@forelse ($convocations as $convocation)

<tr>

<td>{{ $convocation->candidature->candidat->nom ?? '-' }} {{ $convocation->candidature->candidat->prenom ?? '' }}</td>

<td>{{ $convocation->candidature->candidat->cin ?? '-' }}</td>

<td>{{ $convocation->candidature->offre->intitule_poste ?? '-' }}</td>

<td>{{ $convocation->date_convocation }}</td>

<td>{{ $convocation->heure_convocation }}</td>

<td>{{ $convocation->type_convocation }}</td>

<td>{{ $convocation->lieu_convocation }}</td>

<td>{{ $convocation->statut_presence ?? '-' }}</td>

</tr>

@empty

<tr>

<td colspan="8">Aucune convocation trouvée.</td>

</tr>

@endforelse

</tbody>

</table>

<div class="date">

Généré le : {{ now()->format('d/m/Y H:i') }}

</div>

</body>

</html>
