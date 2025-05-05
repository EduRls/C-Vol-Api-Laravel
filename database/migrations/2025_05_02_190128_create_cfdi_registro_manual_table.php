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
        Schema::create('cfdi_registro_manual', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 36);
            $table->enum('tipo_cfdi', ['compra', 'venta', 'traslado']);
            $table->string('rfc_emisor', 13);
            $table->string('rfc_receptor', 13);
            $table->decimal('volumen_litros', 10, 2);
            $table->decimal('importe_total', 12, 2);
            $table->dateTime('fecha_hora_operacion');
            $table->text('observaciones')->nullable();
            $table->timestamps();
    
            // Relación con tabla de plantas si aplica
            //$table->foreign('id_planta')->references('id')->on('plantas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cfdi_registro_manual');
    }
};
