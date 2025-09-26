<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Administration - Global Retail Business</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-200 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md">
        
        <h1 class="text-4xl font-extrabold text-center text-gray-800 mb-6">
            Admin <span class="text-red-600">GRB</span>
        </h1>
        
        <div class="bg-white p-8 rounded-xl shadow-2xl border-t-4 border-red-600">
            
            <h2 class="text-2xl font-semibold text-gray-700 mb-6 text-center">Connexion Administrateur</h2>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">
                            {{ $errors->first('email') }}
                        </span>
                    </div>
                @endif

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Adresse Email</label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus 
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 @error('email') border-red-500 @enderror"
                    >
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        required 
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500"
                    >
                </div>

                <div>
                    <button 
                        type="submit" 
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-lg font-medium text-white bg-gray-800 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-300"
                    >
                        Se connecter
                    </button>
                </div>
            </form>
            
            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-red-600 transition duration-300">
                    ← Retour à la boutique
                </a>
            </div>

        </div>
    </div>

</body>
</html>