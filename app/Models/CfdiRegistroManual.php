<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CfdiRegistroManual extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table = 'cfdi_registro_manual';

    protected $fillable = [
        'uuid',
        'tipo_cfdi',
        'rfc_emisor',
        'rfc_receptor',
        'volumen_litros',
        'importe_total',
        'fecha_hora_operacion',
        'observaciones'
    ];

}
