{{-- Destination : resources/views/parametres/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Paramètres')
@include('layouts.topbar')
@section('content')

<style>

/* =========================================================
   VARIABLES
========================================================= */

:root {
    --green: #15803D;
    --green-dark: #166534;
    --green-light: #DCFCE7;

    --orange: #F97316;
    --orange-dark: #EA580C;
    --orange-light: #FFEDD5;

    --blue: #0284C7;
    --blue-light: #E0F2FE;

    --red: #DC2626;
    --red-light: #FEE2E2;

    --gray: #6B7280;
    --gray-light: #F3F4F6;

    --dark: #1F2937;
    --background: #F5F7F6;
    --white: #FFFFFF;
    --border: #E5E7EB;

    --shadow: 0 5px 18px rgba(15, 23, 42, 0.06);
}


/* =========================================================
   PAGE PARAMÈTRES
========================================================= */

/* Le contenu principal */
main {
    width: 100%;
}

/*
   On cible directement le contenu de la page.
   Le CSS fonctionne même si .parametres-page n'existe pas.
*/
main .container,
main .container-fluid {
    max-width: none !important;
    width: 100% !important;
}


/* =========================================================
   TITRE PARAMÈTRES
========================================================= */

main h3 {
    color: var(--dark);
    font-size: 27px;
    font-weight: 700;
    margin-top: 0;
    margin-bottom: 22px !important;
}


/* =========================================================
   ALERTES
========================================================= */

main .alert {
    border: none;
    border-radius: 10px;
    font-size: 13px;
    padding: 12px 15px;
    box-shadow: 0 3px 10px rgba(0,0,0,.04);
}

main .alert-danger {
    background: var(--red-light);
    color: #991B1B;
}


/* =========================================================
   ONGLETS
========================================================= */

#parametresTabs {
    display: flex;
    align-items: stretch;

    width: 100%;

    margin-bottom: 25px !important;

    padding: 5px;

    background: var(--white);

    border: 1px solid var(--border) !important;

    border-radius: 12px;

    box-shadow: var(--shadow);

    overflow-x: auto;

    gap: 4px;
}


/* Chaque élément */

#parametresTabs .nav-item {
    margin: 0;
    flex: 0 0 auto;
}


/* Boutons des onglets */

#parametresTabs .nav-link {

    min-height: 48px;

    display: flex;
    align-items: center;
    justify-content: center;

    padding: 0 25px;

    border: none !important;

    border-radius: 9px !important;

    background: transparent !important;

    color: #64748B;

    font-size: 14px;
    font-weight: 500;

    white-space: nowrap;

    transition: all .2s ease;
}


/* Icônes */

#parametresTabs .nav-link i {
    font-size: 17px;
    margin-right: 6px;
}


/* Hover */

#parametresTabs .nav-link:hover {
    background: #F8FAFC !important;
    color: var(--green) !important;
}


/* Onglet actif */

#parametresTabs .nav-link.active {

    background: var(--green) !important;

    color: white !important;

    font-weight: 600;

    box-shadow: 0 4px 10px rgba(21,128,61,.20);
}


/* Icône actif */

#parametresTabs .nav-link.active i {
    color: white !important;
}


/* =========================================================
   CONTENU
========================================================= */

.tab-content {
    width: 100%;
}


/* =========================================================
   CARTES
========================================================= */

.tab-content .card {

    background: white;

    border: 1px solid var(--border) !important;

    border-radius: 14px !important;

    box-shadow: var(--shadow);

    padding: 25px !important;
}


/* Titres des cartes */

.tab-content .card h6 {

    color: var(--dark);

    font-size: 15px;

    font-weight: 700;
}


/* Texte muted */

.tab-content .text-muted {
    color: var(--gray) !important;
}


/* =========================================================
   FORMULAIRES
========================================================= */

.tab-content .form-label {

    color: #374151;

    font-size: 13px;

    font-weight: 600;

    margin-bottom: 7px;
}


/* Inputs + Select */

.tab-content .form-control,
.tab-content .form-select {

    min-height: 44px;

    padding: 9px 13px;

    background: #F8FAFC;

    border: 1px solid var(--border);

    border-radius: 9px;

    color: var(--dark);

    font-size: 13px;

    box-shadow: none;

    transition: all .2s ease;
}


/* Focus */

.tab-content .form-control:focus,
.tab-content .form-select:focus {

    background: white;

    border-color: var(--green);

    box-shadow: 0 0 0 3px rgba(21,128,61,.10);

}


/* Placeholder */

.tab-content .form-control::placeholder {
    color: #94A3B8;
}


/* =========================================================
   BOUTONS
========================================================= */

.tab-content .btn {

    min-height: 42px;

    padding: 9px 18px;

    border-radius: 9px;

    font-size: 13px;

    font-weight: 600;

    transition: all .2s ease;
}


