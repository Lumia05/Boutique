<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $peinture = Category::create([
            'name' => 'Peinture',
            'slug' => Str::slug('Peinture')
        ]);

        $membranes = Category::create([
            'name' => 'Membranes',
            'slug' => Str::slug('Membranes')
        ]);

        $chaussures = Category::create([
            'name' => 'Chaussures',
            'slug' => Str::slug('Chaussures')
        ]);

        $casque = Category::create([
            'name' => 'Casque',
            'slug' => Str::slug('Casque')
        ]);

        $gants = Category::create([
            'name' => 'Gants',
            'slug' => Str::slug('Gants')
        ]);

        $botte = Category::create([
            'name' => 'Bottes',
            'slug' => Str::slug('Bottes')
        ]);

        $masque = Category::create([
            'name' => 'Masque',
            'slug' => Str::slug('Masque')
        ]);
        
        // Sous-catégories de Peinture
        Category::create([
            'name' => 'Peinture Décorative',
            'slug' => Str::slug('Peinture Décorative'),
            'parent_id' => $peinture->id
        ]);
        Category::create([
            'name' => 'Peinture à Eau Intérieure',
            'slug' => Str::slug('Peinture à Eau Intérieure'),
            'parent_id' => $peinture->id
        ]);
        Category::create([
            'name'=>'Vernis',
            'slug'=>Str::slug('Vernis'),
            'parent_id'=>$peinture->id
        ]);
        // ... (etc, complétez avec les autres sous-catégories que vous avez)

        // Sous-catégories de Membranes
        Category::create([
            'name' => 'Primaire 15kg',
            'slug' => Str::slug('Primaire 15kg'),
            'parent_id' => $membranes->id
        ]);
        Category::create([
            'name' => 'Sous-couche non-sablées',
            'slug' => Str::slug('Sous-couche non-sablées'),
            'parent_id' => $membranes->id
        ]);
        // ... (etc)
    }
}