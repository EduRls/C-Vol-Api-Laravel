<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;

    protected $table = 'almacen';

    protected $fillable = [
        'id_planta',
        'clave_almacen',
        'localizacion_descripcion_almacen',
        'vigencia_calibracion_tanque',
        'capacidad_almacen',
        'capacidad_operativa',
        'capacidad_util',
        'capacidad_fondaje',
        'volumen_minimo_operacion',
        'estado_tanque'
    ];

    public function registrosEntradasSalidasAlmacen()
    {
        return $this->hasMany(RegistroLlenadoAlmacen::class, 'id_almacen', 'id');
    }
}
