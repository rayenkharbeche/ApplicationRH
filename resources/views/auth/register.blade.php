<!-- resources/views/auth/register.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
</head>
<body>
    <h2>Inscription</h2>
    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p style="color: red;">{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required><br><br>
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required><br><br>
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required readonly><br><br>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required><br><br>
        <label for="password_confirmation">Confirmer le mot de passe :</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required><br><br>
        <label for="role">Rôle :</label>
        <select id="role" name="role" required>
            <option value="admin">Administrateur</option>
            <option value="user">Utilisateur</option>
        </select><br><br>
        <label for="birthdate">Date de naissance :</label>
        <input type="date" id="birthdate" name="birthdate" required><br><br>
        <label for="adresse">Adresse :</label>
        <input type="text" id="adresse" name="adresse" required><br><br>
        <label for="telephone">Téléphone :</label>
        <input type="tel" id="telephone" name="telephone" required pattern="^\+\d{1,3}\d{9,15}$" title="Format international (ex: +123456789012)"><br><br>
        <label for="family_situation">Situation familiale :</label>
        <select id="family_situation" name="family_situation" required>
            <option value="célibataire">Célibataire</option>
            <option value="marié(e)">Marié(e)</option>
            <option value="divorcé(e)">Divorcé(e)</option>
            <option value="veuf(ve)">Veuf(ve)</option>
        </select><br><br>
        <label for="number_of_children">Nombre d'enfants :</label>
        <input type="number" id="number_of_children" name="number_of_children" min="0" required><br><br>
        <input type="submit" value="S'inscrire">
    </form>

    <script>
    const nomInput = document.getElementById('nom');
    const prenomInput = document.getElementById('prenom');
    const emailInput = document.getElementById('email');

    nomInput.addEventListener('input', generateEmail);
    prenomInput.addEventListener('input', generateEmail);

    function generateEmail() {
        const nom = nomInput.value;
        const prenom = prenomInput.value;
        const email = `${prenom}.${nom}@csi-corporation.com`;
        emailInput.value = email;
    }
</script>
</body>
</html>
