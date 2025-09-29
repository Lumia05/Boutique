<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $primaryKey = 'key';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['key', 'value'];

    /**
     * Récupère la valeur d'un paramètre par sa clé.
     */
    public static function getValue(string $key): ?string
    {
        // Utilise le cache pour une meilleure performance
        return cache()->rememberForever("setting_{$key}", function () use ($key) {
            return static::find($key)->value ?? null;
        });
    }
    
    /**
     * Met à jour ou crée un paramètre et vide le cache.
     */
    public static function setValue(string $key, string $value): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
        // Oublier la clé du cache
        cache()->forget("setting_{$key}");
    }
}