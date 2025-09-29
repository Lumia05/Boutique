@extends('layouts.admin')

@section('title', 'Ajouter un Expert')
@section('page-title', 'Enregistrer un Nouveau Contact Spécialisé')

@section('content')

    <div class="max-w-xl mx-auto">
        
        {{-- Conteneur Principal : Blanc, centré, professionnel --}}
        <div class="p-8 bg-white rounded-xl shadow-lg border-t-4 border-red-600">
            
            <h2 class="text-2xl font-bold text-gray-800 mb-6 pb-4 border-b">
                Ajouter un Expert
            </h2>

            <form action="{{ route('admin.expert_contacts.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    
                    {{-- Nom Complet (OBLIGATOIRE) --}}
                    <div>
                        <label for="name" class="block text-base font-medium text-gray-700">
                            Nom de l'Expert <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" required
                            value="{{ old('name') }}"
                            placeholder="Nom et prénom de l'expert"
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm p-3 focus:ring-red-500 focus:border-red-500"
                        >
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    {{-- Rôle (OBLIGATOIRE) --}}
                    <div>
                        <label for="role" class="block text-base font-medium text-gray-700">
                            Rôle sur le Site <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="role" id="role" required
                            value="{{ old('role') }}"
                            placeholder="Ex: Responsable des Ventes / Support Technique"
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm p-3 focus:ring-red-500 focus:border-red-500"
                        >
                        @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    {{-- --- Séparateur --- --}}
                    <div class="pt-4 border-t border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Coordonnées (Optionnel)</h3>
                    </div>
                    
                    {{-- Numéro de Téléphone --}}
                    <div>
                        <label for="phone" class="block text-base font-medium text-gray-700">
                            Téléphone
                        </label>
                        <input type="text" name="phone" id="phone"
                            value="{{ old('phone') }}"
                            placeholder="+237 690 00 00 00"
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500"
                        >
                        @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    {{-- Lien WhatsApp --}}
                    <div>
                        <label for="whatsapp" class="block text-base font-medium text-gray-700">
                            Lien WhatsApp (URL)
                        </label>
                        <input type="url" name="whatsapp" id="whatsapp"
                            value="{{ old('whatsapp') }}"
                            placeholder="Ex: https://wa.me/xxxxxxxxxxx"
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm p-3 focus:ring-green-600 focus:border-green-600"
                        >
                        @error('whatsapp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- --- Séparateur --- --}}
                    <div class="pt-4 border-t border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Paramètres d'Affichage</h3>
                    </div>
                    
                    {{-- Ordre de Tri --}}
                    <div>
                        <label for="sort_order" class="block text-base font-medium text-gray-700">
                            Ordre de Tri
                        </label>
                        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}"
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('sort_order') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    {{-- Visibilité --}}
                    <div class="flex items-center pt-2">
                        <input id="is_active" name="is_active" type="checkbox" checked
                            class="h-6 w-6 text-red-600 border-gray-300 rounded focus:ring-red-500">
                        <label for="is_active" class="ml-3 block text-base font-medium text-gray-700">
                            Expert **Actif** et **Visible**
                        </label>
                    </div>

                    {{-- Boutons d'Action --}}
                    <div class="pt-6 border-t border-gray-200 flex justify-end space-x-3">
                        <a href="{{ route('admin.expert_contacts.index') }}" 
                            class="py-3 px-6 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 shadow-sm transition duration-150">
                            Annuler
                        </a>
                        <button type="submit" class="py-3 px-6 border border-transparent text-base font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150">
                            Enregistrer l'Expert
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

@endsection