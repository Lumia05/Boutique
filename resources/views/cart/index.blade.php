@extends('layouts.cart')

@section('title', 'Mon Panier')

@section('content')
<main class="container mx-auto mt-4 px-6 py-8">
    <h1 class="text-4xl font-extrabold text-gray-900 mb-6">Mon Panier</h1>

    @if(Session::has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ Session::get('success') }}</span>
        </div>
    @endif

    @if(Session::has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ Session::get('error') }}</span>
        </div>
    @endif

    @if(empty($cart))
        <p class="text-center text-gray-600 text-lg">Votre panier est vide.</p>
    @else
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="hidden md:grid grid-cols-7 gap-4 font-semibold border-b pb-2 mb-4 text-sm">
                <div class="col-span-2">Produit</div>
                <div class="text-center">Attributs</div>
                <div class="text-center">Prix unitaire</div>
                <div class="text-center">Quantité</div>
                <div class="text-center">Sous-total</div>
                <div class="text-right">Actions</div>
            </div>

            @foreach($cart as $item)
                <div class="grid grid-cols-1 md:grid-cols-7 gap-4 items-center border-b py-4">
                    <div class="col-span-1 md:col-span-2 flex items-center space-x-4">
                        <img src="{{ asset($item['image'] ?? 'default-image.jpg') }}" alt="{{ $item['name'] }}" class="w-20 h-20 object-cover rounded-lg">
                        <span class="font-medium text-gray-900">{{ $item['name'] }}</span>
                    </div>

                    <div class="text-center flex flex-col items-center justify-center text-xs space-y-1">
                        @if($item['color'])
                            <p class="font-bold">Couleur: <span style="color: {{ strtolower($item['color']) }};">{{ $item['color'] }}</span></p>
                        @endif
                        @if($item['size'])
                            <p class="font-bold">Taille: {{ $item['size'] }}</p>
                        @endif
                        @if($item['weight'])
                            <p class="font-bold">Poids: {{ $item['weight'] }}</p>
                        @endif
                    </div>
                    
                    <div class="text-center">
                        @if(isset($item['promotion_price']) && $item['promotion_price'] !== null)
                            <p class="text-lg font-bold text-red-600">
                                {{ number_format($item['promotion_price'], 0, ',', '.') }} FCFA
                            </p>
                            <p class="text-sm text-gray-500 line-through">
                                {{ number_format($item['price'], 0, ',', '.') }} FCFA
                            </p>
                        @else
                            <p class="text-lg font-bold text-gray-800">
                                {{ number_format($item['price'], 0, ',', '.') }} FCFA
                            </p>
                        @endif
                    </div>
                    
                    <div class="text-center">
                        <form action="{{ route('cart.update', ['rowId' => $item['rowId']]) }}" method="POST" class="flex items-center justify-center">
                            @csrf
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-16 text-center border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 text-sm">
                            <button type="submit" class="bg-blue-500 text-white p-2 rounded-md ml-2 hover:bg-blue-600 text-sm">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </form>
                    </div>

                    <div class="text-center">
                        <span class="text-lg font-bold text-gray-900">
                            {{ number_format(($item['promotion_price'] ?? $item['price']) * $item['quantity'], 0, ',', '.') }} FCFA
                        </span>
                    </div>

                    <div class="text-right">
                        <form action="{{ route('cart.remove', ['rowId' => $item['rowId']]) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-white bg-red-600 hover:bg-red-700 font-semibold py-2 px-4 rounded-full transition duration-300 text-sm">
                                Retirer
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
            
            <div class="flex justify-end items-center mt-6">
                <span class="text-2xl font-bold text-gray-900">Total : {{ number_format($total, 0, ',', '.') }} FCFA</span>
            </div>

            <div class="flex justify-end mt-4 space-x-4">
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-gray-300 text-gray-800 font-bold py-2 px-6 rounded-full hover:bg-red-400 transition duration-300">
                        Vider le panier
                    </button>
                </form>
                    <a href="{{ route('checkout.index') }}" class="bg-red-600 text-white font-bold py-2 px-6 rounded-full shadow-lg hover:bg-green-700 transition duration-300">
                        Passer la commande
                    </a>
            </div>
        </div>
    @endif
</main>
@endsection





