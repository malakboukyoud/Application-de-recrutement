@php
    $old = fn ($field, $default = null) => old($field, $candidat->{$field} ?? $default);
@endphp
@include('layouts.topbar')
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Nom *</label>
        <input type="text" name="nom" value="{{ $old('nom') }}" class="form-control" required maxlength="100">
    </div>
    <div class="col-md-6">
        <label class="form-label">Prénom *</label>
        <input type="text" name="prenom" value="{{ $old('prenom') }}" class="form-control" required maxlength="100">
    </div>

    <div class="col-md-3">
        <label class="form-label">Sexe</label>
        <select name="sexe" class="form-select">
            <option value="">—</option>
            <option value="M" @selected($old('sexe') == 'M')>Masculin</option>
            <option value="F" @selected($old('sexe') == 'F')>Féminin</option>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Date de naissance</label>
        <input type="date" name="date_naissance" value="{{ $old('date_naissance') }}" class="form-control">
    </div>
    <div class="col-md-5">
        <label class="form-label">Lieu de naissance</label>
        <input type="text" name="lieu_naissance" value="{{ $old('lieu_naissance') }}" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">CIN *</label>
        <input type="text" name="cin" value="{{ $old('cin') }}" class="form-control" required maxlength="20">
    </div>
    <div class="col-md-4">
        <label class="form-label">Téléphone</label>
        <input type="text" name="telephone" value="{{ $old('telephone') }}" class="form-control">
    </div>
    <div class="col-md-4">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ $old('email') }}" class="form-control">
    </div>

    <div class="col-md-8">
        <label class="form-label">Adresse</label>
        <input type="text" name="adresse" value="{{ $old('adresse') }}" class="form-control">
    </div>
    <div class="col-md-4">
        <label class="form-label">Ville</label>
        <input type="text" name="ville" value="{{ $old('ville') }}" class="form-control">
    </div>

    <div class="col-12"><hr><h6 class="text-muted">Formation</h6></div>

    <div class="col-md-3">
        <label class="form-label">Niveau d'étude</label>
        <input type="text" name="niveau_etude" value="{{ $old('niveau_etude') }}" class="form-control">
    </div>
    <div class="col-md-3">
        <label class="form-label">Diplôme principal</label>
        <select name="id_diplome" class="form-select">
            <option value="">—</option>
            @foreach ($diplomes as $diplome)
                <option value="{{ $diplome->id_ref }}" @selected($old('id_diplome') == $diplome->id_ref)>{{ $diplome->libelle }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Spécialité</label>
        <select name="id_specialite" class="form-select">
            <option value="">—</option>
            @foreach ($specialites as $specialite)
                <option value="{{ $specialite->id_ref }}" @selected($old('id_specialite') == $specialite->id_ref)>{{ $specialite->libelle }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Année d'obtention</label>
        <input type="number" name="annee_obtention" value="{{ $old('annee_obtention') }}" class="form-control" min="1950" max="{{ date('Y') + 1 }}">
    </div>
    <div class="col-md-12">
        <label class="form-label">Établissement de formation</label>
        <input type="text" name="etablissement" value="{{ $old('etablissement') }}" class="form-control">
    </div>

    <div class="col-12"><hr><h6 class="text-muted">Expérience</h6></div>

    <div class="col-md-6">
        <label class="form-label">Situation actuelle</label>
        <input type="text" name="situation_actuelle" value="{{ $old('situation_actuelle') }}" class="form-control">
    </div>
    <div class="col-md-12">
        <label class="form-label">Expérience professionnelle</label>
        <textarea name="experience" rows="3" class="form-control">{{ $old('experience') }}</textarea>
    </div>
    <div class="col-md-12">
        <label class="form-label">Observations</label>
        <textarea name="observations" rows="2" class="form-control">{{ $old('observations') }}</textarea>
    </div>
</div>

<div class="mt-4">
    <button class="btn btn-success">Enregistrer</button>
    <a href="{{ route('candidats.index') }}" class="btn btn-outline-secondary">Annuler</a>
</div>