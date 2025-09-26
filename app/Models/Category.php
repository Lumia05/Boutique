<?php
namespace App\Models;

use App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Assurez-vous que parent_id est dans fillable pour les formulaires
    protected $fillable = ['name', 'slug', 'description', 'parent_id']; 

    // Relations de base
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Relation : Produits directement attachés à cette catégorie
    public function products()
    {
        return $this->hasMany(Products::class);
    }

    /**
     * Accesseur qui calcule le nombre total de produits (directs + enfants récursifs).
     *
     * @return int
     */
    public function getTotalProductsCountAttribute(): int
    {
        // Utiliser le count_cache si possible pour les produits directs (si withCount('products') est utilisé)
        $count = $this->products_count ?? $this->products->count();

        // 2. Ajouter le compte des produits de chaque enfant (récursion)
        foreach ($this->children as $child) {
            // Appel récursif de l'accesseur pour chaque enfant
            $count += $child->total_products_count; 
        }

        return $count;
    }
}