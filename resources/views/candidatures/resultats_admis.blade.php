@extends('layouts.app')
@section('title', 'Résultats')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-0">Résultats — Candidats admis</h3>
            <span class="text-muted">{{ $candidatures->count() }} candidat(s) admis</span>
        </div>
        <div>
            <a href="{{ route('resultats.export.excel') }}" class="btn btn-outline-success">
                <i class="bi bi-file-earmark-excel me-1"></i> Exporter Excel
            </a>
            <a href="{{ route('resultats.export.pdf') }}" class="btn btn-outline-danger">
                <i class="bi bi-file-earmark-pdf me-1"></i> Exporter PDF
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success py-2">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger py-2">{{ session('error') }}</div>
    @endif

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Classement</th>
                        <th>Candidat</th>
                        <th>CIN</th>
                        <th>Offre</th>
                        <th>Avis de la commission</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($candidatures as $candidature)
                        <tr>
                            <td>{{ $candidature->classement ?? '-' }}</td>
                            <td>{{ $candidature->candidat->nom ?? '-' }} {{ $candidature->candidat->prenom ?? '' }}</td>
                            <td>{{ $candidature->candidat->cin ?? '-' }}</td>
                            <td>{{ $candidature->offre->intitule_poste ?? '-' }}</td>
                            <td>{{ $candidature->observation_commission ?? '-' }}</td>
                            <td class="text-end">
                                <a href="{{ route('candidatures.show', $candidature) }}" class="btn btn-sm btn-outline-primary">
                                    Voir
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Aucun candidat admis pour le moment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
