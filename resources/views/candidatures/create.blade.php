@extends('layouts.app')
@section('title', 'Nouvelle candidature')

@section('content')
    <h3 class="mb-3">Nouvelle candidature</h3>
    <div class="card p-4">
        <form method="POST" action="{{ route('candidatures.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Candidat *</label>
                    <select name="id_candidat" class="form-select" required>
                        <option value="">— Sélectionner —</option>
                        @foreach ($candidats as $cand)
                            <option value="{{ $cand->id_candidat }}" @selected(old('id_candidat', $candidature->id_candidat) == $cand->id_candidat)>
                                {{ $cand->nom }} {{ $cand->prenom }} — CIN {{ $cand->cin }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Offre de recrutement *</label>
                    <select name="id_offre" class="form-select" required>
                        <option value="">— Sélectionner —</option>
                        @foreach ($offres as $offre)
                            <option value="{{ $offre->id_offre }}" @selected(old('id_offre', $candidature->id_offre) == $offre->id_offre)>
                                {{ $offre->reference_offre }} — {{ $offre->intitule_poste }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Date de dépôt *</label>
                    <input type="date" name="date_depot" value="{{ old('date_depot', date('Y-m-d')) }}" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Mode de dépôt *</label>
                    <select name="mode_depot" class="form-select" required>
                        @foreach (\App\Models\Candidature::MODES_DEPOT as $mode)
                            <option value="{{ $mode }}" @selected(old('mode_depot') == $mode)>{{ ucfirst($mode) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">État initial *</label>
                    <select name="etat_candidature" class="form-select" required>
                        @foreach (\App\Models\Candidature::ETATS as $val => $libelle)
                            <option value="{{ $val }}" @selected(old('etat_candidature', 'recue') == $val)>{{ $libelle }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-12">
                    <label class="form-label">Observation RH</label>
                    <textarea name="observation_rh" rows="2" class="form-control">{{ old('observation_rh') }}</textarea>
                </div>
            </div>

            <div class="mt-4">
                <button class="btn btn-success">Enregistrer</button>
                <a href="{{ route('candidatures.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
@endsection
