<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = []; // Pour simplifier, permet la modification de toutes les colonnes

    // Une commande appartient à un client (User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Une commande a plusieurs produits de commande
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}