@extends('layouts.admin')

@section('title', 'Gestion des Experts')
@section('page-title', 'Liste des Contacts Spécialisés')

@section('content')

    {{-- Message de Succès --}}
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded shadow-md" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- ======================================================= --}}
    {{-- TABLEAU DE GESTION DES EXPERTS --}}
    {{-- ======================================================= --}}
    <div class="p-6 bg-white rounded-lg shadow-xl border-t-4 border-red-600">
        <div class="border-b pb-3 mb-6 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Experts Actuels</h2>
            {{-- Bouton pour ajouter un expert --}}
            <a href="{{ route('admin.expert_contacts.create') }}" 
               class="py-2 px-4 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150">
                Ajouter un Expert
            </a>
        </div>

        <div class="overflow-x-auto border rounded-lg shadow-sm">
            @if ($experts->isEmpty())
                <div class="text-center py-10 text-gray-500">
                    <p class="mb-2">Aucun expert n'a été ajouté.</p>
                    <p class="text-sm">Ajoutez votre premier expert pour le rendre visible sur la page contact.</p>
                </div>
            @else
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom & Rôle</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ordre</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($experts as $expert)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $expert->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $expert->role }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="block font-medium">{{ $expert->phone }}</span>
                                    @if ($expert->whatsapp)
                                        <a href="{{ $expert->whatsapp }}" target="_blank" class="text-green-600 hover:text-green-800 text-xs font-medium flex items-center mt-0.5">
                                            WhatsApp
                                        </a>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">{{ $expert->sort_order }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $expert->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $expert->is_active ? 'Actif' : 'Inactif' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.expert_contacts.edit', $expert) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Modifier</a>
                                    
                                    <form action="{{ route('admin.expert_contacts.destroy', $expert) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet expert ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

@endsection