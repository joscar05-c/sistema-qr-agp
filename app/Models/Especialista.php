<?php

namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Especialista extends Model
{
    protected $fillable = [
        'sub_area_id',
        'nombre_completo',
        'dni',
        'foto',
        'correo',
        'celular',
        'anexo',
        'cargo',
        'especialidad',
        'horario_atencion',
        'linkedin_url',
        'facebook_url',
        'slug',
        'is_visible',
        'orden'
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'orden' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($especialista) {
            $especialista->slug = Str::slug($especialista->nombre_completo . '-' . $especialista->dni);
        });
    }

    public function subArea(): BelongsTo
    {
        return $this->belongsTo(SubArea::class);
    }

    public function getPublicUrlAttribute(): string
    {
        return "https://info-personal.gofastdelivery.site/v/" . $this->slug;
    }

    public function getImageUrlAttribute(): string
    {
        return $this->foto
            ? Storage::url($this->foto)
            : "https://ui-avatars.com/api/?name=" . urlencode($this->nombre_completo) . "&color=7F9CF5&background=EBF4FF";
    }

    public function getWhatsappUrlAttribute(): string
    {
        $phone = preg_replace('/[^0-9]/', '', $this->celular);
        return "https://wa.me/51" . $phone;
    }
}
