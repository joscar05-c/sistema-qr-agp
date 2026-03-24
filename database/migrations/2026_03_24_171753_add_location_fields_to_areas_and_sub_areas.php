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
        // Agregamos el piso al Área principal
        Schema::table('areas', function (Blueprint $table) {
            $table->string('piso', 50)->nullable()->after('siglas')->comment('Ej: Piso 1, Piso 2');
        });

        // Agregamos la oficina/referencia a la Sub Área
        Schema::table('sub_areas', function (Blueprint $table) {
            $table->string('oficina', 100)->nullable()->after('nombre')->comment('Ej: Oficina 304, Ventanilla 2');
        });
    }

    public function down(): void
    {
        Schema::table('areas', function (Blueprint $table) {
            $table->dropColumn('piso');
        });

        Schema::table('sub_areas', function (Blueprint $table) {
            $table->dropColumn('oficina');
        });
    }
};
