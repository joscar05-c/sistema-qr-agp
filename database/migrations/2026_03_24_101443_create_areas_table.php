<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Ej: Area de Gestión Pedagógica
            $table->string('siglas')->unique(); // Ej: AGP
            $table->string('descripcion')->nullable();
            $table->string('color')->default('#3b82f6'); // Para usar en etiquetas de la UI
            $table->string('icono')->nullable(); // Nombre de icono (Heroicons)
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('areas');
    }
};