/* Bouton vert */

.tab-content .btn-success {

    background: var(--green) !important;

    border-color: var(--green) !important;

    color: white !important;
}


.tab-content .btn-success:hover {

    background: var(--green-dark) !important;

    border-color: var(--green-dark) !important;

    transform: translateY(-1px);

    box-shadow: 0 5px 12px rgba(21,128,61,.18);
}


/* =========================================================
   BOUTON UTILISATEURS
========================================================= */

.tab-content .btn-outline-primary {

    color: var(--blue) !important;

    background: var(--blue-light) !important;

    border-color: #BAE6FD !important;
}


.tab-content .btn-outline-primary:hover {

    color: white !important;

    background: var(--blue) !important;

    border-color: var(--blue) !important;
}


/* =========================================================
   BOUTON RÉFÉRENTIEL
========================================================= */

.tab-content .btn-outline-secondary {

    color: #475569 !important;

    background: white !important;

    border-color: var(--border) !important;
}


.tab-content .btn-outline-secondary:hover {

    background: var(--gray-light) !important;

    border-color: #CBD5E1 !important;

    color: var(--dark) !important;
}


/* =========================================================
   HR
========================================================= */

.tab-content hr {

    margin: 25px 0;

    border: 0;

    border-top: 1px solid var(--border);

    opacity: 1;
}


/* =========================================================
   TABLEAU RÉFÉRENTIELS
========================================================= */

#referentiels .table-responsive {

    border: 1px solid var(--border);

    border-radius: 10px;

    overflow: hidden;
}


#referentiels .table {

    margin: 0;

    color: var(--dark);

    font-size: 13px;
}


/* En-tête */

#referentiels .table thead th {

    padding: 13px 15px;

    background: #F8FAFC !important;

    color: #475569;

    border-bottom: 1px solid var(--border);

    font-size: 12px;

    font-weight: 700;

    white-space: nowrap;
}


/* Cellules */

#referentiels .table tbody td {

    padding: 13px 15px;

    vertical-align: middle;

    border-bottom: 1px solid #F1F5F9;
}


/* Hover ligne */

#referentiels .table tbody tr:hover {

    background: #F8FAFC;
}


/* =========================================================
   BADGES
========================================================= */

.tab-content .badge {

    display: inline-flex;

    align-items: center;
    justify-content: center;

    min-width: 60px;

    padding: 6px 10px;

    border-radius: 20px;

    font-size: 10px;

    font-weight: 700;
}


.tab-content .badge.bg-success {

    background: var(--green-light) !important;

    color: var(--green-dark) !important;
}


.tab-content .badge.bg-secondary {

    background: var(--gray-light) !important;

    color: #475569 !important;
}


/* =========================================================
   PROFIL
========================================================= */

/*
   Ton HTML possède style="max-width:600px"
   On le remplace ici.
*/

#profil .card {

    width: 100%;

    max-width: 760px !important;
}


/* =========================================================
   RÉFÉRENTIELS
========================================================= */

#referentiels .card {

    width: 100%;

    max-width: none !important;
}


/* =========================================================
   UTILISATEURS
========================================================= */

#utilisateurs .card {

    width: 100%;

    max-width: 850px;
}


#utilisateurs p {

    max-width: 700px;

    color: var(--gray);

    font-size: 13px;

    line-height: 1.7;
}


/* =========================================================
   AFFICHAGE
========================================================= */

#affichage .card {

    width: 100%;

    max-width: 850px;
}


/* =========================================================
   ANIMATION
========================================================= */

.tab-pane {

    animation: fadeParametres .25s ease;
}


@keyframes fadeParametres {

    from {

        opacity: 0;

        transform: translateY(5px);

    }

    to {

        opacity: 1;

        transform: translateY(0);

    }
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 992px) {

    #parametresTabs .nav-link {

        padding: 0 17px;

        font-size: 13px;
    }

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 768px) {

    #parametresTabs {

        padding: 4px;

        border-radius: 10px;
    }


    #parametresTabs .nav-link {

        min-height: 44px;

        padding: 0 14px;

        font-size: 12px;
    }


    #parametresTabs .nav-link i {

        font-size: 15px;
    }


    .tab-content .card {

        padding: 18px !important;

        border-radius: 12px !important;
    }


    #profil .card,
    #utilisateurs .card,
    #affichage .card {

        max-width: 100% !important;
    }


    .tab-content .btn {

        width: 100%;
    }

}


/* =========================================================
   PETIT MOBILE
========================================================= */

@media (max-width: 480px) {

    #parametresTabs .nav-link {

        padding: 0 11px;
    }


    .tab-content .card {

        padding: 15px !important;
    }


    main h3 {

        font-size: 22px;
    }

}

</style>
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
