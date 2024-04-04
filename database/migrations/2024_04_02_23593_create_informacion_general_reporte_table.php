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
        Schema::create('informacion_general_reporte', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_planta')->unsigned();
            $table->foreign('id_planta')->references('id')->on('planta_gas');
            // RFCs
            $table->string('rfc_contribuyente', 13)->nullable();
            $table->string('rfc_representante_legal', 13)->nullable();
            $table->string('rfc_proveedor', 13)->nullable();
            $table->json('rfc_proveedores')->nullable();
            
            // Características Generales
            $table->string('tipo_caracter')->nullable();
            $table->string('modalidad_permiso')->nullable();
            $table->string('numero_permiso')->nullable();
            $table->string('numero_contrato_asignacion')->nullable();
            $table->string('instalacion_almacen_gas')->nullable();

            // Instalación
            $table->string('clave_instalacion')->nullable();
            $table->text('descripcion_instalacion')->nullable();
            $table->decimal('geolocalizacion_latitud', 10, 7)->nullable();
            $table->decimal('geolocalizacion_longitud', 10, 7)->nullable();
            $table->integer('numero_pozos')->nullable();
            $table->integer('numero_tanques')->nullable();

            // Infraestructura
            $table->integer('numero_ductos_entrada_salida')->nullable();
            $table->integer('numero_ductos_transporte')->nullable();
            $table->integer('numero_dispensarios')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informacion_general_reporte');
    }
};
