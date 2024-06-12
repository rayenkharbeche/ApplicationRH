<!-- resources/views/dashboard_user.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
</head>
<body>
    <h2>Dashboard - User</h2>
    @if(session('message'))
        <p>{{ session('message') }}</p>
    @endif
    <p>Bienvenue, {{ Auth::user()->prenom }} {{ Auth::user()->nom }}</p>
    
    <!-- Ajoutez ici le contenu spécifique à l'utilisateur -->

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
