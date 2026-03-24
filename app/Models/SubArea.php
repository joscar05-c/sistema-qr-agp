<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubArea extends Model
{
    protected $fillable = [
        'area_id',
        'nombre',
        'codigo_interno',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function especialistas(): HasMany
    {
        return $this->hasMany(Especialista::class);
    }
}
