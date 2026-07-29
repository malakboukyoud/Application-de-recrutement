@extends('layouts.app')
@section('title', 'Saisir les résultats')

@section('content')
    <h3 class="mb-3">Résultats — Candidature {{ $candidature->numero_candidature }}</h3>
    <p class="text-muted">
        {{ $candidature->candidat->nom }} {{ $candidature->candidat->prenom }} —
        {{ $candidature->offre->intitule_poste }}
    </p>

    <div class="card p-4">
        <form method="POST" action="{{ route('candidatures.resultats.update', $candidature) }}">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Classement</label>
                    <input type="number" name="classement" min="1"
                           value="{{ old('classement', $candidature->classement) }}" class="form-control">
                </div>
                <div class="col-md-8">
                    <label class="form-label">Décision finale</label>
                    <select name="decision_finale" class="form-select">
                        <option value="">—</option>
                        @foreach (\App\Models\Candidature::DECISIONS as $decision)
                            <option value="{{ $decision }}" @selected(old('decision_finale', $candidature->decision_finale) == $decision)>
                                {{ ucfirst(str_replace('_', ' ', $decision)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Avis de la commission</label>
                    <textarea name="observation_commission" rows="3" class="form-control">{{ old('observation_commission', $candidature->observation_commission) }}</textarea>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger py-2 mt-3">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $erreur)
                            <li>{{ $erreur }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mt-4">
                <button class="btn btn-success">Enregistrer</button>
                <a href="{{ route('candidatures.show', $candidature) }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
@endsection
