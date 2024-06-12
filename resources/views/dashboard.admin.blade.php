<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
</head>
<body>
    <h2>Dashboard - Admin</h2>
    <p>Bienvenue sur le tableau de bord de l'administrateur.</p>
    
    <!-- Ajoutez ici le contenu spécifique à l'administrateur -->

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
