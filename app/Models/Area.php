<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Area extends Model
{
    protected $fillable = [
        'nombre',
        'siglas',
        'descripcion',
        'color',
        'icono',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function subAreas(): HasMany
    {
        return $this-> hasMany(SubArea::class);
    }

    public function especialistas(): HasManyThrough
    {
        return $this-> hasManyThrough(Especialista::class, SubArea::class);
    }
}
