<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Global Retail Business</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+gbL0oN3wDA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Styles pour les sélections de variantes */
        .variant-option {
            border-width: 2px;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            border-color: #d1d5db; /* gray-300 */
        }
        .variant-option:hover {
            border-color: #ef4444; /* red-500 */
        }
        .variant-option.selected {
            border-color: #ef4444; /* red-500 */
            box-shadow: 0 0 0 3px #fef2f2; /* red-50 */
        }
        .variant-option.opacity-50 {
             cursor: not-allowed;
        }
        
        /* Style pour les cercles de couleur */
        .color-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-800 bg-gray-100">

    <header class="bg-white shadow-md">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="text-3xl font-extrabold text-red-600">Global Retail Business</a>
            <nav class="hidden md:flex space-x-6 text-lg">
                <a href="/produits" class="text-gray-700 hover:text-red-600 transition duration-300">Produits</a>
                <a href="/a-propos" class="text-gray-700 hover:text-red-600 transition duration-300">À propos</a>
                <a href="/contact" class="text-gray-700 hover:text-red-600 transition duration-300">Contact</a>
            </nav>
            <div class="flex items-center space-x-4">
                <div class="relative hidden md:block">
                    <input type="text" placeholder="Rechercher..." class="border border-gray-300 rounded-full py-2 pl-4 pr-10 focus:outline-none focus:ring-2 focus:ring-red-500 text-sm">
                    <button class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-red-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </div>
                <a href="{{ route('cart.index') }}" class="relative text-gray-600 hover:text-red-600">
                    <i class="fas fa-shopping-cart text-2xl"></i>
                    @php
                        $cartCount = count(Session::get('cart', []));
                    @endphp
                    @if($cartCount > 0)
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
                <button class="md:hidden text-gray-600 hover:text-red-600">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-6 py-4">
        <span class="text-gray-500">
            <a href="/produits" class="hover:underline">Produits</a> > {{ $product->name }}
        </span>
    </div>

