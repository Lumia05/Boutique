@extends('layouts.admin')

@section('title', 'Modifier l\'Expert')
@section('page-title', 'Modifier : ' . $expertContact->name)

@section('content')

    <div class="bg-white p-6 rounded-xl shadow-lg max-w-xl mx-auto">
        
        <form action="{{ route('admin.expert_contacts.update', $expertContact) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nom de l'Expert <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" required
                    value="{{ old('name', $expertContact->name) }}"
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 p-2"
                    placeholder="Ex: Jean Dupont"
                >
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700">Rôle (Ex: Support Technique, Ventes)</label>
                <input type="text" name="role" id="role"
                    value="{{ old('role', $expertContact->role) }}"
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 p-2"
                    placeholder="Ex: Responsable des Retours"
                >
                @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700">Numéro de Téléphone (Opt.)</label>
                <input type="text" name="phone" id="phone"
                    value="{{ old('phone', $expertContact->phone) }}"
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 p-2"
                    placeholder="Ex: +237 670 123 456"
                >
                @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="whatsapp" class="block text-sm font-medium text-gray-700">Lien WhatsApp (Opt.)</label>
                <input type="url" name="whatsapp" id="whatsapp"
                    value="{{ old('whatsapp', $expertContact->whatsapp) }}"
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 p-2"
                    placeholder="Ex: https://wa.me/237670123456"
                >
                @error('whatsapp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div class="mb-4">
                    <label for="sort_order" class="block text-sm font-medium text-gray-700">Ordre de Tri</label>
                    <input type="number" min="0" name="sort_order" id="sort_order"
                        value="{{ old('sort_order', $expertContact->sort_order) }}"
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 p-2"
                    >
                    @error('sort_order') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center pt-6">
                    <input id="is_active" name="is_active" type="checkbox" value="1" 
                        {{ old('is_active', $expertContact->is_active) ? 'checked' : '' }} 
                        class="h-5 w-5 text-red-600 border-gray-300 rounded focus:ring-red-500"
                    >
                    <label for="is_active" class="ml-2 block text-sm font-medium text-gray-700">
                        Expert Actif / Visible
                    </label>
                    @error('is_active') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>


            <div class="pt-4 border-t border-gray-200 flex justify-end">
                <a href="{{ route('admin.expert_contacts.index') }}" class="px-4 py-2 mr-3 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition duration-150">
                    Annuler
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150">
                    Mettre à Jour l'Expert
                </button>
            </div>
        </form>

    </div>

@endsection