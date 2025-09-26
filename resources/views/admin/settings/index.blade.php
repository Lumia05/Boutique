@extends('layouts.admin')

@section('title', 'Paramètres & Contacts')
@section('page-title', 'Gestion des Contacts et Informations Générales')

@section('content')

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-md" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.settings.store') }}" method="POST">
        @csrf
        
        <div class="space-y-10">
            
            <div class="bg-white p-6 rounded-xl shadow-lg border-t-4 border-red-500">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Expert N°1 (Contact Principal)</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    
                    <div>
                        <label for="expert1_name" class="block text-sm font-medium text-gray-700">Nom Complet</label>
                        <input type="text" name="expert1_name" id="expert1_name" 
                            value="{{ old('expert1_name', $setting->expert1_name ?? '') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 p-2"
                        >
                        @error('expert1_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="expert1_email" class="block text-sm font-medium text-gray-700">Adresse Email</label>
                        <input type="email" name="expert1_email" id="expert1_email" 
                            value="{{ old('expert1_email', $setting->expert1_email ?? '') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 p-2"
                        >
                        @error('expert1_email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="expert1_phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                        <input type="text" name="expert1_phone" id="expert1_phone" 
                            value="{{ old('expert1_phone', $setting->expert1_phone ?? '') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 p-2"
                        >
                        @error('expert1_phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="expert1_expertise" class="block text-sm font-medium text-gray-700">Catégorie d'Expertise</label>
                        <input type="text" name="expert1_expertise" id="expert1_expertise" 
                            value="{{ old('expert1_expertise', $setting->expert1_expertise ?? '') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 p-2"
                            placeholder="Ex: Support Technique"
                        >
                        @error('expert1_expertise') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border-t-4 border-blue-500">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Expert N°2 (Contact Secondaire)</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    
                    <div>
                        <label for="expert2_name" class="block text-sm font-medium text-gray-700">Nom Complet</label>
                        <input type="text" name="expert2_name" id="expert2_name" 
                            value="{{ old('expert2_name', $setting->expert2_name ?? '') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                        >
                        @error('expert2_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="expert2_email" class="block text-sm font-medium text-gray-700">Adresse Email</label>
                        <input type="email" name="expert2_email" id="expert2_email" 
                            value="{{ old('expert2_email', $setting->expert2_email ?? '') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                        >
                        @error('expert2_email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="expert2_phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                        <input type="text" name="expert2_phone" id="expert2_phone" 
                            value="{{ old('expert2_phone', $setting->expert2_phone ?? '') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                        >
                        @error('expert2_phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="expert2_expertise" class="block text-sm font-medium text-gray-700">Catégorie d'Expertise</label>
                        <input type="text" name="expert2_expertise" id="expert2_expertise" 
                            value="{{ old('expert2_expertise', $setting->expert2_expertise ?? '') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                            placeholder="Ex: Suivi de Commande"
                        >
                        @error('expert2_expertise') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border-t-4 border-green-500">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Informations Générales de la Boutique</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    
                    <div>
                        <label for="opening_time" class="block text-sm font-medium text-gray-700">Heure d'Ouverture (HH:MM)</label>
                        <input type="time" name="opening_time" id="opening_time" 
                            value="{{ old('opening_time', $setting->opening_time ? \Carbon\Carbon::parse($setting->opening_time)->format('H:i') : '') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 p-2"
                        >
                        @error('opening_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="closing_time" class="block text-sm font-medium text-gray-700">Heure de Fermeture (HH:MM)</label>
                        <input type="time" name="closing_time" id="closing_time" 
                            value="{{ old('closing_time', $setting->closing_time ? \Carbon\Carbon::parse($setting->closing_time)->format('H:i') : '') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 p-2"
                        >
                        @error('closing_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="closing_days" class="block text-sm font-medium text-gray-700">Jours de Fermeture (Ex: Samedi, Dimanche)</label>
                        <input type="text" name="closing_days" id="closing_days" 
                            value="{{ old('closing_days', $setting->closing_days ?? '') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 p-2"
                            placeholder="Ex: Samedi, Dimanche"
                        >
                        @error('closing_days') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="footer_text" class="block text-sm font-medium text-gray-700">Texte du Pied de Page (Footer)</label>
                    <textarea name="footer_text" id="footer_text" rows="3"
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 p-2"
                        placeholder="Ex: Tous droits réservés à Global Retail Business."
                    >{{ old('footer_text', $setting->footer_text ?? '') }}</textarea>
                    @error('footer_text') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

        </div>

        <div class="mt-8 pt-4 border-t">
            <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-base font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-300">
                Enregistrer tous les Paramètres
            </button>
        </div>
    </form>
    
@endsection