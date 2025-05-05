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
        Schema::create('existencias_almacen', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_almacen')->unsigned();
            $table->float('volumen_existencia', 8, 2);
            $table->datetime('fecha_medicion');
            $table->timestamps();

            $table->foreign('id_almacen')->references('id')->on('almacen')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('existencia_almacens');
    }
};
