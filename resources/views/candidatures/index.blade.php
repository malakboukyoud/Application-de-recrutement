@extends('layouts.app')
@section('title', 'Liste des candidatures')
@include('layouts.topbar')
@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Candidatures</h3>
        <a href="{{ route('candidatures.create') }}" class="btn btn-success">+ Nouvelle candidature</a>
    </div>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-3">
            <select name="id_offre" class="form-select">
                <option value="">Toutes les offres</option>
                @foreach ($offres as $offre)
                    <option value="{{ $offre->id_offre }}" @selected(($filtres['id_offre'] ?? null) == $offre->id_offre)>
                        {{ $offre->reference_offre }} — {{ $offre->intitule_poste }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="etat_candidature" class="form-select">
                <option value="">Tous les états</option>
                @foreach ($etats as $valeur => $libelle)
                    <option value="{{ $valeur }}" @selected(($filtres['etat_candidature'] ?? null) == $valeur)>{{ $libelle }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="dossier_complet" class="form-select">
                <option value="">Dossier (tous)</option>
                <option value="1" @selected(($filtres['dossier_complet'] ?? '') === '1')>Complet</option>
                <option value="0" @selected(($filtres['dossier_complet'] ?? '') === '0')>Incomplet</option>
            </select>
        </div>
        <div class="col-md-3">
            <input type="text" name="recherche" value="{{ $filtres['recherche'] ?? '' }}" class="form-control"
                   placeholder="Rechercher un candidat (nom, CIN)">
        </div>
        <div class="col-md-1">
            <button class="btn btn-outline-secondary w-100">Filtrer</button>
        </div>
    </form>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                <tr>
                    <th>N°</th>
                    <th>Candidat</th>
                    <th>Offre</th>
                    <th>Date dépôt</th>
                    <th>Dossier</th>
                    <th>État</th>
                    <th class="text-end">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($candidatures as $c)
                    <tr onclick="window.location='{{ route('candidatures.show', $c) }}'">
                        <td>{{ $c->numero_candidature }}</td>
                        <td>{{ $c->candidat->nom_complet }}</td>
                        <td>{{ $c->offre->intitule_poste }}</td>
                        <td>{{ $c->date_depot->format('d/m/Y') }}</td>
                        <td>
                            @if ($c->dossier_complet)
                                <span class="badge bg-success">Complet</span>
                            @else
                                <span class="badge bg-warning text-dark">Incomplet</span>
                            @endif
                        </td>
                        <td><span class="badge bg-info text-dark badge-etat">{{ $c->libelleEtat() }}</span></td>
                        <td class="text-end" onclick="event.stopPropagation()">
                            <a href="{{ route('candidatures.edit', $c) }}" class="btn btn-sm btn-outline-primary">Gérer</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Aucune candidature trouvée.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $candidatures->links() }}</div>
@endsection
