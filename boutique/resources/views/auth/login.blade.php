<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <div style="width: 400px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">
        <h2>Connexion à l'administration</h2>
        
        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <label for="email">Adresse Email</label><br>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>
            <br>
            <div>
                <label for="password">Mot de passe</label><br>
                <input type="password" id="password" name="password" required>
            </div>
            <br>
            <div>
                <button type="submit">Se connecter</button>
            </div>
        </form>
    </div>
</body>
</html>