@extends('layouts.app')
@section('title', 'Historique des actions')

@php
    // Pour donner un lien direct vers l'enregistrement concerné quand une route existe
    $routesParTable = [
        'candidats' => 'candidats.show',
        'candidatures' => 'candidatures.show',
        'offres_recrutement' => null, // module Offres non fourni dans ce périmètre
    ];
@endphp

@section('content')
    <h3 class="mb-3">Historique des actions</h3>
    <p class="text-muted">Journal d'audit : traçabilité de toutes les actions effectuées dans l'application (§12 du cahier des charges).</p>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-3">
            <select name="table_concernee" class="form-select">
                <option value="">Toutes les tables</option>
                @foreach ($tables as $table)
                    <option value="{{ $table }}" @selected(($filtres['table_concernee'] ?? null) == $table)>{{ $table }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="id_utilisateur" class="form-select">
                <option value="">Tous les utilisateurs</option>
                @foreach ($utilisateurs as $u)
                    <option value="{{ $u->id_utilisateur }}" @selected(($filtres['id_utilisateur'] ?? null) == $u->id_utilisateur)>
                        {{ $u->prenom }} {{ $u->nom }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <input type="date" name="date_debut" value="{{ $filtres['date_debut'] ?? '' }}" class="form-control" title="Du">
        </div>
        <div class="col-md-2">
            <input type="date" name="date_fin" value="{{ $filtres['date_fin'] ?? '' }}" class="form-control" title="Au">
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
                    <th>Date</th>
                    <th>Utilisateur</th>
                    <th>Action</th>
                    <th>Table concernée</th>
                    <th>Enregistrement</th>
                    <th>Détail</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($historique as $h)
                    <tr>
                        <td class="text-nowrap">{{ $h->date_action->format('d/m/Y H:i') }}</td>
                        <td>{{ $h->utilisateur ? $h->utilisateur->prenom . ' ' . $h->utilisateur->nom : '—' }}</td>
                        <td><span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $h->action)) }}</span></td>
                        <td>{{ $h->table_concernee }}</td>
                        <td>
                            @php $routeName = $routesParTable[$h->table_concernee] ?? null; @endphp
                            @if ($routeName && \Illuminate\Support\Facades\Route::has($routeName))
                                <a href="{{ route($routeName, $h->id_enregistrement) }}">#{{ $h->id_enregistrement }}</a>
                            @else
                                #{{ $h->id_enregistrement }}
                            @endif
                        </td>
                        <td class="text-muted small">{{ $h->detail_action }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Aucune action enregistrée.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $historique->links() }}</div>
@endsection
