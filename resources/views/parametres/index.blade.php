{{-- Destination : resources/views/parametres/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Paramètres')

@section('content')
    <h3 class="mb-3">Paramètres</h3>

    @if ($errors->any())
        <div class="alert alert-danger py-2">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $erreur)
                    <li>{{ $erreur }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <ul class="nav nav-tabs mb-4" id="parametresTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tab-profil" data-bs-toggle="tab" data-bs-target="#profil" type="button">
                <i class="bi bi-person-circle me-1"></i> Mon profil
            </button>
        </li>
        @if (\App\Http\Middleware\RoleMiddleware::userHasRole(['administrateur', 'rh']))
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-referentiels" data-bs-toggle="tab" data-bs-target="#referentiels" type="button">
                <i class="bi bi-list-check me-1"></i> Référentiels
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-organisme" data-bs-toggle="tab" data-bs-target="#organisme" type="button">
                <i class="bi bi-building me-1"></i> Organisme
            </button>
        </li>
        @endif
        @if (\App\Http\Middleware\RoleMiddleware::userHasRole(['administrateur']))
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-utilisateurs" data-bs-toggle="tab" data-bs-target="#utilisateurs" type="button">
                <i class="bi bi-person-gear me-1"></i> Comptes utilisateurs
            </button>
        </li>
        @endif
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-affichage" data-bs-toggle="tab" data-bs-target="#affichage" type="button">
                <i class="bi bi-sliders me-1"></i> Affichage
            </button>
        </li>
    </ul>

    <div class="tab-content">

        {{-- ============ MON PROFIL ============ --}}
        <div class="tab-pane fade show active" id="profil">
            <div class="card p-4" style="max-width:600px;">
                <h6 class="text-muted mb-3">Mes informations personnelles</h6>
                <form method="POST" action="{{ route('parametres.profil.update') }}" class="row g-3">
                    @csrf @method('PUT')
                    <div class="col-md-6">
                        <label class="form-label">Nom *</label>
                        <input type="text" name="nom" value="{{ old('nom', $utilisateurConnecte->nom ?? '') }}" class="form-control" required maxlength="100">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Prénom *</label>
                        <input type="text" name="prenom" value="{{ old('prenom', $utilisateurConnecte->prenom ?? '') }}" class="form-control" required maxlength="100">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" value="{{ old('email', $utilisateurConnecte->email ?? '') }}" class="form-control" required maxlength="150">
                    </div>
                    <div class="col-12"><hr><h6 class="text-muted">Changer le mot de passe (optionnel)</h6></div>
                    <div class="col-md-6">
                        <label class="form-label">Nouveau mot de passe</label>
                        <input type="password" name="mot_de_passe" class="form-control" minlength="6" autocomplete="new-password">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Confirmer le mot de passe</label>
                        <input type="password" name="mot_de_passe_confirmation" class="form-control" minlength="6" autocomplete="new-password">
                    </div>
                    <div class="col-12 mt-2">
                        <button class="btn btn-success">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>

        @if (\App\Http\Middleware\RoleMiddleware::userHasRole(['administrateur', 'rh']))
        {{-- ============ RÉFÉRENTIELS ============ --}}
        <div class="tab-pane fade" id="referentiels">
            <div class="card p-4">
                <form method="GET" action="{{ route('parametres.index') }}" class="row g-2 mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Catégorie</label>
                        <select name="categorie" class="form-select" onchange="this.form.submit()">
                            @foreach ($categories as $val => $libelle)
                                <option value="{{ $val }}" @selected($categorie === $val)>{{ $libelle }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>

                <div class="table-responsive mb-3">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="table-light">
                        <tr><th>Libellé</th><th>Statut</th><th class="text-end">Action</th></tr>
                        </thead>
                        <tbody>
                        @forelse ($referentiels as $ref)
                            <tr>
                                <td>{{ $ref->libelle }}</td>
                                <td>
                                    @if ($ref->actif)
                                        <span class="badge bg-success">Actif</span>
                                    @else
                                        <span class="badge bg-secondary">Inactif</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <form method="POST" action="{{ route('parametres.referentiels.toggle', $ref) }}" class="d-inline">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm btn-outline-secondary">
                                            {{ $ref->actif ? 'Désactiver' : 'Réactiver' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted py-3">Aucune valeur pour cette catégorie.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <hr>
                <h6 class="text-muted">Ajouter une valeur</h6>
                <form method="POST" action="{{ route('parametres.referentiels.store') }}" class="row g-2">
                    @csrf
                    <input type="hidden" name="type_ref" value="{{ $categorie }}">
                    <div class="col-md-6">
                        <input type="text" name="libelle" class="form-control" placeholder="Nouveau libellé" required maxlength="150">
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-success w-100">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ============ ORGANISME ============ --}}
        <div class="tab-pane fade" id="organisme">
            <div class="card p-4">
                <form method="POST" action="{{ route('parametres.organisme.update') }}" class="row g-3">
                    @csrf @method('PUT')
                    <div class="col-md-8">
                        <label class="form-label">Nom de l'organisme</label>
                        <input type="text" name="nom_organisme" value="{{ old('nom_organisme', $organisme->nom_organisme) }}" class="form-control" maxlength="150">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Sigle</label>
                        <input type="text" name="sigle" value="{{ old('sigle', $organisme->sigle) }}" class="form-control" maxlength="20">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Adresse</label>
                        <input type="text" name="adresse" value="{{ old('adresse', $organisme->adresse) }}" class="form-control" maxlength="255">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Téléphone</label>
                        <input type="text" name="telephone" value="{{ old('telephone', $organisme->telephone) }}" class="form-control" maxlength="30">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', $organisme->email) }}" class="form-control" maxlength="150">
                    </div>
                    <div class="col-12 mt-4">
                        <button class="btn btn-success">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
        @endif

        @if (\App\Http\Middleware\RoleMiddleware::userHasRole(['administrateur']))
        {{-- ============ UTILISATEURS (Admin uniquement) ============ --}}
        <div class="tab-pane fade" id="utilisateurs">
            <div class="card p-4">
                <h6 class="text-muted mb-2">Gestion des comptes utilisateurs</h6>
                <p class="text-muted">Créez, modifiez, activez/désactivez ou supprimez les comptes ayant accès à l'application.</p>
                <a href="{{ route('utilisateurs.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-person-gear me-1"></i> Gérer les utilisateurs
                </a>
            </div>
        </div>
        @endif

        {{-- ============ AFFICHAGE ============ --}}
        <div class="tab-pane fade" id="affichage">
            <div class="card p-4">
                <form method="POST" action="{{ route('parametres.preferences.update') }}" class="row g-3">
                    @csrf
                    <div class="col-md-6">
                        <label class="form-label">Éléments par page (listes)</label>
                        <select name="pagination" class="form-select">
                            @foreach ([10, 15, 25, 50] as $valeur)
                                <option value="{{ $valeur }}" @selected($preferences['pagination'] == $valeur)>{{ $valeur }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Densité des tableaux</label>
                        <select name="densite" class="form-select">
                            <option value="normal" @selected($preferences['densite'] === 'normal')>Normale</option>
                            <option value="compacte" @selected($preferences['densite'] === 'compacte')>Compacte</option>
                        </select>
                    </div>
                    <div class="col-12 mt-4">
                        <button class="btn btn-success">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        // Rouvre l'onglet Référentiels après un filtrage/ajout (le formulaire GET recharge la page).
        document.addEventListener('DOMContentLoaded', function () {
            var params = new URLSearchParams(window.location.search);
            if (params.has('categorie')) {
                var trigger = document.getElementById('tab-referentiels');
                if (trigger) new bootstrap.Tab(trigger).show();
            }
        });
    </script>
@endpush