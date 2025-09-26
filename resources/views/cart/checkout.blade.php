@extends('layouts.cart')

@section('title', 'Confirmation de la Commande')

@section('content')
<main class="container mx-auto mt-4 px-6 py-8">
    <h1 class="text-4xl font-extrabold text-gray-900 mb-6">Confirmer la Commande</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Erreur de validation !</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $total=0;
        foreach($cart as $item){
            $total += ($item['promotion_price'] ?? $item['price']) * $item['quantity'];
        }
    @endphp

    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Récapitulatif de la Commande</h2>
        <div class="border-b border-gray-200 pb-4 mb-4">
            @foreach($cart as $item)
                <div class="flex items-center justify-between py-2">
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900">{{ $item['name'] }}</p>
                            <p class="text-sm text-gray-500">
                                Quantité : {{ $item['quantity'] }}
                                @if(isset($item['color'])) - {{ $item['color'] }}@endif
                                @if(isset($item['size'])) - {{ $item['size'] }}@endif
                            </p>
                        </div>
                    </div>
                    <div>
                        @if(isset($item['promotion_price']) && $item['promotion_price'] !== null)
                            <p class="font-bold text-red-600">{{ number_format($item['promotion_price'] * $item['quantity'], 0, ',', '.') }} FCFA</p>
                        @else
                            <p class="font-bold text-gray-800">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} FCFA</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <div class="flex justify-end items-center text-xl font-bold text-gray-900">
            <span>Total : {{ number_format($total, 0, ',', '.') }} FCFA</span>
        </div>
    </div>
    
    <div class="bg-white shadow-lg rounded-lg p-6 mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Informations de Facturation & Livraison</h2>
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nom complet</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm" required>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Adresse e-mail</label>
                    <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Numéro de téléphone</label>
                    <input type="tel" name="phone" id="phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm" required>
                </div>
            </div>

            <div class="mt-6">
                <h3 class="text-lg font-medium text-gray-900">Option de livraison</h3>
                <div class="mt-2 space-y-4">
                    <div class="flex items-center">
                        <input id="delivery-home" name="delivery_option" type="radio" value="home" class="focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300" required>
                        <label for="delivery-home" class="ml-3 block text-sm font-medium text-gray-700">
                            Livraison à domicile (+2000 FCFA)
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input id="delivery-store" name="delivery_option" type="radio" value="store" class="focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300" required>
                        <label for="delivery-store" class="ml-3 block text-sm font-medium text-gray-700">
                            Retrait en magasin (Gratuit)
                        </label>
                    </div>
                </div>
            </div>

            <div id="delivery-address-container" class="mt-6 hidden">
                <h3 class="text-lg font-medium text-gray-900">Adresse de livraison</h3>
                <div class="mt-2 grid grid-cols-1 gap-6">
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Adresse</label>
                        <input type="text" name="address" id="address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                    </div>
                </div>
            </div>
            
            <div class="mt-6">
                <button type="submit" class="w-full bg-red-600 text-white font-bold py-3 rounded-full hover:bg-red-700 transition duration-300">
                    Finaliser la Commande
                </button>
            </div>
        </form>
    </div>
</main>

<script>
    const deliveryHome = document.getElementById('delivery-home');
    const deliveryStore = document.getElementById('delivery-store');
    const deliveryAddressContainer = document.getElementById('delivery-address-container');
    const addressInput = document.getElementById('address');

    function toggleAddressFields() {
        if (deliveryHome.checked) {
            deliveryAddressContainer.classList.remove('hidden');
            addressInput.setAttribute('required', 'required');
        } else {
            deliveryAddressContainer.classList.add('hidden');
            addressInput.removeAttribute('required');
        }
    }

    deliveryHome.addEventListener('change', toggleAddressFields);
    deliveryStore.addEventListener('change', toggleAddressFields);

    toggleAddressFields();
</script>
@endsection