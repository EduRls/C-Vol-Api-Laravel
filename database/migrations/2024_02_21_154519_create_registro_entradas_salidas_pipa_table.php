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
            $table->string('inventario_inical', 45)->nullable(false);
            $table->string('compra', 45)->nullable(false);
            $table->string('venta', 45)->nullable(false);
            $table->string('inventario_final')->nullable(false);
            $table->timestamps();
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
