@php
    $old = fn ($field, $default = null) => old($field, $evaluation->{$field} ?? $default);
@endphp
@include('layouts.topbar')
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Convocation liée <span class="text-muted">(optionnel)</span></label>
        <select name="id_convocation" class="form-select">
            <option value="">— Aucune —</option>
            @foreach ($convocations as $conv)
                <option value="{{ $conv->id_convocation }}" @selected($old('id_convocation') == $conv->id_convocation)>
                    {{ $conv->type_convocation }} — {{ $conv->date_convocation->format('d/m/Y') }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-12"><hr><h6 class="text-muted">Notes (sur 20)</h6></div>

    <div class="col-md-4">
        <label class="form-label">Note écrite</label>
        <input type="number" step="0.01" min="0" max="20" name="note_ecrite" value="{{ $old('note_ecrite') }}" class="form-control">
    </div>
    <div class="col-md-4">
        <label class="form-label">Note orale</label>
        <input type="number" step="0.01" min="0" max="20" name="note_orale" value="{{ $old('note_orale') }}" class="form-control">
    </div>
    <div class="col-md-4">
        <label class="form-label">Note pratique</label>
        <input type="number" step="0.01" min="0" max="20" name="note_pratique" value="{{ $old('note_pratique') }}" class="form-control">
    </div>

    <div class="col-12"><h6 class="text-muted mt-2">Coefficients</h6></div>

    <div class="col-md-4">
        <label class="form-label">Coefficient écrit</label>
        <input type="number" step="0.01" min="0" max="9.99" name="coefficient_ecrit" value="{{ $old('coefficient_ecrit', 1) }}" class="form-control" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Coefficient oral</label>
        <input type="number" step="0.01" min="0" max="9.99" name="coefficient_oral" value="{{ $old('coefficient_oral', 1) }}" class="form-control" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Coefficient pratique</label>
        <input type="number" step="0.01" min="0" max="9.99" name="coefficient_pratique" value="{{ $old('coefficient_pratique', 1) }}" class="form-control" required>
    </div>

    <div class="col-12">
        <div class="alert alert-info py-2 mb-0">
            La <strong>note finale</strong> est calculée automatiquement (moyenne pondérée des notes
            renseignées par leurs coefficients respectifs) — elle n'est jamais saisie manuellement.
            @if (($evaluation->note_finale ?? null) !== null)
                Note finale actuelle : <strong>{{ $evaluation->note_finale }}/20</strong>.
            @endif
        </div>
    </div>

    <div class="col-12">
        <label class="form-label">Appréciation</label>
        <input type="text" name="appreciation" value="{{ $old('appreciation') }}" class="form-control" maxlength="255">
    </div>
</div>

<div class="mt-4">
    <button class="btn btn-success">Enregistrer</button>
    <a href="{{ route('candidatures.show', $candidature) }}" class="btn btn-outline-secondary">Annuler</a>
</div>
