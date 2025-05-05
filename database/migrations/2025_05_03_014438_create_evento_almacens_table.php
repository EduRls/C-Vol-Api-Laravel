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
        Schema::create('eventos_almacen', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_almacen')->unsigned();
            $table->enum('tipo_evento', ['entrada', 'salida']);
            $table->float('volumen_inicial', 8, 2);
            $table->float('volumen_movido', 8, 2);
            $table->float('volumen_final', 8, 2);
            $table->datetime('fecha_inicio_evento');
            $table->datetime('fecha_fin_evento');
            $table->float('temperatura', 5, 2)->nullable();
            $table->float('presion_absoluta', 6, 2)->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->foreign('id_almacen')->references('id')->on('almacen')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evento_almacens');
    }
};
