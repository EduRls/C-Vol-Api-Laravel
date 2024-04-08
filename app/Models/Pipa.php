<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pipa extends Model
{
    use HasFactory;

    protected $table = "pipa";

    protected $fillable = [
        'id_planta',
        'clave_pipa',
        'localizacion_descripcion_pipa',
        'vigencia_calibracion_tanque',
        'responsable_pipa',
        'capacidad_pipa',
        'capacidad_operativa',
        'capacidad_util',
        'capacidad_fondaje',
        'volumen_minimo_operacion',
        'estado_tanque',
    ];

    // Define la relación con el modelo RegistroEntradasSalidasPipa
    public function registrosEntradasSalidasPipa()
    {
        return $this->hasMany(RegistroEntradasSalidasPipa::class, 'id_pipa', 'id');
    }
}
