<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Gestion Recrutement') — ORMVASM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#f5f6f8; }
        .navbar-brand small { display:block; font-size:.7rem; opacity:.8; }
        .badge-etat { font-size:.8rem; }
        table.table-hover tbody tr { cursor: pointer; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            ORMVASM <small>Gestion des candidatures de recrutement</small>
        </a>
        <div class="navbar-nav">
            <a class="nav-link {{ request()->routeIs('candidatures.*') ? 'fw-bold text-white' : 'text-white-50' }}"
               href="{{ route('candidatures.index') }}">Candidatures</a>
            <a class="nav-link {{ request()->routeIs('candidats.*') ? 'fw-bold text-white' : 'text-white-50' }}"
               href="{{ route('candidats.index') }}">Candidats</a>
            <a class="nav-link {{ request()->routeIs('historique.*') ? 'fw-bold text-white' : 'text-white-50' }}"
               href="{{ route('historique.index') }}">Historique</a>
        </div>
    </div>
</nav>

<div class="container my-4">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
