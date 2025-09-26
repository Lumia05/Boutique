<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('variants-container');
        const addButton = document.getElementById('add-variant');
        
        // Fonction pour créer une ligne de variante (mise à jour pour 7 colonnes)
        function createVariantRow() {
            const row = document.createElement('div');
            row.className = 'variant-row grid grid-cols-7 gap-3 items-center';
            row.innerHTML = `
                <div class="col-span-2">
                    <input type="text" name="variant_names[]" placeholder="Ex: Taille M - Bleu" 
                           class="block w-full border border-gray-300 rounded-lg p-2 text-sm" required>
                </div>
                <div class="col-span-1">
                    <input type="number" step="100" min="0" name="variant_prices[]" placeholder="Prix" 
                           class="block w-full border border-gray-300 rounded-lg p-2 text-sm" required>
                </div>
                <div class="col-span-2">
                    <input type="number" step="100" min="0" name="variant_promotion_prices[]" placeholder="Prix Promo" 
                           class="block w-full border border-gray-300 rounded-lg p-2 text-sm">
                </div>
                <div class="col-span-1">
                    <input type="number" min="0" name="variant_stocks[]" placeholder="Stock" 
                           class="block w-full border border-gray-300 rounded-lg p-2 text-sm" required>
                </div>
                <div class="col-span-1 text-right">
                    <button type="button" class="remove-variant text-red-600 hover:text-red-900 text-sm">Supprimer</button>
                </div>
            `;
            container.appendChild(row);
        }

        // Ajouter une nouvelle ligne
        addButton.addEventListener('click', createVariantRow);

        // Supprimer une ligne (événement délégué sur le conteneur)
        container.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-variant')) {
                const currentRowCount = container.querySelectorAll('.variant-row').length;
                
                // On s'assure qu'il reste au moins une variante
                if (currentRowCount > 1) {
                    e.target.closest('.variant-row').remove();
                } else {
                    alert("Un produit doit avoir au moins une variante.");
                }
            }
        });
    });
</script>