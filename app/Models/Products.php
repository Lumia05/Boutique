<?php
// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'reference',
        'description',
        'category_id',
        'features',
        'image',
        'technical_info',
    ];

    protected $casts = [
        'features' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    
    public function variants(): HasMany
    {
        // Laravel déduira automatiquement que la clé étrangère est "product_id"
        return $this->hasMany(ProductVariant::class);
    }
}