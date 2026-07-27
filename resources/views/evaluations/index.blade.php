{{-- Destination : resources/views/evaluations/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Évaluations')

@section('content')
    @php
        // Génère un lien d'en-tête de colonne triable, en conservant les filtres actifs.
        $lienTri = function (string $champ, string $libelle) use ($filtres) {
            $nouvelleDirection = ($filtres['tri'] === $champ && $filtres['direction'] === 'asc') ? 'desc' : 'asc';
            $icone = $filtres['tri'] === $champ ? ($filtres['direction'] === 'asc' ? '▲' : '▼') : '';
            $params = array_merge(request()->query(), ['tri' => $champ, 'direction' => $nouvelleDirection]);
            $url = request()->url() . '?' . http_build_query($params);

            return '<a href="' . $url . '" class="text-decoration-none text-dark fw-semibold">' . e($libelle) . ' ' . $icone . '</a>';
        };
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Évaluations</h3>
    </div>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-3">
            <select name="id_offre" class="form-select">
                <option value="">Toutes les offres</option>
                @foreach ($offres as $offre)
                    <option value="{{ $offre->id_offre }}" @selected($filtres['id_offre'] == $offre->id_offre)>
                        {{ $offre->reference_offre }} — {{ $offre->intitule_poste }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="id_diplome" class="form-select">
                <option value="">Tous les diplômes</option>
                @foreach ($diplomes as $diplome)
                    <option value="{{ $diplome }}" @selected($filtres['id_diplome'] == $diplome)>{{ $diplome }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <input type="text" name="candidat" value="{{ $filtres['candidat'] }}" class="form-control"
                   placeholder="Rechercher un candidat (nom, prénom, CIN)">
        </div>
        <div class="col-md-2">
            <button class="btn btn-outline-secondary w-100">Filtrer</button>
        </div>
        {{-- Les paramètres de tri sont conservés lors du filtrage --}}
        <input type="hidden" name="tri" value="{{ $filtres['tri'] }}">
        <input type="hidden" name="direction" value="{{ $filtres['direction'] }}">
    </form>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                <tr>
                    <th>Candidat</th>
                    <th>Offre</th>
                    <th>Diplôme</th>
                    <th>{!! $lienTri('note_ecrite', 'Écrit') !!}</th>
                    <th>{!! $lienTri('note_orale', 'Oral') !!}</th>
                    <th>{!! $lienTri('note_pratique', 'Pratique') !!}</th>
                    <th>{!! $lienTri('note_finale', 'Note finale') !!}</th>
                    <th>{!! $lienTri('id_evaluation', 'N°') !!}</th>
                    <th class="text-end">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($evaluations as $eval)
                    <tr>
                        <td>
                            <a href="{{ route('candidats.show', $eval->candidature->candidat) }}">
                                {{ $eval->candidature->candidat->nom_complet ?? trim($eval->candidature->candidat->nom . ' ' . $eval->candidature->candidat->prenom) }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('candidatures.show', $eval->candidature) }}">
                                {{ $eval->candidature->offre->intitule_poste }}
                            </a>
                        </td>
                        <td>{{ $eval->candidature->candidat->id_diplome }}</td>
                        <td>{{ $eval->note_ecrite ?? '—' }}</td>
                        <td>{{ $eval->note_orale ?? '—' }}</td>
                        <td>{{ $eval->note_pratique ?? '—' }}</td>
                        <td><strong>{{ $eval->note_finale ?? '—' }}</strong></td>
                        <td>{{ $eval->id_evaluation }}</td>
                        <td class="text-end">
                            <a href="{{ route('evaluations.edit', $eval) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center text-muted py-4">Aucune évaluation trouvée.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $evaluations->links() }}</div>
@endsection
