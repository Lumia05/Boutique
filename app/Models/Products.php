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
        'quantite',
        'promotion_price',
        'promotion_start_date',
        'promotion_end_date', 
    ];

    protected $casts = [];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    
}