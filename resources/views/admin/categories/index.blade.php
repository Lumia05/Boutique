@extends('admin.layout')

@section('title', 'Gestion des catégories')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.categories.create') }}" class="btn btn-danger">Ajouter une catégorie</a>
        <form method="GET" action="{{ route('admin.categories.index') }}" class="d-flex" style="gap:.5rem;">
            <input type="text" name="q" value="{{ $search ?? '' }}" class="form-control" placeholder="Rechercher (nom ou parent)" />
            <button type="submit" class="btn btn-outline-danger">Rechercher</button>
            @if(!empty($search ?? ''))
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Réinitialiser</a>
            @endif
        </form>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-danger text-white">
                        <tr>
                            <th scope="col">Nom</th>
                            <th scope="col" class="text-center">Nombre de produits</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>
                                    {{ $category->name }}
                                    @if($category->parent)
                                        <small class="text-muted d-block">Parent: {{ $category->parent->name }}</small>
                                    @endif
                                </td>
                                <td class="text-center">{{ $category->products_count }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <button 
                                            type="button"
                                            class="btn btn-warning btn-sm me-2"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editCategoryModal"
                                            data-category-id="{{ $category->id }}">
                                            Modifier
                                        </button>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">Supprimer</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="d-flex justify-content-center mt-4">
        {{ $categories->withQueryString()->links('pagination::bootstrap-5') }}
    </div>

        <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Modifier une categorie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="categoryEditFormLoader" class="text-center py-5">
                        <div class="spinner-border text-danger" role="status">
                            <span class="visually-hidden">Chargement...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var editCategoryModal = document.getElementById('editCategoryModal');
        editCategoryModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var categoryId = button.getAttribute('data-category-id');

            var modalBody = editCategoryModal.querySelector('.modal-body');
            modalBody.innerHTML = `
                <div id="categoryEditFormLoader" class="text-center py-5">
                    <div class="spinner-border text-danger" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                </div>
            `;

            fetch(`/admin/categories/${categoryId}/edit-modal`)
                .then(response => response.text())
                .then(html => {
                    modalBody.innerHTML = html;
                })
                .catch(error => {
                    console.error('Erreur lors du chargement du formulaire:', error);
                    modalBody.innerHTML = '<div class="alert alert-danger">Impossible de charger le formulaire.</div>';
                });
        });
    });
</script>
@endsection