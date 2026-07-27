@extends('layouts.app')
@section('title', $candidat->nom_complet)

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h3 class="mb-0">{{ $candidat->nom_complet }}</h3>
            <span class="text-muted">CIN : {{ $candidat->cin }}</span>
        </div>
        <div>
            <a href="{{ route('candidats.edit', $candidat) }}" class="btn btn-outline-primary">Modifier</a>
            <a href="{{ route('candidatures.create', ['id_candidat' => $candidat->id_candidat]) }}" class="btn btn-success">
                + Nouvelle candidature
            </a>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card p-3 h-100">
                <h6 class="text-muted">Informations personnelles</h6>
                <table class="table table-sm mb-0">
                    <tr><th style="width:40%">Sexe</th><td>{{ $candidat->sexe }}</td></tr>
                    <tr><th>Date de naissance</th><td>{{ optional($candidat->date_naissance)->format('d/m/Y') }}</td></tr>
                    <tr><th>Lieu de naissance</th><td>{{ $candidat->lieu_naissance }}</td></tr>
                    <tr><th>Adresse</th><td>{{ $candidat->adresse }}, {{ $candidat->ville }}</td></tr>
                    <tr><th>Téléphone</th><td>{{ $candidat->telephone }}</td></tr>
                    <tr><th>Email</th><td>{{ $candidat->email }}</td></tr>
                    <tr><th>Situation actuelle</th><td>{{ $candidat->situation_actuelle }}</td></tr>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3 h-100">
                <h6 class="text-muted">Formation &amp; expérience</h6>
                <table class="table table-sm mb-0">
                    <tr><th style="width:40%">Niveau d'étude</th><td>{{ $candidat->niveau_etude }}</td></tr>
                    <tr><th>Diplôme</th><td>{{ $candidat->diplome }}</td></tr>
                    <tr><th>Spécialité</th><td>{{ $candidat->specialite }}</td></tr>
                    <tr><th>Établissement</th><td>{{ $candidat->etablissement }}</td></tr>
                    <tr><th>Année d'obtention</th><td>{{ $candidat->annee_obtention }}</td></tr>
                    <tr><th>Expérience</th><td>{{ $candidat->experience }}</td></tr>
                </table>
            </div>
        </div>
    </div>

    <div class="card p-3 mt-3">
        <h6 class="text-muted">Candidatures ({{ $candidat->candidatures->count() }})</h6>
        <table class="table table-sm table-hover mb-0">
            <thead><tr><th>N° candidature</th><th>Offre</th><th>Date de dépôt</th><th>État</th><th></th></tr></thead>
            <tbody>
            @forelse ($candidat->candidatures as $c)
                <tr onclick="window.location='{{ route('candidatures.show', $c) }}'" style="cursor:pointer">
                    <td>{{ $c->numero_candidature }}</td>
                    <td>{{ $c->offre->intitule_poste }}</td>
                    <td>{{ $c->date_depot->format('d/m/Y') }}</td>
                    <td><span class="badge bg-info text-dark">{{ $c->libelleEtat() }}</span></td>
                    <td class="text-end"><a href="{{ route('candidatures.show', $c) }}">Voir →</a></td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-3">Aucune candidature enregistrée.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @if ($candidat->observations)
        <div class="card p-3 mt-3">
            <h6 class="text-muted">Observations</h6>
            <p class="mb-0">{{ $candidat->observations }}</p>
        </div>
    @endif
@endsection
