@extends('layouts.admin')

@section('title', 'Modifier la Catégorie')
@section('page-title', 'Modifier : ' . $category->name)

@section('content')

    <div class="bg-white p-6 rounded-xl shadow-lg max-w-lg mx-auto">
        
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label for="name" class="block text-sm font-medium text-gray-700">Nom de la Catégorie <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" required
                    value="{{ old('name', $category->name) }}"
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 p-2"
                    placeholder="Ex: Électronique, Vêtements pour hommes"
                >
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label for="parent_id" class="block text-sm font-medium text-gray-700">Catégorie Parente (Optionnel)</label>
                <select name="parent_id" id="parent_id"
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 p-2"
                >
                    <option value="">-- Aucune (Catégorie Principale) --</option>
                    
                    {{-- Boucle utilisant la variable $parentCategories --}}
                    @foreach ($parentCategories as $parentCategory)
                        
                        {{-- On empêche qu'une catégorie soit sa propre parente --}}
                        @if ($parentCategory->id != $category->id)
                            <option value="{{ $parentCategory->id }}" 
                                {{ 
                                    (old('parent_id') == $parentCategory->id) || 
                                    ($category->parent_id == $parentCategory->id && old('parent_id') === null) 
                                    ? 'selected' : '' 
                                }}
                            >
                                {{ $parentCategory->name }}
                            </option>
                        @endif
                    @endforeach
                    
                </select>
                @error('parent_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
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