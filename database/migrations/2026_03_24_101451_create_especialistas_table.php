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
        Schema::create('especialistas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_area_id')->constrained()->onDelete('cascade');

            // Datos Personales
            $table->string('nombre_completo');
            $table->string('dni', 8)->unique();
            $table->string('foto')->nullable(); // Ruta del archivo en storage

            // Contacto
            $table->string('correo')->unique();
            $table->string('celular', 15);
            $table->string('anexo', 10)->nullable(); // Por si tienen teléfono fijo en oficina

            // Perfil Profesional
            $table->string('cargo'); // Ej: Especialista en Convivencia Escolar
            $table->text('especialidad'); // Breve descripción de qué temas maneja
            $table->text('horario_atencion')->nullable(); // Importante para el QR

            // Redes/Social (Opcional pero útil para el QR)
            $table->string('linkedin_url')->nullable();
            $table->string('facebook_url')->nullable();

            // Control de Sistema
            $table->string('slug')->unique(); // Para una URL bonita: gofastdelivery.site/v/juan-perez
            $table->boolean('is_visible')->default(true); // Para ocultar a alguien sin borrarlo
            $table->integer('orden')->default(0); // Para ordenar quién sale primero en la lista

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('especialistas');
    }
};
