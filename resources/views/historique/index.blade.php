@extends('layouts.app')
@include('layouts.topbar')
@section('title', 'Historique des actions')

@php
    $routesParTable = [
        'candidats' => 'candidats.show',
        'candidatures' => 'candidatures.show',
        'offres_recrutement' => null,
    ];
@endphp

@section('content')

<style>

/* =========================================================
   PALETTE ORMVASM
========================================================= */

.historique-page {

    --green: #15803D;
    --green-dark: #166534;
    --green-light: #DCFCE7;

    --orange: #F97316;
    --orange-dark: #EA580C;
    --orange-light: #FFEDD5;

    --blue: #0284C7;

    --gray: #6B7280;
    --gray-light: #F3F4F6;

    --dark: #1F2937;

    --white: #FFFFFF;

    --border: #E5E7EB;

    --background: #F5F7F6;

    --shadow: 0 6px 20px rgba(15, 23, 42, .06);

    width: 100%;

    padding: 30px 35px 50px;

}


/* =========================================================
   TITRE
========================================================= */

.historique-page .historique-header {

    margin-bottom: 25px;

}


.historique-page .historique-header h3 {

    margin: 0;

    color: var(--dark);

    font-size: 28px;

    font-weight: 700;

    letter-spacing: -.3px;

}


.historique-page .historique-header p {

    margin: 7px 0 0;

    color: var(--gray);

    font-size: 13px;

    line-height: 1.6;

}


/* =========================================================
   FILTRES
========================================================= */

.historique-page .filters-card {

    width: 100%;
    background: var(--white);

    border: 1px solid var(--border);

    border-radius: 14px;

    padding: 20px;

    margin-bottom: 22px;

    box-shadow: var(--shadow);

}


.historique-page .filters-card label {

    display: block;

    margin-bottom: 6px;

    color: #374151;

    font-size: 12px;

    font-weight: 600;

}


/* =========================================================
   INPUTS
========================================================= */

.historique-page .form-control,
.historique-page .form-select {

    min-height: 43px;

    padding: 9px 13px;

    background: #F8FAFC;

    border: 1px solid var(--border);

    border-radius: 9px;

    color: var(--dark);

    font-size: 13px;

    box-shadow: none;

    transition: all .2s ease;

}


.historique-page .form-control:hover,
.historique-page .form-select:hover {

    border-color: #CBD5E1;

}


.historique-page .form-control:focus,
.historique-page .form-select:focus {

    background: var(--white);

    border-color: var(--green);

    box-shadow: 0 0 0 3px rgba(21, 128, 61, .10);

    outline: none;

}


/* =========================================================
   BOUTON FILTRER - ORANGE
========================================================= */

.historique-page .btn-filtrer {

    min-height: 43px;

    width: 100%;

    border: 1px solid var(--orange);

    border-radius: 9px;

    background: var(--orange);

    color: var(--white);

    font-size: 13px;

    font-weight: 600;

    transition: all .2s ease;

}


.historique-page .btn-filtrer:hover {

    background: var(--orange-dark);

    border-color: var(--orange-dark);

    color: var(--white);

    transform: translateY(-1px);

    box-shadow: 0 5px 12px rgba(249, 115, 22, .20);

}


/* =========================================================
   CARTE HISTORIQUE
========================================================= */

.historique-page .historique-card {

    width: 100%;

    background: var(--white);

    border: 1px solid var(--border);

    border-radius: 15px;

    box-shadow: var(--shadow);

    overflow: hidden;

}


/* =========================================================
   TABLEAU
========================================================= */

.historique-page .table-responsive {

    width: 100%;

    overflow-x: auto;

}


.historique-page table {

    width: 100%;

    margin: 0;

    border-collapse: collapse;

    color: var(--dark);

    font-size: 13px;

}


/* =========================================================
   HEADER TABLEAU
========================================================= */

.historique-page .table thead th {

    padding: 15px 16px;

    background: #F8FAFC !important;

    color: #475569;

    border-bottom: 1px solid var(--border);

    font-size: 12px;

    font-weight: 700;

    white-space: nowrap;

    vertical-align: middle;

}


/* Petite ligne verte sous le header */

