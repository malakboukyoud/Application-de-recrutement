{{-- Destination : resources/views/evaluations/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Évaluations')

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

    --shadow: 0 8px 25px rgba(15, 23, 42, .06);
}


/* =========================================================
   PAGE
========================================================= */

.evaluations-page {

    width: 100%;

    min-height: calc(100vh - 80px);

    padding: 30px 35px 50px;

    background: var(--background);

}


/* =========================================================
   HEADER
========================================================= */

.evaluations-header {

    width: 100%;

    margin-bottom: 24px;

}


.evaluations-header h3 {

    margin: 0;

    color: var(--dark);

    font-size: 28px;

    font-weight: 700;

    letter-spacing: -.3px;

}


.evaluations-header p {

    margin: 7px 0 0;

    color: var(--gray);

    font-size: 13px;

}


/* =========================================================
   FILTRES
========================================================= */

.evaluations-filters {

    width: 100%;

    background: var(--white);

    border: 1px solid var(--border);

    border-radius: 14px;

    padding: 18px;

    margin-bottom: 22px;

    box-shadow: var(--shadow);

}


.evaluations-filters .form-control,
.evaluations-filters .form-select {

    min-height: 44px;

    border: 1px solid var(--border);

    border-radius: 9px;

    background: #F8FAFC;

    color: var(--dark);

    font-size: 13px;

    padding: 9px 13px;

    box-shadow: none;

    transition: all .2s ease;

}


.evaluations-filters .form-control:focus,
.evaluations-filters .form-select:focus {

    background: var(--white);

    border-color: var(--green);

    box-shadow: 0 0 0 3px rgba(21,128,61,.08);

}


.evaluations-filters .form-control::placeholder {

    color: #94A3B8;

}


/* =========================================================
   BOUTON FILTRER
========================================================= */

.btn-filtrer {

    min-height: 44px;

    border-radius: 9px;

    border: 1px solid var(--orange);

    background: var(--orange);

    color: var(--white);

    font-size: 13px;

    font-weight: 600;

    transition: all .2s ease;

}


.btn-filtrer:hover {

    background: var(--orange-dark);

    border-color: var(--orange-dark);

    color: var(--white);

    transform: translateY(-1px);

    box-shadow: 0 5px 12px rgba(249,115,22,.18);

}


/* =========================================================
   CARTE TABLEAU
========================================================= */

.evaluations-card {

    width: 100%;

    background: var(--white);

    border: 1px solid var(--border);

    border-radius: 16px;

    box-shadow: var(--shadow);

    overflow: hidden;

}


/* =========================================================
   TABLEAU
========================================================= */

.evaluations-card .table {

    width: 100%;

    margin: 0;

    color: var(--dark);

    font-size: 13px;

}


/* =========================================================
   ENTÊTE TABLEAU
========================================================= */

.evaluations-card .table thead th {

    padding: 15px 14px;

    background: #F8FAFC;

    color: #475569;

    border-bottom: 1px solid var(--border);

    font-size: 12px;

    font-weight: 700;

    white-space: nowrap;

    vertical-align: middle;

}


.evaluations-card .table thead th a {

    color: #475569;

    text-decoration: none;

    transition: color .2s ease;

}


.evaluations-card .table thead th a:hover {

    color: var(--green);

}


/* =========================================================
   LIGNES
========================================================= */

.evaluations-card .table tbody td {

    padding: 14px;

    border-bottom: 1px solid #F1F5F9;

    vertical-align: middle;

}


.evaluations-card .table tbody tr {

    transition: background .2s ease;

}


.evaluations-card .table tbody tr:hover {

    background: #F8FAFC;

}


/* dernière ligne */

.evaluations-card .table tbody tr:last-child td {

    border-bottom: none;

}


/* =========================================================
   LIENS CANDIDATS / OFFRES
========================================================= */

.evaluations-card .table tbody td a {

    color: var(--green);

    font-weight: 600;

    text-decoration: none;

    transition: color .2s ease;

}


.evaluations-card .table tbody td a:hover {

    color: var(--orange-dark);

    text-decoration: underline;

}


/* =========================================================
   NOTES
========================================================= */

.note-cell {

    font-weight: 600;

    color: var(--dark);

}


.note-finale {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    min-width: 55px;

    padding: 6px 10px;

    border-radius: 8px;

    background: var(--green-light);

    color: var(--green-dark);

    font-weight: 700;

}


/* =========================================================
   ID EVALUATION
========================================================= */

.evaluation-id {

    color: var(--gray);

    font-size: 12px;

    font-weight: 600;

}


/* =========================================================
   BOUTON MODIFIER
========================================================= */

.btn-modifier {

    min-height: 34px;

    padding: 6px 12px;

    border-radius: 8px;

    border: 1px solid #FED7AA;

    background: var(--orange-light);

    color: var(--orange-dark);

    font-size: 12px;

    font-weight: 600;

    text-decoration: none !important;

    transition: all .2s ease;

}


.btn-modifier:hover {

    background: var(--orange);

    border-color: var(--orange);

    color: var(--white) !important;

    transform: translateY(-1px);

}


/* =========================================================
   MESSAGE AUCUNE ÉVALUATION
========================================================= */

.empty-evaluations {

    padding: 45px 20px !important;

    color: var(--gray);

    text-align: center;

    font-size: 13px;

}


/* =========================================================
   PAGINATION
========================================================= */

.evaluations-pagination {

    margin-top: 20px;

}


.evaluations-pagination .pagination {

    margin: 0;

}


.evaluations-pagination .page-link {

    border: 1px solid var(--border);

    color: var(--dark);

    background: var(--white);

    border-radius: 7px;

    margin: 0 3px;

    font-size: 12px;

    min-width: 36px;

    text-align: center;

    transition: all .2s ease;

}


.evaluations-pagination .page-link:hover {

    background: var(--green-light);

    border-color: var(--green);

    color: var(--green-dark);

}


.evaluations-pagination .page-item.active .page-link {

    background: var(--green);

    border-color: var(--green);

    color: var(--white);

}


/* =========================================================
   RESPONSIVE TABLETTE
========================================================= */

@media (max-width: 1200px) {

    .evaluations-page {

        padding: 28px 25px 45px;

    }

    .evaluations-card .table {

        font-size: 12px;

    }

    .evaluations-card .table thead th {

        padding: 13px 11px;

    }

    .evaluations-card .table tbody td {

        padding: 12px 11px;

    }

}


/* =========================================================
   TABLETTE
========================================================= */

@media (max-width: 992px) {

    .evaluations-page {

        padding: 25px 22px 40px;

    }


    .evaluations-header h3 {

        font-size: 25px;

    }


    .evaluations-filters {

        padding: 15px;

    }


    .evaluations-card {

        border-radius: 13px;

    }

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 768px) {

    .evaluations-page {

        padding: 20px 15px 35px;

    }


    .evaluations-header h3 {

        font-size: 23px;

    }


    .evaluations-header p {

        font-size: 12px;

        line-height: 1.6;

    }


    .evaluations-filters {

        padding: 14px;

        border-radius: 12px;

    }


    .evaluations-filters .btn-filtrer {

        width: 100%;

    }


    .evaluations-card {

        border-radius: 12px;

    }


    .evaluations-card .table {

        min-width: 950px;

    }


    .evaluations-card .table thead th {

        padding: 12px 10px;

    }


    .evaluations-card .table tbody td {

        padding: 12px 10px;

    }

}


/* =========================================================
   PETIT MOBILE
========================================================= */

@media (max-width: 480px) {

    .evaluations-page {

        padding: 18px 12px 30px;

    }


    .evaluations-header h3 {

        font-size: 21px;

    }


    .evaluations-filters {

        padding: 12px;

    }


    .evaluations-pagination .page-link {

        min-width: 32px;

        padding: 6px 8px;

        font-size: 11px;

    }

}

</style>


{{-- =========================================================
     PAGE
========================================================= --}}

<div class="evaluations-page">

    @php

        // Génère un lien d'en-tête de colonne triable
        // en conservant les filtres actifs.

        $lienTri = function (string $champ, string $libelle) use ($filtres) {

            $nouvelleDirection =
                ($filtres['tri'] === $champ && $filtres['direction'] === 'asc')
                ? 'desc'
                : 'asc';

            $icone =
                $filtres['tri'] === $champ
                ? ($filtres['direction'] === 'asc' ? '▲' : '▼')
                : '';

            $params = array_merge(
                request()->query(),
                [
                    'tri' => $champ,
                    'direction' => $nouvelleDirection
                ]
            );

            $url = request()->url() . '?' . http_build_query($params);

            return '<a href="' . $url . '">'
                . e($libelle)
                . ' '
                . $icone
                . '</a>';
        };

    @endphp


    {{-- =====================================================
         HEADER
    ====================================================== --}}
    <div>
    <div class="evaluations-header">

        <h3>Évaluations</h3>

        <p>
            Consultez, filtrez et gérez les évaluations des candidats.
        </p>

    </div>


    {{-- =====================================================
         FILTRES
    ====================================================== --}}

    <div class="evaluations-filters">

        <form method="GET" class="row g-2">

            {{-- Offre --}}

            <div class="col-md-3">

                <select name="id_offre" class="form-select">

                    <option value="">
                        Toutes les offres
                    </option>

                    @foreach ($offres as $offre)

                        <option
                            value="{{ $offre->id_offre }}"
                            @selected($filtres['id_offre'] == $offre->id_offre)
                        >

                            {{ $offre->reference_offre }}
                            —
                            {{ $offre->intitule_poste }}

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Diplôme --}}

            <div class="col-md-3">

                <select name="id_diplome" class="form-select">

                    <option value="">
                        Tous les diplômes
                    </option>

                    @foreach ($diplomes as $diplome)

                        <option
                            value="{{ $diplome->id_ref }}"
                            @selected($filtres['id_diplome'] == $diplome->id_ref)
                        >

                            {{ $diplome->libelle }}

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Candidat --}}

            <div class="col-md-4">

                <input
                    type="text"
                    name="candidat"
                    value="{{ $filtres['candidat'] }}"
                    class="form-control"
                    placeholder="Rechercher un candidat (nom, prénom, CIN)"
                >

            </div>


            {{-- Bouton --}}

            <div class="col-md-2">

                <button class="btn btn-filtrer w-100">

                    <i class="bi bi-funnel me-1"></i>

                    Filtrer

                </button>

            </div>


            {{-- Conservation du tri --}}

            <input
                type="hidden"
                name="tri"
                value="{{ $filtres['tri'] }}"
            >

            <input
                type="hidden"
                name="direction"
                value="{{ $filtres['direction'] }}"
            >

        </form>

    </div>


    {{-- =====================================================
         TABLEAU
    ====================================================== --}}

    <div class="evaluations-card">

        <div class="table-responsive">

            <table class="table table-hover mb-0">

                <thead>

                    <tr>

                        <th>
                            Candidat
                        </th>

                        <th>
                            Offre
                        </th>

                        <th>
                            Diplôme
                        </th>

                        <th>
                            {!! $lienTri('note_ecrite', 'Écrit') !!}
                        </th>

                        <th>
                            {!! $lienTri('note_orale', 'Oral') !!}
                        </th>

                        <th>
                            {!! $lienTri('note_pratique', 'Pratique') !!}
                        </th>

                        <th>
                            {!! $lienTri('note_finale', 'Note finale') !!}
                        </th>

                        <th>
                            {!! $lienTri('id_evaluation', 'N°') !!}
                        </th>

                        <th class="text-end">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                @forelse ($evaluations as $eval)

                    <tr>

                        {{-- Candidat --}}

                        <td>

                            <a
                                href="{{ route('candidats.show', $eval->candidature->candidat) }}"
                            >

                                {{ $eval->candidature->candidat->nom_complet
                                    ?? trim(
                                        $eval->candidature->candidat->nom
                                        . ' '
                                        . $eval->candidature->candidat->prenom
                                    )
                                }}

                            </a>

                        </td>


                        {{-- Offre --}}

                        <td>

                            <a
                                href="{{ route('candidatures.show', $eval->candidature) }}"
                            >

                                {{ $eval->candidature->offre->intitule_poste }}

                            </a>

                        </td>


                        {{-- Diplôme --}}

                        <td>

                            {{ optional(
                                $eval->candidature->candidat->diplome
                            )->libelle ?? '-' }}

                        </td>


                        {{-- Écrit --}}

                        <td class="note-cell">

                            {{ $eval->note_ecrite ?? '—' }}

                        </td>


                        {{-- Oral --}}

                        <td class="note-cell">

                            {{ $eval->note_orale ?? '—' }}

                        </td>


                        {{-- Pratique --}}

                        <td class="note-cell">

                            {{ $eval->note_pratique ?? '—' }}

                        </td>


                        {{-- Note finale --}}

                        <td>

                            <span class="note-finale">

                                {{ $eval->note_finale ?? '—' }}

                            </span>

                        </td>


                        {{-- ID --}}

                        <td>

                            <span class="evaluation-id">

                                #{{ $eval->id_evaluation }}

                            </span>

                        </td>


                        {{-- Actions --}}

                        <td class="text-end">

                            <a
                                href="{{ route('evaluations.edit', $eval) }}"
                                class="btn-modifier"
                            >

                                <i class="bi bi-pencil-square me-1"></i>

                                Modifier

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="9"
                            class="empty-evaluations"
                        >

                            <i class="bi bi-clipboard-x fs-4 d-block mb-2"></i>

                            Aucune évaluation trouvée.

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

    <div class="evaluations-pagination">

        {{ $evaluations->links() }}

    </div>

</div>

@endsection