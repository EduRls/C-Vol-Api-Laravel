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
        Schema::create('registro_llenado_almacen', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_contenedor', 100)->nullable(false);
            $table->string('cantidad_inical', 45)->nullable(false);
            $table->string('cantidad_final', 45)->nullable(false);
            $table->datetime('fecha_llenado')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_llenado_almacen');
    }
};
