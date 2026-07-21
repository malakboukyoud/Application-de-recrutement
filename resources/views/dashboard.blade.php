<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>

    <h1>Bienvenue {{ session('user')->nom }}</h1>

    <p>Vous êtes connecté au système ORMVASM.</p>

    <a href="{{ route('logout') }}">Déconnexion</a>

</body>
</html>