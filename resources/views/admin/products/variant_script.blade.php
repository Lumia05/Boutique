<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('variants-container');
        const addButton = document.getElementById('add-variant');
        
        // Fonction pour créer une ligne de variante (utilise une grille de 14 colonnes)
        function createVariantRow() {
            const row = document.createElement('div');
            // La classe CSS doit correspondre à la grille (grid-cols-14) et la taille minimale (min-w-[1200px])
            row.className = 'variant-row grid grid-cols-14 gap-3 items-center min-w-[1200px]'; 
            row.innerHTML = `
                <div class="col-span-2">
                    <input type="text" name="variant_sizes[]" placeholder="Taille (Ex: S, XL, 42)" 
                           class="block w-full border border-gray-300 rounded-lg p-2 text-sm" required>
                </div>
                <div class="col-span-1">
                    <input type="text" name="variant_colors[]" placeholder="Couleur" 
                           class="block w-full border border-gray-300 rounded-lg p-2 text-sm">
                </div>
                <div class="col-span-1">
                    <input type="text" name="variant_weights[]" placeholder="Poids" 
                           class="block w-full border border-gray-300 rounded-lg p-2 text-sm">
                </div>
                <div class="col-span-1">
                    <input type="number" step="100" min="0" name="variant_prices[]" placeholder="Prix Normal" 
                           class="block w-full border border-gray-300 rounded-lg p-2 text-sm" required>
                </div>
                <div class="col-span-1">
                    <input type="number" step="100" min="0" name="variant_promotion_prices[]" placeholder="Prix Promo" 
                           class="block w-full border border-gray-300 rounded-lg p-2 text-sm">
                </div>
                <div class="col-span-3">
                    <input type="date" name="variant_promo_start_dates[]" placeholder="Début Promo" 
                           class="block w-full border border-gray-300 rounded-lg p-2 text-sm">
                </div>
                <div class="col-span-3">
                    <input type="date" name="variant_promo_end_dates[]" placeholder="Fin Promo" 
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

        // Supprimer une ligne
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