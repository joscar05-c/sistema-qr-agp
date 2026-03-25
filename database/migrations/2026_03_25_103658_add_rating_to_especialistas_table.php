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
        Schema::table('especialistas', function (Blueprint $table) {
            $table->unsignedInteger('total_estrellas')->default(0);
            $table->unsignedInteger('numero_votos')->default(0);
            $table->decimal('promedio_rating', 3, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('especialistas', function (Blueprint $table) {
            //
        });
    }
};
