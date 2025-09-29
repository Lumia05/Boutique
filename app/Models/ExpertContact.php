<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpertContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
        'phone',
        'whatsapp',
        'is_active',
        'sort_order',
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
    ];
}