<main class="container mx-auto mt-4 px-6 py-8 bg-white shadow-lg rounded-lg">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <div class="w-full flex justify-center items-center">
            <img src="{{ asset($product->image ?? 'default-image.jpg') }}" alt="{{ $product->name }}" class="max-w-full h-96 object-contain rounded-lg shadow-xl">
        </div>

        <div>
            <h1 class="text-4xl font-extrabold text-gray-900 mb-2">{{ $product->name }}</h1>
            
            {{-- 🚨 VÉRIFICATION CRITIQUE DU FORMULAIRE --}}
            <form id="product-form" action="{{ route('cart.add') }}" method="POST">
                @csrf 
                <div class="product-info-container">
                    <div class="mb-4">
                        <p id="variant-price" class="text-3xl font-bold text-red-600 mb-2">
                            Sélectionnez une variante
                        </p>
                        <p id="variant-stock" class="text-sm text-gray-500"></p>
                    </div>

                    @php
                        $availableColors = $product->variants->pluck('color')->unique()->filter()->values();
                        $availableSizes = $product->variants->pluck('size')->unique()->filter()->values();
                        $availableWeights = $product->variants->pluck('weight')->unique()->filter()->values();
                        
                        $colorMap = [
                            'rouge' => '#ef4444', 'bleu' => '#3b82f6', 'vert' => '#22c55e', 
                            'jaune' => '#facc15', 'noir' => '#000000', 'blanc' => '#ffffff', 
                            'gris' => '#6b7280', 'marron' => '#7a3b00', 'violet' => '#8b5cf6', 
                            'orange' => '#f97316', 'bleu-ciel' => '#7dd3fc'
                        ];
                    @endphp

                    @if($availableColors->count() > 0)
                        <div class="mb-6">
                            <label class="block text-gray-700 font-semibold mb-2">Couleur :</label>
                            <div id="color-options" class="flex flex-wrap gap-3">
                                @foreach($availableColors as $color)
                                    <div class="color-circle variant-option" 
                                        data-attribute="color" 
                                        data-value="{{ $color }}" 
                                        style="background-color: {{ $colorMap[strtolower($color)] ?? $color }};">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($availableWeights->count() > 0)
                        <div class="mb-6">
                            <label class="block text-gray-700 font-semibold mb-2">Poids :</label>
                            <div id="weight-options" class="flex flex-wrap gap-2">
                                @foreach($availableWeights as $weight)
                                    <div class="variant-option border-2 rounded-lg px-4 py-2 text-sm font-medium" 
                                        data-attribute="weight" 
                                        data-value="{{ $weight }}">
                                        {{ $weight }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($availableSizes->count() > 0)
                        <div class="mb-6">
                            <label class="block text-gray-700 font-semibold mb-2">Taille :</label>
                            <div id="size-options" class="flex flex-wrap gap-2">
                                @foreach($availableSizes as $size)
                                    <div class="variant-option border-2 rounded-lg px-4 py-2 text-sm font-medium" 
                                        data-attribute="size" 
                                        data-value="{{ $size }}">
                                        {{ $size }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    <div class="flex items-center space-x-4 mb-6 mt-6">
                        <label for="quantity" class="text-gray-700 font-semibold">Quantité :</label>
                        <input type="number" name="quantity" id="quantity" value="1" min="1" max="100" class="border border-gray-300 rounded-lg py-2 px-4 w-24 text-center focus:outline-none focus:ring-2 focus:ring-red-500" disabled>
                    </div>

                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <input type="hidden" name="variant_id" id="variant-id"> 
                    
                    <button type="submit" id="add-to-cart-btn" class="bg-red-600 text-white font-bold py-3 px-8 rounded-full shadow-lg hover:bg-red-700 transition duration-300" disabled>
                        Ajouter au panier
                    </button>
                </div>
            </form>
            {{-- FIN DE LA SECTION CRITIQUE DU FORMULAIRE --}}

            <h2 class="text-xl font-bold text-red-600 mb-2 mt-8">Description du produit</h2>
            <p class="text-gray-700 mb-6 leading-relaxed">{!! nl2br(e($product->description)) !!}</p>

            <div class="mt-12">
                <h3 class="font-bold text-2xl text-gray-800 mb-4">Informations techniques et de sécurité</h3>
                <p class="text-gray-700 mb-6 leading-relaxed">{!! nl2br(e($product->technical_info)) !!}</p>
            </div>
        </div>
    </div>
</main>
<footer class="bg-gray-800 text-white text-center py-6 mt-12">
    <p>&copy; 2025 Global Retail Business. Tous droits réservés.</p>
</footer>

<script>
    const variants = @json($product->variants);
    const priceDisplay = document.getElementById('variant-price');
    const stockDisplay = document.getElementById('variant-stock');
    const quantityInput = document.getElementById('quantity');
    const addToCartBtn = document.getElementById('add-to-cart-btn');
    const variantIdInput = document.getElementById('variant-id');
    const form = document.getElementById('product-form');

    // État actuel des sélections
    let selectedAttributes = {
        color: null,
        size: null,
        weight: null
    };

    // Éléments du DOM pour chaque type de variante
    const attributeContainers = {
        color: document.getElementById('color-options'),
        size: document.getElementById('size-options'),
        weight: document.getElementById('weight-options'),
    };
    
    // Déterminer le nombre exact d'attributs qui DOIVENT être sélectionnés pour ce produit
    const requiredAttributes = Object.keys(attributeContainers).filter(key => attributeContainers[key]).length;


    function updateUI() {
        const selectedCount = Object.values(selectedAttributes).filter(Boolean).length;
        
        let exactVariant = variants.find(variant => {
             const colorMatch = selectedAttributes.color === null || variant.color === selectedAttributes.color;
             const sizeMatch = selectedAttributes.size === null || variant.size === selectedAttributes.size;
             const weightMatch = selectedAttributes.weight === null || variant.weight === selectedAttributes.weight;
             
             return colorMatch && sizeMatch && weightMatch;
        });

        if (exactVariant && exactVariant.stock > 0 && selectedCount === requiredAttributes) {
            
            const price = exactVariant.promotion_price || exactVariant.price;
            priceDisplay.innerHTML = `
                <p class="text-3xl font-bold text-red-600 mb-2">${price.toLocaleString('fr-FR')} FCFA</p>
                ${exactVariant.promotion_price ? `<p class="text-xl text-gray-500 line-through mb-1">${exactVariant.price.toLocaleString('fr-FR')} FCFA</p>` : ''}
            `;
            stockDisplay.textContent = `Stock disponible: ${exactVariant.stock}`;
            
            quantityInput.max = exactVariant.stock;
            quantityInput.disabled = false;
            addToCartBtn.disabled = false;
            variantIdInput.value = exactVariant.id;
            
        } else {
            priceDisplay.textContent = 'Sélectionnez une variante';
            stockDisplay.textContent = '';
            quantityInput.disabled = true;
            addToCartBtn.disabled = true;
            variantIdInput.value = '';
        }

        Object.keys(attributeContainers).forEach(attr => {
            if (attributeContainers[attr]) {
                updateOptionAvailability(attr);
            }
        });
    }

    function updateOptionAvailability(currentAttribute) {
        const container = attributeContainers[currentAttribute];
        if (!container) return;

        container.querySelectorAll('.variant-option').forEach(option => {
            const tempSelected = { ...selectedAttributes, [currentAttribute]: option.dataset.value };
            
            const isAvailable = variants.some(variant =>
                (tempSelected.color === null || variant.color === tempSelected.color) &&
                (tempSelected.size === null || variant.size === tempSelected.size) &&
                (tempSelected.weight === null || variant.weight === tempSelected.weight)
                && variant.stock > 0
            );

            if (isAvailable) {
                option.classList.remove('opacity-50', 'pointer-events-none');
            } else {
                option.classList.add('opacity-50', 'pointer-events-none');
            }
            
            if (option.classList.contains('opacity-50') && option.classList.contains('selected')) {
                 selectedAttributes[currentAttribute] = null;
                 option.classList.remove('selected');
                 updateUI();
            }
        });
    }

    function handleOptionClick(event) {
        const selectedElement = event.currentTarget;
        const attribute = selectedElement.dataset.attribute;
        const value = selectedElement.dataset.value;

        if (selectedAttributes[attribute] === value) {
            selectedAttributes[attribute] = null;
            selectedElement.classList.remove('selected');
        } else {
            const groupOptions = document.querySelectorAll(`[data-attribute="${attribute}"]`);
            groupOptions.forEach(option => option.classList.remove('selected'));
            selectedAttributes[attribute] = value;
            selectedElement.classList.add('selected');
        }

        updateUI();
    }

    // Attacher les écouteurs d'événements
    document.querySelectorAll('.variant-option').forEach(option => {
        option.addEventListener('click', handleOptionClick);
    });

    // ÉCOUTEUR CRITIQUE : VÉRIFIER QU'AUCUN ÉVÉNEMENT NE BLOQUE LA SOUMISSION
    form.addEventListener('submit', function(e) {
        // Optionnel : un dernier contrôle JavaScript si nécessaire, mais NE PAS utiliser e.preventDefault() ici.
        // Si addToCartBtn est disabled, le formulaire ne devrait pas être soumis.
        if (addToCartBtn.disabled) {
            e.preventDefault();
            alert('Veuillez sélectionner une variante disponible.');
        }
    });

    updateUI();
</script>