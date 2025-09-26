<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Products;
use App\Models\ProductVariant;

class ProductVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $peinture = Products::where('reference', 'PA-001')->first();
        if ($peinture) {
            ProductVariant::create(['products_id' => $peinture->id, 'color' => 'Rouge', 'price' => 25000, 'stock' => 50, 'weight' => '10kg']);
            ProductVariant::create(['products_id' => $peinture->id, 'color' => 'Gris', 'price' => 25500, 'stock' => 45, 'weight' => '10kg']);
            ProductVariant::create(['products_id' => $peinture->id, 'color' => 'Rouge', 'price' => 45000, 'stock' => 30, 'weight' => '20kg']);
        }
        
        $membrane = Products::where('reference', 'MP-001')->first();
        if ($membrane) {
            ProductVariant::create(['products_id' => $membrane->id, 'size' => '1m x 10m', 'price' => 75000, 'stock' => 20]);
            ProductVariant::create(['products_id' => $membrane->id, 'size' => '1m x 20m', 'price' => 140000, 'stock' => 15]);
        }
        
        $gants = Products::where('reference', 'GS-001')->first();
        if ($gants) {
            ProductVariant::create(['products_id' => $gants->id, 'size' => 'M', 'price' => 5000, 'stock' => 100, 'color' => 'Bleu']);
            ProductVariant::create(['products_id' => $gants->id, 'size' => 'L', 'price' => 5500, 'stock' => 80, 'color' => 'Bleu']);
            ProductVariant::create(['products_id' => $gants->id, 'size' => 'XL', 'price' => 6000, 'stock' => 60, 'color' => 'Noir']);
        }
        
        $casque = Products::where('reference', 'CC-001')->first();
        if ($casque) {
            ProductVariant::create(['products_id' => $casque->id, 'color' => 'Jaune', 'price' => 10000, 'stock' => 40]);
            ProductVariant::create(['products_id' => $casque->id, 'color' => 'Blanc', 'price' => 10500, 'stock' => 35]);
        }
    }
}