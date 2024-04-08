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
        Schema::create('almacen', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_planta')->unsigned();
            $table->string('clave_almacen')->nullable(false);
            $table->string('localizacion_descripcion_almacen')->nullable(false);
            $table->string('vigencia_calibracion_tanque')->nullable(false);
            $table->integer('capacidad_almacen')->nullable(false);
            $table->integer('capacidad_operativa')->nullable(false);
            $table->integer('capacidad_util')->nullable(false);
            $table->integer('capacidad_fondaje')->nullable(false);
            $table->integer('volumen_minimo_operacion')->nullable(false);
            $table->string('estado_tanque')->nullable(false);
            $table->softDeletes(); 
            $table->timestamps();

            $table->foreign('id_planta')->references('id')->on('planta_gas')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('almacen');
    }
};
