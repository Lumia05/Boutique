<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="name" class="form-label">Nom du produit</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" required>
    </div>
    
    <div class="mb-3">
        <label for="price" class="form-label">Prix</label>
        <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}" required>
    </div>

    <div class="mb-3">
        <label for="quantite" class="form-label">Quantité en stock</label>
        <input type="number" class="form-control" id="quantite" name="quantite" value="{{ old('quantite', $product->quantite) }}" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
    </div>

    <div class="mb-3">
        <label for="technical_info" class="form-label">Informations techniques (séparées par un |)</label>
        <textarea class="form-control" id="technical_info" name="technical_info" rows="3">{{ old('technical_info', $product->technical_info) }}</textarea>
    </div>
    
    <div class="mb-3">
        <label for="hex_colors" class="form-label">Couleurs Hex (séparées par une virgule)</label>
        <input type="text" class="form-control" id="hex_colors" name="hex_colors" value="{{ old('hex_colors', $product->hex_colors) }}">
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Image du produit</label>
        <input class="form-control" type="file" id="image" name="image">
        @if($product->image)
            <img src="{{ asset($product->image) }}" alt="Image actuelle" class="mt-2" style="width: 100px;">
        @endif
    </div>
    
    <hr class="my-4">

    <h5 class="fw-bold">Gérer les promotions</h5>
    <div class="mb-3">
        <label for="promotion_price" class="form-label">Prix de promotion</label>
        <input type="number" class="form-control" id="promotion_price" name="promotion_price" value="{{ old('promotion_price', $product->promotion_price) }}">
    </div>

    <div class="mb-3">
        <label for="promotion_start_date" class="form-label">Date de début de promotion</label>
        <input type="datetime-local" class="form-control" id="promotion_start_date" name="promotion_start_date" value="{{ old('promotion_start_date', $product->promotion_start_date) }}">
    </div>

    <div class="mb-3">
        <label for="promotion_end_date" class="form-label">Date de fin de promotion</label>
        <input type="datetime-local" class="form-control" id="promotion_end_date" name="promotion_end_date" value="{{ old('promotion_end_date', $product->promotion_end_date) }}">
    </div>



    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" class="btn btn-success">Enregistrer les modifications</button>
    </div>
</form>