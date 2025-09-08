{{-- Le formulaire d'édition pour la modale --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="reference" class="form-label">Référence</label>
            <input type="text" class="form-control" id="reference" name="reference" value="{{ old('reference', $product->reference) }}">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="category_id" class="form-label">Catégorie</label>
            <select class="form-select" id="category_id" name="category_id" required>
                <option value="">Sélectionner une catégorie</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="price" class="form-label">Prix (FCFA)</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}" required>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="quantite" class="form-label">Quantité en stock</label>
            <input type="number" class="form-control" id="quantite" name="quantite" value="{{ old('quantite', $product->quantite) }}" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="color" class="form-label">Couleur</label>
            <input type="text" class="form-control" id="color" name="color" value="{{ old('color', $product->color) }}">
        </div>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Image du produit</label>
        <input type="file" class="form-control" id="image" name="image">
        @if ($product->image)
            <small class="form-text text-muted mt-2">Image actuelle :</small>
            <div class="mt-2">
                <img src="{{ asset('storage/' . $product->image) }}" alt="Image du produit" class="img-thumbnail" style="max-height: 150px;">
            </div>
        @endif
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
    </div>

    <div class="mb-3">
        <label for="features" class="form-label">Caractéristiques (séparées par une virgule)</label>
        <textarea class="form-control" id="features" name="features" rows="3">{{ old('features', $product->features) }}</textarea>
    </div>

    <div class="mb-3">
        <label for="recommended_use" class="form-label">Usage recommandé</label>
        <textarea class="form-control" id="recommended_use" name="recommended_use" rows="3">{{ old('recommended_use', $product->recommended_use) }}</textarea>
    </div>

    <div class="mb-4">
        <label for="technical_info" class="form-label">Informations techniques</label>
        <textarea class="form-control" id="technical_info" name="technical_info" rows="3">{{ old('technical_info', $product->technical_info) }}</textarea>
    </div>

    <div class="d-grid mt-4">
        <button type="submit" class="btn btn-warning btn-lg">Mettre à jour le produit</button>
    </div>
</form>