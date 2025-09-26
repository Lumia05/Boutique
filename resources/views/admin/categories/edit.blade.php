@extends('layouts.admin')

@section('title', 'Modifier la Catégorie')
@section('page-title', 'Modifier : ' . $category->name)

@section('content')

    <div class="bg-white p-6 rounded-xl shadow-lg max-w-2xl mx-auto">
        
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label for="name" class="block text-sm font-medium text-gray-700">Nom de la Catégorie <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" required
                    value="{{ old('name', $category->name) }}"
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 p-2"
                    placeholder="Ex: Équipements de Protection Individuelle"
                >
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div class="mb-5">
                <label for="parent_id" class="block text-sm font-medium text-gray-700">Catégorie Parent (Optionnel)</label>
                <select name="parent_id" id="parent_id" 
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                >
                    <option value="">-- Aucune (Catégorie Principale) --</option>
                    @foreach ($parentCategories as $parent)
                        {{-- IMPORTANT : Empêche une catégorie d'être son propre parent --}}
                        @if ($parent->id !== $category->id)
                            <option value="{{ $parent->id }}" 
                                {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
                @error('parent_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700">Description (Optionnel)</label>
                <textarea name="description" id="description" rows="3"
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 p-2"
                >{{ old('description', $category->description) }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4 border-t border-gray-200 flex justify-end">
                <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 mr-3 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition duration-150">
                    Annuler
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150">
                    Mettre à Jour la Catégorie
                </button>
            </div>
        </form>

    </div>

@endsection