@extends('admin.layout')

@section('title', '')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <h1 class="h3 text-danger fw-bold">Ajouter un nouveau produit</h1>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fas fa-arrow-left me-2"></i> Retour à la liste
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger shadow-sm rounded-3">
            <h5 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i> Erreurs de validation</h5>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-5">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-bold text-dark">Nom du produit <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="reference" class="form-label fw-bold text-dark">Référence</label>
                        <input type="text" class="form-control form-control-lg @error('reference') is-invalid @enderror" id="reference" name="reference" value="{{ old('reference') }}">
                        @error('reference') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="category_id" class="form-label fw-bold text-dark">Catégorie <span class="text-danger">*</span></label>
                        <select class="form-select form-select-lg @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                            <option value="">Sélectionner une catégorie</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="price" class="form-label fw-bold text-dark">Prix (FCFA) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control form-control-lg @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required>
                        @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="quantite" class="form-label fw-bold text-dark">Quantité en stock <span class="text-danger">*</span></label>
                        <input type="number" class="form-control form-control-lg @error('quantite') is-invalid @enderror" id="quantite" name="quantite" value="{{ old('quantite', 0) }}" required>
                        @error('quantite') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="color" class="form-label fw-bold text-dark">Couleur</label>
                        <input type="text" class="form-control form-control-lg @error('color') is-invalid @enderror" id="color" name="color" value="{{ old('color') }}">
                        @error('color') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="image" class="form-label fw-bold text-dark">Image du produit</label>
                    <input type="file" class="form-control form-control-lg @error('image') is-invalid @enderror" id="image" name="image">
                    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label fw-bold text-dark">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{ old('description') }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label for="features" class="form-label fw-bold text-dark">Caractéristiques (séparées par une virgule)</label>
                    <textarea class="form-control @error('features') is-invalid @enderror" id="features" name="features" rows="4">{{ old('features') }}</textarea>
                    @error('features') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label for="recommended_use" class="form-label fw-bold text-dark">Usage recommandé</label>
                    <textarea class="form-control @error('recommended_use') is-invalid @enderror" id="recommended_use" name="recommended_use" rows="4">{{ old('recommended_use') }}</textarea>
                    @error('recommended_use') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-5">
                    <label for="technical_info" class="form-label fw-bold text-dark">Informations techniques</label>
                    <textarea class="form-control @error('technical_info') is-invalid @enderror" id="technical_info" name="technical_info" rows="4">{{ old('technical_info') }}</textarea>
                    @error('technical_info') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-danger btn-lg px-5 rounded-pill shadow-sm">
                        <i class="fas fa-plus-circle me-2"></i> Créer le produit
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection