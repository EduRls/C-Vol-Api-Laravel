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
        Schema::create('informacion_medidor', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_medidor')->unsigned();
            $table->json('informacion_medidor');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('id_medidor')->references('id')->on('medidor_turbina')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informacion_medidor');
    }
};
