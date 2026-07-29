<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sidebar ORMVASM</title>

    <style>
        .sidebar {
            width: 260px;
            height: calc(100vh - 75px);
            background: var(--white);
            border-right: 1px solid var(--border);
            position: fixed;
            left: 0;
            top: 70px;
            bottom: 0;
            overflow-y: auto;
        }

        .menu {
            list-style: none;
            padding: 25px 15px;
            margin: 0;
        }

        .menu li {
            margin-bottom: 8px;
        }

        .menu li a {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 13px 18px;
            text-decoration: none;
            color: var(--text-light);
            border-radius: 12px;
            font-size: 15px;
            font-weight: 500;
            transition: .3s;
        }

        .menu li a i {
            font-size: 20px;
        }

        .menu li a:hover {
            background: var(--green-light);
            color: var(--green);
        }

        .menu li.active a {
            background: var(--green);
            color: var(--white);
        }

        /* Déconnexion */
        .logout-link {
            color: #DC2626 !important;
        }

        .logout-link:hover {
            color: #B91C1C !important;
            background: #FEE2E2 !important;
        }

        .main {
            margin-left: 260px;
            width: calc(100% - 260px);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 80px;
            }

            .menu li a span {
                display: none;
            }

            .main {
                margin-left: 80px;
                width: calc(100% - 80px);
            }
        }
    </style>
</head>

<body>
@php
    $profil = session('user')->profil ?? '';

    $admin = $profil === 'Administrateur';
    $serviceRH = $profil === 'RH';
    $commission = $profil === 'Commission';
    $responsableService = $profil === 'Responsable de service';
    $consultation = $profil === 'Consultation';
@endphp
<aside class="sidebar">

    <ul class="menu">

        <li class="{{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
            <a href="{{ route('dashboard.index') }}">
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="{{ request()->routeIs('offres.index') ? 'active' : '' }}">
            <a href="{{ route('offres.index') }}">
                <i class="bi bi-briefcase-fill"></i>
                <span>Offres</span>
            </a>
        </li>

        <li class="{{ request()->routeIs('candidats.index') ? 'active' : '' }}">
            <a href="{{ route('candidats.index') }}">
                <i class="bi bi-people-fill"></i>
                <span>Candidats</span>
            </a>
        </li>

        <li class="{{ request()->routeIs('candidatures.index') ? 'active' : '' }}">
            <a href="{{ route('candidatures.index') }}">
                <i class="bi bi-file-earmark-text-fill"></i>
                <span>Candidatures</span>
            </a>
        </li>
         @if($admin || $serviceRH || $commission)
        <li class="{{ request()->routeIs('documents.index') ? 'active' : '' }}">
            <a href="{{ route('documents.index') }}">
                <i class="bi bi-folder-fill"></i>
                <span>Documents</span>
            </a>
        </li>
        @endif
        @if($admin || $serviceRH || $commission)
        <li class="{{ request()->routeIs('convocations.index') ? 'active' : '' }}">
            <a href="{{ route('convocations.index') }}">
                <i class="bi bi-calendar-event-fill"></i>
                <span>Convocations</span>
            </a>
        </li>
        @endif
        @if($admin || $serviceRH || $commission || $responsableService)
        <li class="{{ request()->routeIs('evaluations.index') ? 'active' : '' }}">
            <a href="{{ route('evaluations.index') }}">
                <i class="bi bi-star-fill"></i>
                <span>Évaluation</span>
            </a>
        </li>
        @endif
        @if($admin || $serviceRH || $commission)
        <li class="{{ request()->routeIs('admis.index') ? 'active' : '' }}">
            <a href="{{ route('admis.index') }}">
                <i class="bi bi-trophy-fill"></i>
                <span>Résultats</span>
            </a>
        </li>
        @endif
        @if($admin)
        <li class="{{ request()->routeIs('utilisateurs.index') ? 'active' : '' }}">
            <a href="{{ route('utilisateurs.index') }}">
                <i class="bi bi-person-fill"></i>
                <span>Utilisateurs</span>
            </a>
        </li>
        @endif
        @if($admin)
        <li class="{{ request()->routeIs('historique.index') ? 'active' : '' }}">
            <a href="{{ route('historique.index') }}">
                <i class="bi bi-clock-history"></i>
                <span>Historique</span>
            </a>
        </li>
         @endif
         @if($admin)
        <li class="{{ request()->routeIs('parametres.index') ? 'active' : '' }}">
            <a href="{{ route('parametres.index') }}">
                <i class="bi bi-gear-fill"></i>
                <span>Paramètres</span>
            </a>
        </li>
        @endif
        <!-- DÉCONNEXION -->
        <li>
            <a href="#"
               class="logout-link"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

                <i class="bi bi-box-arrow-right"></i>
                <span>Déconnexion</span>

            </a>

            <form id="logout-form"
                  action="{{ route('logout') }}"
                  method="POST"
                  style="display: none;">

                @csrf

            </form>
        </li>

    </ul>

</aside>

</body>
</html>