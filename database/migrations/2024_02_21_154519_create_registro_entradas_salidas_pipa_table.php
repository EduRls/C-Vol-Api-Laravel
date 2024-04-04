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
        Schema::create('registro_entradas_salidas_pipa', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_pipa')->unsigned();
            $table->bigInteger('id_planta')->unsigned();
            $table->string('inventario_inical', 45)->nullable(false);
            $table->string('compra', 45)->nullable(false);
            $table->string('venta', 45)->nullable(false);
            $table->string('inventario_final')->nullable(false);
            $table->timestamps();
            $table->softDeletes();  

            $table->foreign('id_pipa')->references('id')->on('pipa')->onDelete('no action');
            $table->foreign('id_planta')->references('id')->on('planta_gas')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_entradas_salidas_pipa');
    }
};
