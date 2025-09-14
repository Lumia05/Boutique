<form action="{{ route('cart.add', $product) }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="quantite" class="form-label">Quantité</label>
        <input type="number" name="quantite" id="quantite" class="form-control" value="1" min="1" required>
    </div>
    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5">
        Ajouter au panier
    </button>
</form>