.historique-page .table thead {

    border-top: 3px solid var(--green);

}


/* =========================================================
   CELLULES
========================================================= */

.historique-page .table tbody td {

    padding: 14px 16px;

    color: #374151;

    border-bottom: 1px solid #F1F5F9;

    vertical-align: middle;

}


.historique-page .table tbody tr {

    transition: background .2s ease;

}


.historique-page .table tbody tr:hover {

    background: #F8FAFC;

}


/* dernière ligne */

.historique-page .table tbody tr:last-child td {

    border-bottom: none;

}


/* =========================================================
   DATE
========================================================= */

.historique-page .date-action {

    color: #475569;

    font-size: 12px;

    font-weight: 600;

    white-space: nowrap;

}


/* =========================================================
   UTILISATEUR
========================================================= */

.historique-page .utilisateur-nom {

    color: var(--dark);

    font-weight: 600;

}


/* =========================================================
   BADGE ACTION
========================================================= */

.historique-page .badge-action {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    min-width: 75px;

    padding: 6px 11px;

    border-radius: 20px;

    background: var(--green-light);

    color: var(--green-dark);

    font-size: 10px;

    font-weight: 700;

    text-transform: capitalize;

}


/* =========================================================
   TABLE CONCERNÉE
========================================================= */

.historique-page .table-name {

    display: inline-block;

    padding: 5px 9px;

    background: #F3F4F6;

    color: #475569;

    border-radius: 6px;

    font-family: monospace;

    font-size: 11px;

}


/* =========================================================
   ENREGISTREMENT
========================================================= */

.historique-page .record-link {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    min-width: 45px;

    padding: 5px 9px;

    border-radius: 7px;

    background: var(--orange-light);

    color: var(--orange-dark);

    font-size: 12px;

    font-weight: 700;

    text-decoration: none;

    transition: all .2s ease;

}


.historique-page .record-link:hover {

    background: var(--orange);

    color: var(--white);

}


/* =========================================================
   DÉTAIL
========================================================= */

.historique-page .detail-action {

    display: block;

    max-width: 350px;

    color: var(--gray);

    font-size: 12px;

    line-height: 1.5;

}


/* =========================================================
   AUCUNE DONNÉE
========================================================= */

.historique-page .empty-history {

    padding: 45px 20px !important;

    text-align: center;

    color: var(--gray);

    font-size: 13px;

}


.historique-page .empty-history i {

    display: block;

    margin-bottom: 10px;

    color: #CBD5E1;

    font-size: 32px;

}


/* =========================================================
   PAGINATION
========================================================= */

.historique-page .pagination-wrapper {

    margin-top: 20px;

}


.historique-page .pagination {

    margin: 0;

}


/* liens pagination */

.historique-page .pagination .page-link {

    border: 1px solid var(--border);

    color: var(--green);

    background: var(--white);

    font-size: 12px;

    border-radius: 7px;

    margin: 0 3px;

}


.historique-page .pagination .page-link:hover {

    background: var(--green-light);

    color: var(--green-dark);

    border-color: #BBF7D0;

}


/* page active */

.historique-page .pagination .active .page-link {

    background: var(--green);

    border-color: var(--green);

    color: var(--white);

}


/* =========================================================
   RESPONSIVE TABLETTE
========================================================= */

@media (max-width: 992px) {

    .historique-page {

        padding: 25px 22px 40px;

    }


    .historique-page .historique-header h3 {

        font-size: 25px;

    }


    .historique-page .filters-card {

        padding: 17px;

    }


    .historique-page .table {

        min-width: 900px;

    }

}


/* =========================================================
   RESPONSIVE MOBILE
========================================================= */

@media (max-width: 768px) {

    .historique-page {

        padding: 20px 15px 35px;

    }


    .historique-page .historique-header h3 {

        font-size: 23px;

    }


    .historique-page .historique-header p {

        font-size: 12px;

    }


    .historique-page .filters-card {

        padding: 15px;

        border-radius: 11px;

    }


    .historique-page .table {

        min-width: 900px;

    }


    .historique-page .historique-card {

        border-radius: 11px;

    }

}


