@extends('layouts.app')
@section('title', 'Gérer la candidature')

@section('content')
    <h3 class="mb-3">Candidature {{ $candidature->numero_candidature }}</h3>
    <p class="text-muted">
        {{ $candidature->candidat->nom_complet ?? optional($candidature->candidat)->nom . ' ' . optional($candidature->candidat)->prenom }}
        — {{ optional($candidature->offre)->intitule_poste }}
    </p>

    <div class="card p-4">
        <form method="POST" action="{{ route('candidatures.update', $candidature) }}">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Candidat *</label>
                    <select name="id_candidat" class="form-select" required>
                        @foreach ($candidats as $cand)
                            <option value="{{ $cand->id_candidat }}" @selected(old('id_candidat', $candidature->id_candidat) == $cand->id_candidat)>
                                {{ $cand->nom }} {{ $cand->prenom }} — CIN {{ $cand->cin }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Offre *</label>
                    <select name="id_offre" class="form-select" required>
                        @foreach ($offres as $offre)
                            <option value="{{ $offre->id_offre }}" @selected(old('id_offre', $candidature->id_offre) == $offre->id_offre)>
                                {{ $offre->reference_offre }} — {{ $offre->intitule_poste }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Date de dépôt *</label>
                    <input type="date" name="date_depot" value="{{ old('date_depot', $candidature->date_depot->format('Y-m-d')) }}" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Mode de dépôt *</label>
                    <select name="mode_depot" class="form-select" required>
                        @foreach (\App\Models\Candidature::MODES_DEPOT as $mode)
                            <option value="{{ $mode }}" @selected(old('mode_depot', $candidature->mode_depot) == $mode)>{{ ucfirst($mode) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <div class="form-check">
                        <input type="hidden" name="dossier_complet" value="0">
                        <input type="checkbox" name="dossier_complet" value="1" class="form-check-input" id="dossier_complet"
                               @checked(old('dossier_complet', $candidature->dossier_complet))>
                        <label class="form-check-label" for="dossier_complet">Dossier complet</label>
                    </div>
                </div>

                <div class="col-12"><hr><h6 class="text-muted">Traitement de la candidature</h6></div>

                <div class="col-md-4">
                    <label class="form-label">État *</label>
                    <select name="etat_candidature" id="etat_candidature" class="form-select" required>
                        @foreach (\App\Models\Candidature::ETATS as $val => $libelle)
                            <option value="{{ $val }}" @selected(old('etat_candidature', $candidature->etat_candidature) == $val)>{{ $libelle }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Classement</label>
                    <input type="number" name="classement" value="{{ old('classement', $candidature->classement) }}" class="form-control" min="1">
                </div>
                <div class="col-md-4">
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
                    <label class="form-label">Motif de rejet <span class="text-muted">(obligatoire si état = rejetée)</span></label>
                    <textarea name="motif_rejet" rows="2" class="form-control">{{ old('motif_rejet', $candidature->motif_rejet) }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Observation RH</label>
                    <textarea name="observation_rh" rows="2" class="form-control">{{ old('observation_rh', $candidature->observation_rh) }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Observation commission</label>
                    <textarea name="observation_commission" rows="2" class="form-control">{{ old('observation_commission', $candidature->observation_commission) }}</textarea>
                </div>
            </div>

            <div class="mt-4">
                <button class="btn btn-success">Enregistrer</button>
                <a href="{{ route('candidatures.show', $candidature) }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
@endsection
