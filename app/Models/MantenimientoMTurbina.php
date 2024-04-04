<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MantenimientoMTurbina extends Model
{
    use HasFactory;
    
    protected $table = "mantenimiento_medidor_turbina";

    protected $fillable = [ 
        'id_planta',
        'id_medidor', 
        'tipo_mantenimiento',
        'responsable',
        'estado',
        'observaciones'
    ];
}
