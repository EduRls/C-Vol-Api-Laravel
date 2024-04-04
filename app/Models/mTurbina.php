<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mTurbina extends Model
{
    use HasFactory;

    protected $table = "medidor_turbina";

    protected $fillable = [
        'id_planta',
        'modelo_equipo', 
        'rango_flujo',
        'rango_temperatura',
        'numero_serie',
        'precision',
        'suministro_energia',
        'salida_modelo', 
        'fecha'
    ];
}
