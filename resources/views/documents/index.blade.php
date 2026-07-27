{{-- Destination : resources/views/documents/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Documents')

@section('content')
    @php
        $lienTri = function (string $champ, string $libelle) use ($filtres) {
            $nouvelleDirection = ($filtres['tri'] === $champ && $filtres['direction'] === 'asc') ? 'desc' : 'asc';
            $icone = $filtres['tri'] === $champ ? ($filtres['direction'] === 'asc' ? '▲' : '▼') : '';
            $params = array_merge(request()->query(), ['tri' => $champ, 'direction' => $nouvelleDirection]);
            $url = request()->url() . '?' . http_build_query($params);

            return '<a href="' . $url . '" class="text-decoration-none text-dark fw-semibold">' . e($libelle) . ' ' . $icone . '</a>';
        };
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Documents</h3>
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
        <div class="col-md-2">
            <select name="id_diplome" class="form-select">
                <option value="">Tous les diplômes</option>
                @foreach ($diplomes as $diplome)
                    <option value="{{ $diplome }}" @selected($filtres['id_diplome'] == $diplome)>{{ $diplome }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input type="text" name="candidat" value="{{ $filtres['candidat'] }}" class="form-control"
                   placeholder="Rechercher un candidat (nom, prénom, CIN)">
        </div>
        <div class="col-md-2">
            <select name="id_type_document" class="form-select">
                <option value="">Tous les types</option>
                @foreach ($typesDocument as $type)
                    <option value="{{ $type->id_ref }}" @selected($filtres['id_type_document'] == $type->id_ref)>{{ $type->libelle }}</option>
                @endforeach
            </select>
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
                    <th>Type de document</th>
                    <th>{!! $lienTri('nom_fichier', 'Fichier') !!}</th>
                    <th>{!! $lienTri('date_ajout', 'Ajouté le') !!}</th>
                    <th class="text-end">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($documents as $doc)
                    <tr>
                        <td>
                            <a href="{{ route('candidats.show', $doc->candidature->candidat) }}">
                                {{ $doc->candidature->candidat->nom_complet ?? trim($doc->candidature->candidat->nom . ' ' . $doc->candidature->candidat->prenom) }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('candidatures.show', $doc->candidature) }}">
                                {{ $doc->candidature->offre->intitule_poste }}
                            </a>
                        </td>
                        <td>{{ $doc->candidature->candidat->id_diplome }}</td>
                        <td>{{ $doc->typeDocument->libelle ?? '—' }}</td>
                        <td>{{ $doc->nom_fichier }}</td>
                        <td>{{ optional($doc->date_ajout)->format('d/m/Y H:i') }}</td>
                        <td class="text-end">
                            <a href="{{ route('candidatures.documents.download', [$doc->candidature, $doc]) }}" class="btn btn-sm btn-outline-secondary">Télécharger</a>
                            <form action="{{ route('candidatures.documents.destroy', [$doc->candidature, $doc]) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Supprimer ce document ?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Aucun document trouvé.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $documents->links() }}</div>
@endsection