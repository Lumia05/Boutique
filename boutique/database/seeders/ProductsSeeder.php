<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Products;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupération des IDs des catégories créées par le CategorySeeder
        $chaussuresId = Category::where('name', 'UVEX')->first()->id;
        $casqueId = Category::where('name', 'Casque')->first()->id;
        $peintureId = Category::where('name', 'Vernis')->first()->id;

        // Création des produits et attribution de leur category_id
        Products::create([
            'name' => 'iPhone 15 Pro',
            'description' => 'Le dernier smartphone d\'Apple avec un appareil photo incroyable.',
            'price' => 1200.00,
            'image' => 'images/iphone-15.png',
            'category_id' => $chaussuresId,
        ]);

        Products::create([
            'name' => 'PC Portable XPS 15',
            'description' => 'Un ordinateur portable puissant pour la Productsivité et la création de contenu.',
            'price' => 1500.00,
            'image' => 'images/xps-15.png',
            'category_id' => $casqueId
        ]);

        Products::create([
            'name' => 'Livre sur Laravel',
            'description' => 'Apprenez à développer des applications web avec le framework Laravel.',
            'price' => 35.50,
            'image' => 'images/laravel-book.png',
            'category_id' => $peintureId
        ]);

        Products::create([
            'name' => 'Casque de chantier Pro',
            'description' => 'Casque de sécurité haute résistance en polyéthylène, avec ventilation et ajustement rapide. Idéal pour tous les travaux de construction et d\'industrie.',
            'reference' => 'CAS-PR-001',
            'price' => 45.50,
            'image' => 'images/casque-pro.png',
            'category_id' => 1, // Remplacez par le bon ID de catégorie
            'color' => 'rouge,blanc,bleu',
            
            'features' => 'Coque en polyéthylène HD|Harnais textile 6 points|Molette de serrage pour ajustement rapide',
            'recommended_use' => 'Protection de la tête sur les chantiers de construction, dans l\'industrie et les travaux publics.',
            'technical_info' => 'Norme: EN 397:2012 + A1:2012|Poids: 400g|Couleur: Blanc|Durée de vie: 5 ans',
            'quantite'=>15
        ]);
        // Vous pouvez ajouter d'autres produits ici
    }
}