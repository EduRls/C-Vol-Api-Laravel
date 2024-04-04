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
        Schema::create('medidor_turbina', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_planta')->unsigned();
            $table->string('modelo_equipo', 100);
            $table->string('rango_flujo', 45);
            $table->string('rango_temperatura', 45);
            $table->string('numero_serie', 45);
            $table->string('precision', 100);
            $table->string('suministro_energia', 45);
            $table->string('salida_modelo', 45);
            $table->string('fecha', 50);
            $table->timestamps();  
            
            $table->foreign('id_planta')->references('id')->on('planta_gas');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medidor_turbina');
    }
};
