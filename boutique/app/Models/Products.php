<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'reference',
        'price',
        'image',
        'category_id',
        'color',
        'features',
        'recommended_use',
        'technical_info',
    ];

    protected $casts = [
        'features' => 'array',
        'technical_info' => 'array',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}