<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroLlenadoAlmacen extends Model
{
    use HasFactory;

    protected $table = "registro_llenado_almacen";

    protected $fillable = [
        'id_planta',
        "nombre_contenedor",
        "cantidad_inical",
        "cantidad_final",
        "fecha_llenado"
    ];
}
