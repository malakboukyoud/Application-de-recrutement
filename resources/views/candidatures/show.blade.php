@extends('layouts.app')
@section('title', 'Candidature ' . $candidature->numero_candidature)

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h3 class="mb-0">Candidature {{ $candidature->numero_candidature }}</h3>
            <span class="text-muted">
                {{ $candidature->candidat->nom }} {{ $candidature->candidat->prenom }} —
                {{ $candidature->offre->intitule_poste }}
            </span>
        </div>
        <div>
            <span class="badge bg-info text-dark fs-6">{{ $candidature->libelleEtat() }}</span>
            <a href="{{ route('candidatures.edit', $candidature) }}" class="btn btn-outline-primary">Gérer</a>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="card p-3 h-100">
                <h6 class="text-muted">Candidat</h6>
                <p class="mb-1"><strong>CIN :</strong> {{ $candidature->candidat->cin }}</p>
                <p class="mb-1"><strong>Téléphone :</strong> {{ $candidature->candidat->telephone }}</p>
                <p class="mb-1"><strong>Email :</strong> {{ $candidature->candidat->email }}</p>
                <a href="{{ route('candidats.show', $candidature->candidat) }}">Voir la fiche candidat →</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 h-100">
                <h6 class="text-muted">Dossier</h6>
                <p class="mb-1"><strong>Date de dépôt :</strong> {{ $candidature->date_depot->format('d/m/Y') }}</p>
                <p class="mb-1"><strong>Mode de dépôt :</strong> {{ ucfirst($candidature->mode_depot) }}</p>
                <p class="mb-1">
                    <strong>Dossier :</strong>
                    @if ($candidature->dossier_complet)
                        <span class="badge bg-success">Complet</span>
                    @else
                        <span class="badge bg-warning text-dark">Incomplet</span>
                    @endif
                </p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 h-100">
                <h6 class="text-muted">Résultat</h6>
                <p class="mb-1"><strong>Classement :</strong> {{ $candidature->classement ?? '—' }}</p>
                <p class="mb-1"><strong>Décision finale :</strong> {{ $candidature->decision_finale ?? '—' }}</p>
                @if ($candidature->motif_rejet)
                    <p class="mb-1 text-danger"><strong>Motif de rejet :</strong> {{ $candidature->motif_rejet }}</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Changement rapide d'état (présélection / rejet / convocation...) --}}
    <div class="card p-3 mt-3">
        <h6 class="text-muted">Changer l'état de la candidature</h6>
        <form method="POST" action="{{ route('candidatures.changer-etat', $candidature) }}" class="row g-2 align-items-end">
            @csrf @method('PATCH')
            <div class="col-md-4">
                <select name="etat_candidature" class="form-select" required>
                    @foreach (\App\Models\Candidature::ETATS as $val => $libelle)
                        <option value="{{ $val }}" @selected($candidature->etat_candidature == $val)>{{ $libelle }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <input type="text" name="motif_rejet" class="form-control" placeholder="Motif de rejet (si rejetée)">
            </div>
            <div class="col-md-2">
                <button class="btn btn-success w-100">Appliquer</button>
            </div>
        </form>
    </div>

    {{-- Pièces jointes --}}
    <div class="card p-3 mt-3">
        <h6 class="text-muted">Pièces jointes</h6>

        @if (count($piecesManquantes))
            <div class="alert alert-warning py-2">
                Pièces manquantes : {{ implode(', ', $piecesManquantes) }}
            </div>
        @endif

        <table class="table table-sm">
            <thead><tr><th>Type</th><th>Fichier</th><th>Ajouté le</th><th></th></tr></thead>
            <tbody>
            @forelse ($candidature->documents as $doc)
                <tr>
                    <td>{{ $doc->typeDocument->libelle ?? '—' }}</td>
                    <td>{{ $doc->nom_fichier }}</td>
                    <td>{{ $doc->date_ajout->format('d/m/Y H:i') }}</td>
                    <td class="text-end">
                        <a href="{{ route('candidatures.documents.download', [$candidature, $doc]) }}" class="btn btn-sm btn-outline-secondary">Télécharger</a>
                        <form action="{{ route('candidatures.documents.destroy', [$candidature, $doc]) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Supprimer ce document ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted py-2">Aucun document déposé.</td></tr>
            @endforelse
            </tbody>
        </table>

        @if ($errors->any())
            <div class="alert alert-danger py-2 mt-2">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $erreur)
                        <li>{{ $erreur }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('candidatures.documents.store', $candidature) }}" enctype="multipart/form-data" class="row g-2 mt-2">
            @csrf
            <div class="col-md-4">
                <select name="id_type_document" class="form-select" required>
                    <option value="">Type de document</option>
                    @foreach ($typesDocument as $type)
                        <option value="{{ $type->id_ref }}" @selected(old('id_type_document') == $type->id_ref)>{{ $type->libelle }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <input type="file" name="fichier" class="form-control" required accept=".pdf,.jpg,.jpeg,.png,.docx">
            </div>
            <div class="col-md-3">
                <button class="btn btn-success w-100">Ajouter le document</button>
            </div>
        </form>
    </div>

    {{-- Convocations --}}
    <div class="card p-3 mt-3">
        <h6 class="text-muted">Convocations</h6>
        <table class="table table-sm mb-0">
            <thead><tr><th>Type</th><th>Date</th><th>Heure</th><th>Lieu</th><th>Présence</th></tr></thead>
            <tbody>
            @forelse ($candidature->convocations as $conv)
                <tr>
                    <td>{{ $conv->type_convocation }}</td>
                    <td>{{ $conv->date_convocation->format('d/m/Y') }}</td>
                    <td>{{ $conv->heure_convocation }}</td>
                    <td>{{ $conv->lieu_convocation }}</td>
                    <td>{{ $conv->statut_presence }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-2">Aucune convocation.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- Évaluations --}}
    <div class="card p-3 mt-3 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="text-muted mb-0">Notes et évaluations</h6>
            <a href="{{ route('candidatures.evaluations.create', $candidature) }}" class="btn btn-sm btn-success">
                + Ajouter une évaluation
            </a>
        </div>
        <table class="table table-sm mt-2 mb-0">
            <thead><tr><th>Écrit</th><th>Oral</th><th>Pratique</th><th>Note finale</th><th>Appréciation</th><th></th></tr></thead>
            <tbody>
            @forelse ($candidature->evaluations as $eval)
                <tr>
                    <td>{{ $eval->note_ecrite ?? '—' }}</td>
                    <td>{{ $eval->note_orale ?? '—' }}</td>
                    <td>{{ $eval->note_pratique ?? '—' }}</td>
                    <td><strong>{{ $eval->note_finale ?? '—' }}</strong></td>
                    <td>{{ $eval->appreciation }}</td>
                    <td class="text-end">
                        <a href="{{ route('evaluations.edit', $eval) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-2">Aucune évaluation saisie.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection