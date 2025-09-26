@extends('layouts.admin')

@section('title', 'Créer un Produit')
@section('page-title', 'Ajouter un Nouveau Produit')

@section('content')

    <div class="bg-white p-6 rounded-xl shadow-lg max-w-4xl mx-auto">
        
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nom du Produit <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" required
                        value="{{ old('name') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 p-2"
                        placeholder="Ex: T-Shirt L'Élégant"
                    >
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Catégorie <span class="text-red-500">*</span></label>
                    <select name="category_id" id="category_id" required
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 p-2"
                    >
                        <option value="">-- Sélectionner une Catégorie --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mb-6 md:col-span-2">
                <h3 class="text-lg font-medium text-gray-900 mb-3 border-b pb-2">Variantes (Prix, Promotion, Stock) <span class="text-red-500">*</span></h3>
                
                <div class="grid grid-cols-7 gap-3 mb-2 text-xs font-semibold text-gray-600">
                    <div class="col-span-2">Nom de la Variante</div>
                    <div class="col-span-1">Prix Normal (XAF)</div>
                    <div class="col-span-2">Prix Promotionnel (Optionnel)</div>
                    <div class="col-span-1">Stock</div>
                    <div class="col-span-1"></div> {{-- Pour le bouton supprimer --}}
                </div>

                <div id="variants-container" class="space-y-3">
                    {{-- Boucle pour réafficher les données en cas d'erreur de validation --}}
                    @php
                        $variantsData = old('variant_names') ? 
                            collect(old('variant_names'))->map(function ($name, $key) {
                                return (object) [
                                    'name' => $name, 
                                    'price' => old('variant_prices')[$key], 
                                    'promotion_price' => old('variant_promotion_prices')[$key] ?? null,
                                    'stock' => old('variant_stocks')[$key]
                                ];
                            }) : 
                            collect([(object)['name' => '', 'price' => '', 'promotion_price' => '', 'stock' => '']]); // Ligne par défaut
                    @endphp
                    
                    @foreach ($variantsData as $variant)
                        <div class="variant-row grid grid-cols-7 gap-3 items-center">
                            <div class="col-span-2">
                                <input type="text" name="variant_names[]" value="{{ $variant->name }}" placeholder="Ex: Taille S - Noir" 
                                       class="block w-full border border-gray-300 rounded-lg p-2 text-sm" required>
                            </div>
                            <div class="col-span-1">
                                <input type="number" step="100" min="0" name="variant_prices[]" value="{{ $variant->price }}" placeholder="Prix" 
                                       class="block w-full border border-gray-300 rounded-lg p-2 text-sm" required>
                            </div>
                            <div class="col-span-2">
                                <input type="number" step="100" min="0" name="variant_promotion_prices[]" value="{{ $variant->promotion_price }}" placeholder="Prix Promo" 
                                       class="block w-full border border-gray-300 rounded-lg p-2 text-sm">
                            </div>
                            <div class="col-span-1">
                                <input type="number" min="0" name="variant_stocks[]" value="{{ $variant->stock }}" placeholder="Stock" 
                                       class="block w-full border border-gray-300 rounded-lg p-2 text-sm" required>
                            </div>
                            <div class="col-span-1 text-right">
                                {{-- Affiche le bouton supprimer seulement s'il y a plus d'une ligne OU si le formulaire a été soumis et il y a eu une erreur --}}
                                @if (count($variantsData) > 1 || old('variant_names'))
                                    <button type="button" class="remove-variant text-red-600 hover:text-red-900 text-sm">Supprimer</button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <button type="button" id="add-variant" class="mt-4 px-3 py-1 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition duration-150">
                    + Ajouter une Variante
                </button>

                @error('variant_names.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                @error('variant_prices.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                @error('variant_promotion_prices.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                @error('variant_stocks.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700">Description Détaillée <span class="text-red-500">*</span></label>
                <textarea name="description" id="description" rows="5" required
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 p-2"
                >{{ old('description') }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 items-center">
                <div class="md:col-span-2">
                    <label for="image" class="block text-sm font-medium text-gray-700">Image du Produit (Max 2MB)</label>
                    <input type="file" name="image" id="image" accept="image/*"
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100"
                    >
                    @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center pt-6 md:pt-0">
                    <input id="is_active" name="is_active" type="checkbox" value="1" 
                        {{ old('is_active', true) ? 'checked' : '' }} 
                        class="h-5 w-5 text-red-600 border-gray-300 rounded focus:ring-red-500"
                    >
                    <label for="is_active" class="ml-2 block text-sm font-medium text-gray-700">
                        Produit Actif / Visible
                    </label>
                    @error('is_active') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="pt-4 border-t border-gray-200 flex justify-end">
                <a href="{{ route('admin.products.index') }}" class="px-4 py-2 mr-3 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition duration-150">
                    Annuler
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150">
                    Enregistrer le Produit
                </button>
            </div>
        </form>

    </div>

    {{-- Script JavaScript OBLIGATOIRE pour la gestion dynamique des lignes --}}
    @include('admin.products.variant_script')

@endsection