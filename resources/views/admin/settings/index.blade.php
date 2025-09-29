@extends('layouts.admin')

@section('title', 'Paramètres Généraux')
@section('page-title', 'Configuration de la Boutique et Horaires')

@section('content')

    {{-- Message de Succès --}}
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded shadow-md" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    
    
    {{-- ======================================================= --}}
    {{-- 1. INFORMATIONS GÉNÉRALES (Lecture Seule / Formulaire) --}}
    {{-- ======================================================= --}}
    <div class="mb-8 p-6 bg-white rounded-lg shadow-xl border-t-4 border-indigo-600">
        <div class="border-b pb-3 mb-6 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Paramètres du Site et du Responsable</h2>
            
            {{-- BOUTON D'ACTIVATION DU FORMULAIRE (Affiché par défaut) --}}
            <a href="#" 
                {{-- Logique JavaScript/Alpine pour afficher le formulaire --}}
               onclick="document.getElementById('settings-form-container').classList.remove('hidden'); document.getElementById('settings-display-container').classList.add('hidden'); this.classList.add('hidden'); return false;"
               class="py-2 px-4 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150" id="edit-settings-btn">
                Modifier les Infos Générales
            </a>
        </div>
        
        {{-- CONTENEUR D'AFFICHAGE LECTURE SEULE --}}
        <div id="settings-display-container">
            <div class="space-y-6">
                
                {{-- Affichage : Informations du Responsable --}}
                <div class="p-4 border border-gray-100 rounded-md">
                    <h3 class="text-lg font-semibold text-gray-700 mb-3">Coordonnées du Responsable</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        
                        <div>
                            <p class="text-sm font-medium text-gray-500">Email Destinataire :</p>
                            <p class="text-lg text-gray-900 font-medium">{{ $settings['shop_email'] ?? 'Non défini' }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm font-medium text-gray-500">Téléphone Principal :</p>
                            <p class="text-lg text-gray-900 font-medium">{{ $settings['shop_phone'] ?? 'Non défini' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Affichage : Horaires de Travail --}}
                <div class="p-4 border border-gray-100 rounded-md">
                    <h3 class="text-lg font-semibold text-gray-700 mb-3">Horaires (Ouverture et Fermeture)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        
                        <div>
                            <p class="text-sm font-medium text-gray-500">Heure d'Ouverture :</p>
                            <p class="text-lg text-gray-900 font-medium">{{ $settings['shop_opening_time'] ?? 'Non défini' }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Heure de Fermeture :</p>
                            <p class="text-lg text-gray-900 font-medium">{{ $settings['shop_closing_time'] ?? 'Non défini' }}</p>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        
        {{-- CONTENEUR DU FORMULAIRE (Caché par défaut) --}}
        <div id="settings-form-container" class="hidden">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                @method('PUT') 

                <div class="space-y-6">
                    
                    {{-- Formulaire : Coordonnées du Responsable --}}
                    <div class="p-4 border border-gray-100 rounded-md bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-700 mb-3">Modification des Coordonnées</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            
                            <div>
                                <label for="shop_email" class="block text-sm font-medium text-gray-700">Email Destinataire <span class="text-red-500">*</span></label>
                                <input type="email" name="shop_email" id="shop_email" required
                                    value="{{ old('shop_email', $settings['shop_email'] ?? '') }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500"
                                >
                                @error('shop_email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            
                            <div>
                                <label for="shop_phone" class="block text-sm font-medium text-gray-700">Téléphone Principal <span class="text-red-500">*</span></label>
                                <input type="text" name="shop_phone" id="shop_phone" required
                                    value="{{ old('shop_phone', $settings['shop_phone'] ?? '') }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500"
                                >
                                @error('shop_phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Formulaire : Horaires de Travail --}}
                    <div class="p-4 border border-gray-100 rounded-md bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-700 mb-3">Modification des Horaires</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            
                            <div>
                                <label for="shop_opening_time" class="block text-sm font-medium text-gray-700">Heure d'Ouverture <span class="text-red-500">*</span></label>
                                <input type="time" name="shop_opening_time" id="shop_opening_time" required
                                    value="{{ old('shop_opening_time', $settings['shop_opening_time'] ?? '') }}" 
                                    class="mt-1 block w-full border-gray-300 rounded-md p-2 focus:ring-indigo-500 focus:border-indigo-500">
                                @error('shop_opening_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="shop_closing_time" class="block text-sm font-medium text-gray-700">Heure de Fermeture <span class="text-red-500">*</span></label>
                                <input type="time" name="shop_closing_time" id="shop_closing_time" required
                                    value="{{ old('shop_closing_time', $settings['shop_closing_time'] ?? '') }}" 
                                    class="mt-1 block w-full border-gray-300 rounded-md p-2 focus:ring-indigo-500 focus:border-indigo-500">
                                @error('shop_closing_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Boutons d'Action (Enregistrer / Annuler) --}}
                    <div class="pt-4 flex justify-end space-x-3">
                         <a href="#" onclick="document.getElementById('settings-form-container').classList.add('hidden'); document.getElementById('settings-display-container').classList.remove('hidden'); document.getElementById('edit-settings-btn').classList.remove('hidden'); return false;"
                            class="py-2 px-4 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition duration-150 shadow-sm">
                            Annuler
                        </a>
                        <button type="submit" class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 shadow-md">
                            Enregistrer les Modifications Générales
                        </button>
                    </div>
                    
                </div>
            </form>
        </div>
        
    </div>

@endsection