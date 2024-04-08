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
            $table->bigInteger('id_planta')->unsigned();
            $table->bigInteger('id_almacen')->unsigned();
            $table->string('cantidad_inical', 45)->nullable(false);
            $table->string('cantidad_final', 45)->nullable(false);
            $table->datetime('fecha_llenado')->nullable(false);
            $table->timestamps();
            $table->softDeletes();  
            $table->foreign('id_planta')->references('id')->on('planta_gas')->onDelete('no action');
            $table->foreign('id_almacen')->references('id')->on('almacen')->onDelete('no action');
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
