<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la Commande - Admin</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+gbL0oN3wDA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="font-sans antialiased text-gray-800 bg-gray-100">

    <header class="bg-white shadow-md">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="text-3xl font-extrabold text-red-600">Global Retail Business</a>
            <nav class="hidden md:flex space-x-6 text-lg">
                <a href="{{ route('admin.orders.index') }}" class="text-gray-700 hover:text-red-600 transition duration-300">Commandes</a>
                <a href="{{ route('admin.users.index') }}" class="text-gray-700 hover:text-red-600 transition duration-300">Utilisateurs</a>
            </nav>
        </div>
    </header>

    <main class="container mx-auto px-6 py-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-6">Détails de la Commande #{{ $order->id }}</h1>
        
        <div class="bg-white shadow-lg rounded-lg p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h2 class="text-2xl font-bold mb-4">Informations du client</h2>
                    <p class="mb-2"><strong>Nom :</strong> {{ $order->customer_name }}</p>
                    <p class="mb-2"><strong>Email :</strong> {{ $order->customer_email }}</p>
                    <p class="mb-2"><strong>Téléphone :</strong> {{ $order->customer_phone }}</p>
                    <p class="mb-2"><strong>Adresse :</strong> {{ $order->customer_address }}</p>
                    <p class="mb-2"><strong>Date de la commande :</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>

                <div>
                    <h2 class="text-2xl font-bold mb-4">Statut de la commande</h2>
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Changer le statut :</label>
                            <select name="status" id="status" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="en cours" {{ $order->status == 'en cours' ? 'selected' : '' }}>En cours</option>
                                <option value="validée" {{ $order->status == 'validée' ? 'selected' : '' }}>Validée</option>
                                <option value="rejetée" {{ $order->status == 'rejetée' ? 'selected' : '' }}>Rejetée</option>
                            </select>
                        </div>
                        <button type="submit" class="bg-red-600 text-white font-bold py-2 px-6 rounded-full shadow-lg hover:bg-red-700 transition duration-300">
                            Mettre à jour
                        </button>
                    </form>
                </div>
            </div>

            <div class="mt-8">
                <h2 class="text-2xl font-bold mb-4">Articles de la commande</h2>
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Produit
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Quantité
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Prix unitaire
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Total
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $item->product->name }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $item->quantity }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ number_format($item->price, 2, ',', ' ') }} FCFA</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ number_format($item->price * $item->quantity, 2, ',', ' ') }} FCFA</p>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-right mt-4">
                    <p class="text-lg font-bold">Total des produits : {{ number_format($order->total_price, 2, ',', ' ') }} FCFA</p>
                    <p class="text-lg font-bold text-green-700">Frais de livraison : 2,000 FCFA</p>
                    <p class="text-2xl font-bold mt-2">Total général : {{ number_format($order->total_price + 2000, 2, ',', ' ') }} FCFA</p>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-gray-800 text-white text-center py-6 mt-12">
        <p>&copy; 2025 Global Retail Business. Tous droits réservés.</p>
    </footer>

</body>
</html>