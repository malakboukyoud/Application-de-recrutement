@extends('layouts.app')
@section('title', 'Liste des candidats')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Candidats</h3>
        <a href="{{ route('candidats.create') }}" class="btn btn-success">+ Nouveau candidat</a>
    </div>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                   placeholder="Rechercher par nom, prénom, CIN, diplôme ou ville">
        </div>
        <div class="col-md-3">
            <select name="ville" class="form-select">
                <option value="">Toutes les villes</option>
                @foreach ($villes as $ville)
                    <option value="{{ $ville }}" @selected(request('ville') == $ville)>{{ $ville }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="diplome" class="form-select">
                <option value="">Tous les diplômes</option>
                @foreach ($diplomes as $diplome)
                    <option value="{{ $diplome }}" @selected(request('diplome') == $diplome)>{{ $diplome }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-outline-secondary w-100">Filtrer</button>
        </div>
    </form>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                <tr>
                    <th>CIN</th>
                    <th>Nom &amp; prénom</th>
                    <th>Ville</th>
                    <th>Diplôme</th>
                    <th>Spécialité</th>
                    <th>Candidatures</th>
                    <th class="text-end">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($candidats as $candidat)
                    <tr onclick="window.location='{{ route('candidats.show', $candidat) }}'">
                        <td>{{ $candidat->cin }}</td>
                        <td>{{ $candidat->nom_complet }}</td>
                        <td>{{ $candidat->ville }}</td>
                        <td>{{ $candidat->diplome }}</td>
                        <td>{{ $candidat->specialite }}</td>
                        <td><span class="badge bg-secondary">{{ $candidat->candidatures_count }}</span></td>
                        <td class="text-end" onclick="event.stopPropagation()">
                            <a href="{{ route('candidats.edit', $candidat) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
                            <form action="{{ route('candidats.destroy', $candidat) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Supprimer ce candidat ?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Aucun candidat trouvé.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $candidats->links() }}</div>
@endsection
