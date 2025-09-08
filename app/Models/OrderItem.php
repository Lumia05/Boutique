<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Un produit de commande appartient à une commande
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Un produit de commande appartient à un produit
    public function product()
    {
        return $this->belongsTo(Products::class);
    }
}