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
        Schema::create('m_turbinas', function (Blueprint $table) {
            $table->id();
            $table->string('modelo_equipo', 100);
            $table->string('rango_flujo', 100);
            $table->string('rango_temperatura', 100);
            $table->string('numero_serie', 100);
            $table->string('precision');
            $table->string('suministro_energia');
            $table->string('salida_modelo');
            $table->string('fecha');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_turbinas');
    }
};
