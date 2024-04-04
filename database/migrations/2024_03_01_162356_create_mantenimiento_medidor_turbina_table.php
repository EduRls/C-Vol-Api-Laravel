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
        Schema::create('mantenimiento_medidor_turbina', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_medidor')->unsigned();
            $table->foreign('id_medidor')->references('id')->on('medidor_turbina')->onDelete('no action');
            $table->bigInteger('id_planta')->unsigned();
            $table->foreign('id_planta')->references('id')->on('planta_gas')->onDelete('no action');
            $table->string('tipo_mantenimiento')->nullable(false);
            $table->string('responsable')->nullable(false);
            $table->string('estado')->nullable(false);
            $table->string('observaciones')->nullable(false);
            $table->timestamps();
            $table->softDeletes();         
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mantenimiento_medidor_turbina');
    }
};