/* =========================================================
   PETIT MOBILE
========================================================= */

@media (max-width: 480px) {

    .historique-page {

        padding: 18px 12px 30px;
        
    }


    .historique-page .historique-header h3 {

        font-size: 21px;

    }

}

</style>


<div class="historique-page">

    {{-- =====================================================
         EN-TÊTE
    ====================================================== --}}

    <div class="historique-header">

        <h3>Historique des actions</h3>

        <p>
            Journal d'audit : traçabilité de toutes les actions
            effectuées dans l'application.
        </p>

    </div>


    {{-- =====================================================
         FILTRES
    ====================================================== --}}

    <div class="filters-card">

        <form method="GET" class="row g-2 align-items-end">

            <div class="col-md-3">

                <label>Table concernée</label>

                <select name="table_concernee" class="form-select">

                    <option value="">
                        Toutes les tables
                    </option>

                    @foreach ($tables as $table)

                        <option
                            value="{{ $table }}"
                            @selected(($filtres['table_concernee'] ?? null) == $table)
                        >
                            {{ $table }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div class="col-md-3">

                <label>Utilisateur</label>

                <select name="id_utilisateur" class="form-select">

                    <option value="">
                        Tous les utilisateurs
                    </option>

                    @foreach ($utilisateurs as $u)

                        <option
                            value="{{ $u->id_utilisateur }}"
                            @selected(($filtres['id_utilisateur'] ?? null) == $u->id_utilisateur)
                        >
                            {{ $u->prenom }} {{ $u->nom }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div class="col-md-2">

                <label>Date début</label>

                <input
                    type="date"
                    name="date_debut"
                    value="{{ $filtres['date_debut'] ?? '' }}"
                    class="form-control"
                >

            </div>


            <div class="col-md-2">

                <label>Date fin</label>

                <input
                    type="date"
                    name="date_fin"
                    value="{{ $filtres['date_fin'] ?? '' }}"
                    class="form-control"
                >

            </div>


            <div class="col-md-2">

                <button class="btn btn-filtrer">

                    <i class="bi bi-funnel me-1"></i>

                    Filtrer

                </button>

            </div>

        </form>

    </div>


    {{-- =====================================================
         TABLEAU
    ====================================================== --}}

    <div class="historique-card">

        <div class="table-responsive">

            <table class="table table-hover mb-0">

                <thead>

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

                        {{-- DATE --}}

                        <td class="date-action">

                            {{ $h->date_action->format('d/m/Y H:i') }}

                        </td>


                        {{-- UTILISATEUR --}}

                        <td>

                            <span class="utilisateur-nom">

                                {{ $h->utilisateur
                                    ? $h->utilisateur->prenom . ' ' . $h->utilisateur->nom
                                    : '—'
                                }}

                            </span>

                        </td>


                        {{-- ACTION --}}

                        <td>

                            <span class="badge-action">

                                {{ ucfirst(str_replace('_', ' ', $h->action)) }}

                            </span>

                        </td>


                        {{-- TABLE --}}

                        <td>

                            <span class="table-name">

                                {{ $h->table_concernee }}

                            </span>

                        </td>


                        {{-- ENREGISTREMENT --}}

                        <td>

                            @php
                                $routeName =
                                    $routesParTable[$h->table_concernee]
                                    ?? null;
                            @endphp


                            @if ($routeName && \Illuminate\Support\Facades\Route::has($routeName))

                                <a
                                    href="{{ route($routeName, $h->id_enregistrement) }}"
                                    class="record-link"
                                >

                                    #{{ $h->id_enregistrement }}

                                </a>

                            @else

                                <span class="record-link">

                                    #{{ $h->id_enregistrement }}

                                </span>

                            @endif

                        </td>


                        {{-- DÉTAIL --}}

                        <td>

                            <span class="detail-action">

                                {{ $h->detail_action }}

                            </span>

                        </td>

                    </tr>


                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="empty-history"
                        >

                            <i class="bi bi-clock-history"></i>

                            Aucune action enregistrée.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- =====================================================
         PAGINATION
    ====================================================== --}}

    <div class="pagination-wrapper">

        {{ $historique->links() }}

    </div>

</div>

@endsection