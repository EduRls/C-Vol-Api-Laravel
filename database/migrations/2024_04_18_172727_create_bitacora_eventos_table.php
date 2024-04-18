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
        Schema::create('bitacora_eventos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_planta')->unsigned();
            $table->foreign('id_planta')->references('id')->on('planta_gas');

            $table->string('NumeroRegistro')->nullable();
            $table->string('FechaYHoraEvento')->nullable();
            $table->string('UsuarioResponsable')->nullable();
            $table->string('TipoEvento')->nullable();
            $table->string('DescripcionEvento')->nullable();
            $table->string('IdentificacionComponenteAlarma')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacora_eventos');
    }
};
