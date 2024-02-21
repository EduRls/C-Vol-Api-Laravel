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
        Schema::create('pipa', function (Blueprint $table) {
            $table->id();
            $table->string('responsable_pipa', 100)->nullable(false);
            $table->integer('capacidad_pipa')->nullable(false);
            $table->string('clave_pipa', 100)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pipa');
    }
};
